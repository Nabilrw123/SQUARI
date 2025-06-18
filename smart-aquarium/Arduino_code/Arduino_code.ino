#include <ESP8266WiFi.h>
#include <Firebase_ESP_Client.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include <Wire.h>
#include <Adafruit_BME280.h>
#include <Servo.h>
#include <NTPClient.h>
#include <WiFiUdp.h>
#include <time.h>

// — WiFi & Firebase Credentials —
#define WIFI_SSID         "sul"
#define WIFI_PASSWORD     "123456789"
#define API_KEY           "AIzaSyC6zxY_ljbhoQEMbZYHuDRNZ2GGUbswQes"
#define DATABASE_URL      "https://smart-aquarium-3720d-default-rtdb.asia-southeast1.firebasedatabase.app/"
#define FIREBASE_EMAIL    "project@gmail.com"
#define FIREBASE_PASSWORD "123456"

// — Firebase Paths —
#define PATH_SENSOR       "/dashboard/sensor"
#define PATH_HISTORY      "/dashboard/history/sensor"
#define PATH_FEED_CONTROL "/dashboard/control/pakan"
#define PATH_LAST_FEED    "/dashboard/status/last_feed"
#define PATH_BUZZER_STAT  "/dashboard/status/buzzer"
#define PATH_WL_LOW       "/dashboard/status/water_level_low"
#define PATH_WL_HIGH      "/dashboard/status/water_level_high"

// — Pins —
#define DS18B20_PIN       14  // D5
#define SDA_PIN            5  // D1
#define SCL_PIN            4  // D2
#define SERVO_PIN         16  // D0
#define TRIG_PIN          13  // D7
#define ECHO_PIN          12  // D6
#define BUZZER_PIN         2  // D4
#define BUTTON_PIN        15  // D8

#define WATER_LEVEL_MAX    3
#define WATER_LEVEL_MIN   10

// — Firebase & Networking —
FirebaseData fbdo;
FirebaseAuth auth;
FirebaseConfig config;
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", 7*3600, 60000);

// — Sensors & Actuators —
OneWire oneWire(DS18B20_PIN);
DallasTemperature ds18b20(&oneWire);
Adafruit_BME280 bme;
Servo feedingServo;

// — State —
unsigned long lastSensorUpdate = 0;
const unsigned long SENSOR_INTERVAL = 60000;  // 1 menit
bool buzzerEnabled = true;
int  waterLevelLow  = 20;
int  waterLevelHigh = 80;

// — Feeding Control —
unsigned long lastFeedTime       = 0;
const unsigned long feedCooldown = 1000;    // 10 detik
static bool lastButtonState      = HIGH;
static bool lastFirebaseState    = false;

void setup() {
  Serial.begin(115200);
  delay(200);

  // pin modes
  pinMode(TRIG_PIN, OUTPUT);
  pinMode(ECHO_PIN, INPUT);
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(BUTTON_PIN, INPUT_PULLUP);

  // servo init
  feedingServo.attach(SERVO_PIN);
  delay(200);
  feedingServo.write(90);

  // WiFi
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.print("WiFi ");
  while (WiFi.status() != WL_CONNECTED) {
    delay(300); Serial.print(".");
  }
  Serial.println(" connected");

  // configure local time for history timestamps
  configTime(7*3600, 0, "pool.ntp.org");

  // Firebase & NTPClient
  timeClient.begin();
  config.api_key      = API_KEY;
  config.database_url = DATABASE_URL;
  auth.user.email    = FIREBASE_EMAIL;
  auth.user.password = FIREBASE_PASSWORD;
  Firebase.begin(&config, &auth);
  Firebase.reconnectWiFi(true);

  // sensors
  ds18b20.begin();
  Wire.begin(SDA_PIN, SCL_PIN);
  Wire.setClock(100000);
  if (!bme.begin(0x76) && !bme.begin(0x77)) {
    Serial.println("BME280 init failed");
    while (1) delay(500);
  }

  // reset feed flag
  Firebase.RTDB.setBool(&fbdo, PATH_FEED_CONTROL, false);

  Serial.println("Setup done");
}

void loop() {
  unsigned long now = millis();

  // 1) Periodic sensor update + history
  if (now - lastSensorUpdate >= SENSOR_INTERVAL) {
    lastSensorUpdate = now;
    float t1 = readDS18B20();
    float t2 = bme.readTemperature();
    float h  = bme.readHumidity();
    float p  = bme.readPressure() / 100.0F;
    int   wl = readWaterLevel();

    updateFirebaseData(t1,t2,h,p,wl);
    saveSensorHistory(t1,t2,h,p,wl);
    if (buzzerEnabled) checkWaterLevel(wl);
  }

  // 2) Physical button — edge detect
  bool btn = digitalRead(BUTTON_PIN);
  if (btn == LOW && lastButtonState == HIGH && now - lastFeedTime > feedCooldown) {
    Serial.println("Button feed");
    activateFeeding();
    lastFeedTime = now;
  }
  lastButtonState = btn;

  // 3) Firebase control — edge detect
  if (Firebase.RTDB.getBool(&fbdo, PATH_FEED_CONTROL)) {
    bool fbState = fbdo.to<bool>();
    if (fbState && !lastFirebaseState && now - lastFeedTime > feedCooldown) {
      Serial.println("Firebase feed");
      activateFeeding();
      lastFeedTime = now;
    }
    lastFirebaseState = fbState;
  }
}

float readDS18B20() {
  ds18b20.requestTemperatures();
  return ds18b20.getTempCByIndex(0);
}

int readWaterLevel() {
  digitalWrite(TRIG_PIN, LOW);  delayMicroseconds(2);
  digitalWrite(TRIG_PIN, HIGH); delayMicroseconds(10);
  digitalWrite(TRIG_PIN, LOW);
  long dur = pulseIn(ECHO_PIN, HIGH);
  float dist = dur * 0.034 / 2.0;
  return constrain(map(dist,WATER_LEVEL_MIN, WATER_LEVEL_MAX,100,0),0,100);
}

void checkWaterLevel(int lvl) {
  if (Firebase.RTDB.getInt(&fbdo, PATH_WL_LOW))
    waterLevelLow  = fbdo.to<int>();
  if (Firebase.RTDB.getInt(&fbdo, PATH_WL_HIGH))
    waterLevelHigh = fbdo.to<int>();
  if (lvl < waterLevelLow)       tone(BUZZER_PIN,1000,500);
  else if (lvl > waterLevelHigh) tone(BUZZER_PIN,2000,500);
}

void updateFirebaseData(float t1,float t2,float h,float p,int wl) {
  Firebase.RTDB.setFloat(&fbdo, PATH_SENSOR "/suhu_ds18b20", t1);
  Firebase.RTDB.setFloat(&fbdo, PATH_SENSOR "/suhu_bme280",  t2);
  Firebase.RTDB.setFloat(&fbdo, PATH_SENSOR "/kelembapan",   h);
  Firebase.RTDB.setFloat(&fbdo, PATH_SENSOR "/tekanan",      p);
  Firebase.RTDB.setInt(  &fbdo, PATH_SENSOR "/level_air",    wl);
  Firebase.RTDB.setBool( &fbdo, PATH_BUZZER_STAT, buzzerEnabled);
}

void saveSensorHistory(float t1, float t2, float h, float p, int wl) {
  // Ambil waktu lokal
  time_t now = time(nullptr);
  struct tm *ptm = localtime(&now);

  // Format: dd-mm-yyyy_hh:mm:ss
  char buf[25];
  sprintf(buf, "%02d-%02d-%d_%02d:%02d:%02d",
          ptm->tm_mday, ptm->tm_mon + 1, ptm->tm_year + 1900,
          ptm->tm_hour, ptm->tm_min, ptm->tm_sec);

  String path = String(PATH_HISTORY) + "/" + buf;

  Firebase.RTDB.setFloat(&fbdo, path + "/suhu_ds18b20", t1);
  Firebase.RTDB.setFloat(&fbdo, path + "/suhu_bme280",  t2);
  Firebase.RTDB.setFloat(&fbdo, path + "/kelembapan",   h);
  Firebase.RTDB.setFloat(&fbdo, path + "/tekanan",      p);
  Firebase.RTDB.setInt(  &fbdo, path + "/level_air",    wl);
}

void activateFeeding() {
  feedingServo.write(115); delay(700);
  feedingServo.write(90);  delay(200);
  Firebase.RTDB.setBool(&fbdo, PATH_FEED_CONTROL, false);

  // Log waktu pakan terakhir
  time_t now = time(nullptr);
  struct tm *ptm = localtime(&now);
  char buf[20];
  sprintf(buf, "%02d:%02d:%02d", ptm->tm_hour, ptm->tm_min, ptm->tm_sec);
  Firebase.RTDB.setString(&fbdo, PATH_LAST_FEED, buf);
  Serial.println("Fed at " + String(buf));
}
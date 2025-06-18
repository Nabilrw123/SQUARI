@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Profile</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <div class="profile-image-container">
                            <img src="{{ $user->profile_image ? Storage::url('profile/' . $user->profile_image) : asset('images/default-avatar.png') }}" 
                                 alt="Profile" 
                                 class="profile-image"
                                 id="profileImage">
                            <div class="profile-image-overlay" id="uploadTrigger">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" 
                                   id="profileImageInput" 
                                   accept="image/*" 
                                   style="display: none">
                        </div>
                        <h4 class="mt-3">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>

                    <div class="profile-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <p class="form-control-static">{{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <p class="form-control-static">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bergabung Sejak</label>
                                    <p class="form-control-static">{{ $user->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Terakhir Update</label>
                                    <p class="form-control-static">{{ $user->updated_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .profile-image-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 4px solid #ffffff;
        transition: transform 0.3s ease;
    }

    .profile-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .profile-image-container:hover .profile-image-overlay {
        opacity: 1;
    }

    .profile-image-container:hover .profile-image {
        transform: scale(1.1);
    }

    .profile-image-overlay i {
        color: #ffffff;
        font-size: 1.5rem;
    }

    .profile-info {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .form-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .form-control-static {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 500;
        margin: 0;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        border: none;
        padding: 0.625rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadTrigger = document.getElementById('uploadTrigger');
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImage = document.getElementById('profileImage');

    uploadTrigger.addEventListener('click', function() {
        profileImageInput.click();
    });

    profileImageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const formData = new FormData();
            formData.append('profile_image', this.files[0]);

            // Show loading state
            profileImage.style.opacity = '0.5';

            fetch('{{ route("profile.update-image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    profileImage.src = data.image_url;
                    // Update navbar profile image if exists
                    const navbarProfileImg = document.querySelector('.user-dropdown img');
                    if (navbarProfileImg) {
                        navbarProfileImg.src = data.image_url;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengupload foto profile');
            })
            .finally(() => {
                profileImage.style.opacity = '1';
            });
        }
    });
});
</script>
@endpush
@endsection 
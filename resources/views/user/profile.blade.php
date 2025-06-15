@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<style>
    .profile-container {
        max-width: 700px;
        margin: auto;
        background: #f0fdf4;
        border-radius: 15px;
        padding: 30px;
        font-family: 'Georgia', serif;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 2px solid #6b8e23;
    }

    .avatar-option {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
    }

    .avatar-option:hover {
        border-color: #6b8e23;
    }

    .form-control {
        background-color: rgba(255,255,255,0.5);
        border: none;
        border-radius: 10px;
    }

    .btn-success {
        background-color: #6b8e23;
        border: none;
    }

    .btn-outline-secondary {
        border: none;
    }
</style>

<div class="container mt-5">
    <div class="profile-container">
        <h3 class="text-center mb-4">Edit Profile</h3>

        <form method="POST" action="{{ route('user.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="text-center">
                <img src="{{ asset('avatars/' . (Auth::user()->avatar ?? 'default.jpg')) }}" class="avatar-preview" id="currentAvatar">
                <br>
                <button type="button" class="btn btn-outline-secondary mt-2" data-bs-toggle="modal" data-bs-target="#avatarModal">Change Avatar</button>
                <input type="hidden" name="avatar" id="selectedAvatar" value="{{ Auth::user()->avatar ?? 'default.jpg' }}">
            </div>

            <div class="mt-4">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
            </div>

            <div class="mt-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}" required>
            </div>

            <div class="mt-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
            </div>

            <div class="mt-3">
                <label>New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mt-3">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-4">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Avatar Selection Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <h5 class="text-center mb-3">Choose Your Avatar</h5>
      <div class="d-flex flex-wrap justify-content-center gap-3">
        @foreach(['default.jpg', '1.jpg', '2.jpg', '3.jpg','4.jpg', '5.jpg', '6.jpg', '7.jpg' ] as $avatar)
            <img src="{{ asset('avatars/' . $avatar) }}" class="avatar-option" onclick="selectAvatar('{{ $avatar }}')">
        @endforeach
      </div>
    </div>
  </div>
</div>

<script>
    function selectAvatar(filename) {
        document.getElementById('selectedAvatar').value = filename;
        document.getElementById('currentAvatar').src = `/avatars/${filename}`;
        const modal = bootstrap.Modal.getInstance(document.getElementById('avatarModal'));
        modal.hide();
    }
</script>
@endsection

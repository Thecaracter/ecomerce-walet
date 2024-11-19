@extends('layouts.applanding')

@section('title', 'Edit Profile')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Profile</div>
                    <div class="card-body">
                        <!-- Current Photo Preview -->
                        <div class="text-center mb-4">
                            <img id="currentPhoto"
                                src="{{ auth()->user()->photo ? asset('foto/profile/' . auth()->user()->photo) : asset('foto/profile/2.jpg') }}"
                                class="rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #ff4a17;">
                            <h5 class="mt-2">Current Profile Photo</h5>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label>Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', auth()->user()->name) }}">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', auth()->user()->email) }}">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', auth()->user()->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Profile Photo</label>
                                <div class="custom-file">
                                    <input type="file" name="photo" id="photoInput"
                                        class="form-control @error('photo') is-invalid @enderror" accept="image/*"
                                        onchange="previewImage(this);">
                                </div>
                                @error('photo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                                <!-- New Photo Preview -->
                                <div id="photoPreview" class="text-center mt-3" style="display: none;">
                                    <img id="preview" src="#" class="rounded-circle mb-2"
                                        style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #ff4a17;">
                                    <h5 class="mt-2">New Photo Preview</h5>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label>Password (leave blank to keep current)</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewDiv = document.getElementById('photoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                previewDiv.style.display = 'none';
            }
        }
    </script>
@endsection

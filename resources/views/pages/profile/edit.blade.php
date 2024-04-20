@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">
                        {{ __('Edit profile') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 border-end flex-1 d-flex justify-content-center align-content-center h-100">
                                <form action="{{ route('profile.ajax-update-profile-picture', $user) }}" method="post" id="profile-image-form">
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="{{ $user->getProfileImage() }}"
                                            class="rounded-circle profile-picture mb-2 object-fit-cover" id="preview-image" width="200px" height="200px"
                                            alt="">
                                        <input type="file" class="form-control" id="profile-image" accept="image/png, image/jpeg">
                                    </div>
                                </form>
                            </div>
                            <div class="col-8">
                                <form action="{{ route('profile.update', $user) }}" method="POST">
                                    @method('POST')
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label required">
                                            {{ __('Username') }}
                                        </label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $user->name }}" required>
                                        @error('name')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">
                                            {{ __('Password') }}
                                        </label>
                                        <input type="password" class="form-control" name="password">
                                        @error('password')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">
                                            {{ __('Repeat password') }}
                                        </label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            {{ __('Availability') }}
                                        </label>
                                        <div class="d-flex">
                                            @foreach (json_decode($user->availability) as $availability)
                                                <div class="d-flex flex-column me-3">
                                                    <label for="{{ $availability->day }}">{{ $availability->day }}</label>
                                                    <input type="checkbox" name="availabilities[{{ $availability->day }}]"
                                                        @checked($availability->available)>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('days')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-save me-2"></i>
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/uploadProfilePicture.js'])
@endsection

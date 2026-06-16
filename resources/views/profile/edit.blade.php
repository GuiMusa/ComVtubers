@extends('layouts.base')

@section('title', 'Mon Profil')

@section('content-with-sidebar')
    <div class="col-12">
        <div class="mb-4">
            <h2 class="h3 mb-0 text-dark">{{ __('Profile') }}</h2>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 p-4">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0 p-4">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0 p-4">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

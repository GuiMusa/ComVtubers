@extends('layouts.base')

@section('title', 'Tableau de bord')

@section('content-with-sidebar')
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h2 class="card-title h4 mb-0 text-dark">
                    {{ __('Dashboard') }}
                </h2>
            </div>

            <div class="card-body p-4">
                <div class="alert alert-success border-0 shadow-sm">
                    {{ __("You're logged in!") }}
                </div>
                
                <div class="mt-4">
                    <h5>Bienvenue, {{ Auth::user()->name }} !</h5>
                    <p class="text-muted">Ceci est votre espace personnel.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.landing')

@section('title', 'Beranda')

@section('content')
    <landing-page 
        :user="{{ Auth::check() ? json_encode(Auth::user()) : 'null' }}"
        :stats="{{ json_encode($stats) }}"
        :faqs="{{ json_encode($faqs) }}"
        :testimonis="{{ json_encode($testimonis) }}"
        :beritas="{{ json_encode($beritas) }}"
        hero-image="{{ asset('images/bw-sekolah.webp') }}"
        dashboard-url="{{ Auth::check() ? (Auth::user()->isAdmin() ? route('admin.dashboard') : route('alumni.dashboard')) : '#' }}"
        login-url="{{ route('login') }}">
    </landing-page>
@endsection

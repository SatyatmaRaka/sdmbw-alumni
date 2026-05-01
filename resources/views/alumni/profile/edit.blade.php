@extends('layouts.alumni')

@section('title', 'Edit Profil')

@section('content')
@push('styles')
<style>
    .custom-radius { border-radius: 1rem; }
    .custom-radius-sm { border-radius: 0.75rem; }
    .tracking-wider { letter-spacing: 0.05em; }
    .icon-box { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.25rem; }
    .icon-box-sm { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 0.9rem; }
    .section-title { border-left: 4px solid #1B3A52; padding-left: 10px; margin-bottom: 20px; }
</style>
@endpush
    <profile-form 
        :alumni="{{ json_encode($alumni) }}" 
        action-url="{{ route('alumni.profile.update') }}"
        password-url="{{ route('alumni.profile.updatePassword') }}">
    </profile-form>
@endsection

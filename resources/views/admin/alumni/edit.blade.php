@extends('layouts.admin')

@section('title', 'Edit Alumni')
@section('page-title', 'Edit Data Alumni')

@section('content')
    <admin-alumni-form 
        :alumni="{{ json_encode($alumni->load('user')) }}" 
        :angkatans="{{ json_encode($angkatans) }}"
        action-url="{{ route('admin.alumni.update', $alumni) }}"
        back-url="{{ route('admin.alumni.show', $alumni) }}">
    </admin-alumni-form>
@endsection

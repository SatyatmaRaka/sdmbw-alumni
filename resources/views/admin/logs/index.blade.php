@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')
    <admin-activity-logs 
        :initial-logs="{{ json_encode($logs) }}" 
        :actions="{{ json_encode($actions) }}"
        clear-url="{{ route('admin.logs.clearAll') }}">
    </admin-activity-logs>

    <div class="card shadow-sm border-0 rounded-4 p-3 mt-4 border-start border-info border-4">
        <div class="d-flex align-items-start gap-3">
            <i class="bi bi-info-circle-fill text-info fs-5 mt-1"></i>
            <p class="mb-0 small text-muted">
                <strong>Informasi Keamanan:</strong> Activity logs mencatat setiap perubahan data krusial untuk keperluan audit sistem (Tambah, Verifikasi, Hapus, dan Reset).
            </p>
        </div>
    </div>
@endsection

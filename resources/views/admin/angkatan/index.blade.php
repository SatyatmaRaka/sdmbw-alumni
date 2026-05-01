@extends('layouts.admin')

@section('title', 'Kelola Angkatan')
@section('page-title', 'Kelola Angkatan')

@section('content')
    <angkatan-table 
        :data-prop="{{ json_encode($angkatans->items()) }}"
        :pagination-info="{{ json_encode([
            'current_page' => $angkatans->currentPage(),
            'last_page' => $angkatans->lastPage(),
            'from' => $angkatans->firstItem(),
            'to' => $angkatans->lastItem(),
            'total' => $angkatans->total()
        ]) }}"
        search-prop="{{ $search ?? '' }}"
        create-url="{{ route('admin.angkatan.create') }}">
        
        <template #pagination>
            {{ $angkatans->links() }}
        </template>
    </angkatan-table>
@endsection

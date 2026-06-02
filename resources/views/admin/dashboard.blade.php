@extends('admin.layout', ['title' => 'Dashboard'])

@section('subtitle')
    Manage app content, featured media and live API sync from one clean workspace.
@endsection

@section('actions')
    <x-admin.button variant="secondary" :href="route('admin.categories.create')">+ Category</x-admin.button>
    <x-admin.button :href="route('admin.media.create')">+ Add media</x-admin.button>
@endsection

@section('content')
    <livewire:admin.dashboard-metrics />
@endsection

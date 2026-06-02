@extends('admin.layout', ['title' => 'Dashboard'])

@php
    $categoryCount = \App\Models\Category::count();
    $mediaCount = \App\Models\MediaItem::count();
    $activeMediaCount = \App\Models\MediaItem::where('is_active', true)->count();
@endphp

@section('content')
    <div class="topbar">
        <div>
            <h1>Dashboard</h1>
            <p class="muted">Manage app content from here. Mobile app reads the public JSON API.</p>
        </div>
        <div class="actions">
            <a class="button" href="{{ route('admin.media.create') }}">Add Media</a>
            <a class="button secondary" href="{{ route('admin.categories.create') }}">Add Category</a>
        </div>
    </div>
    <div class="grid">
        <div class="stat">Categories<strong>{{ $categoryCount }}</strong></div>
        <div class="stat">Media Items<strong>{{ $mediaCount }}</strong></div>
        <div class="stat">Active Media<strong>{{ $activeMediaCount }}</strong></div>
    </div>
@endsection

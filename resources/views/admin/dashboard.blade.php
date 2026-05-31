@extends('admin.layout', ['title' => 'Dashboard'])

@php
    $categoryCount = \App\Models\Category::count();
    $mediaCount = \App\Models\MediaItem::count();
    $activeMediaCount = \App\Models\MediaItem::where('is_active', true)->count();
    $featuredMediaCount = \App\Models\MediaItem::where('is_featured', true)->where('is_active', true)->count();
    $apiUrl = route('api.content');
@endphp

@section('content')
    <div class="page-head">
        <div>
            <div class="eyebrow">Content console</div>
            <h1>Overview</h1>
            <p class="lead">Manage categories, wallpapers, bhajans and files. The mobile app reads active content from the public JSON API.</p>
        </div>
        <div class="actions">
            <a class="button" href="{{ route('admin.media.create') }}">Add Media</a>
            <a class="button secondary" href="{{ route('admin.categories.create') }}">Add Category</a>
        </div>
    </div>

    <div class="grid">
        <x-admin.stat-card label="Categories" :value="$categoryCount" note="Only active categories are sent to the app." />
        <x-admin.stat-card label="Media Items" :value="$mediaCount" note="Images, audio, video, books and text entries." />
        <x-admin.stat-card label="Active Featured" :value="$featuredMediaCount" note="Featured active media appears on the app home feed." />
    </div>

    <div class="sync-card">
        <div>
            <div class="eyebrow">Live app sync</div>
            <div class="sync-url">{{ $apiUrl }}</div>
            <p class="lead">After adding data, keep category and media status Active. For home screen items, also enable Featured.</p>
        </div>
        <a class="button secondary" href="{{ $apiUrl }}" target="_blank" rel="noreferrer">Open API</a>
    </div>
@endsection

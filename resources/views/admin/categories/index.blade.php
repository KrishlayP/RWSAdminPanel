@extends('admin.layout', ['title' => 'Categories'])

@section('content')
    <div class="page-head">
        <div>
            <div class="eyebrow">Structure</div>
            <h1>Categories</h1>
            <p class="lead">Categories become tabs/sections in the app when they are Active and have active media.</p>
        </div>
        <a class="button" href="{{ route('admin.categories.create') }}">Add Category</a>
    </div>
    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Title</th><th>Slug</th><th>Items</th><th>Status</th><th>Sort</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="title-cell">{{ $category->title }}</td>
                            <td class="muted small">{{ $category->slug }}</td>
                            <td>{{ $category->media_items_count }}</td>
                            <td>
                                <x-admin.badge :tone="$category->is_active ? 'ok' : 'muted'">
                                    {{ $category->is_active ? 'Active' : 'Hidden' }}
                                </x-admin.badge>
                            </td>
                            <td>{{ $category->sort_order }}</td>
                            <td class="actions">
                                <a class="button secondary" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                <form class="inline" method="post" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category and its media items?')">
                                    @csrf
                                    @method('delete')
                                    <button class="button danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="muted">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

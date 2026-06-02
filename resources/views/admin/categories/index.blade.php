@extends('admin.layout', ['title' => 'Categories'])

@section('content')
    <div class="topbar">
        <h1>Categories</h1>
        <a class="button" href="{{ route('admin.categories.create') }}">Add Category</a>
    </div>
    <div class="panel">
        <table>
            <thead>
                <tr><th>Title</th><th>Slug</th><th>Items</th><th>Status</th><th>Sort</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->media_items_count }}</td>
                        <td><span class="{{ $category->is_active ? 'status' : 'muted' }}">{{ $category->is_active ? 'Active' : 'Hidden' }}</span></td>
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
@endsection

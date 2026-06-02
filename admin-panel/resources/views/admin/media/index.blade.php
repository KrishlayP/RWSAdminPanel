@extends('admin.layout', ['title' => 'Media Items'])

@section('content')
    <div class="topbar">
        <h1>Media Items</h1>
        <a class="button" href="{{ route('admin.media.create') }}">Add Media</a>
    </div>
    <div class="panel">
        <table>
            <thead>
                <tr><th>Title</th><th>Category</th><th>Type</th><th>Status</th><th>Featured</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>
                            {{ $item->title }}
                            <div class="muted">{{ $item->subtitle }}</div>
                        </td>
                        <td>{{ $item->category?->title }}</td>
                        <td>{{ ucfirst($item->type) }}</td>
                        <td><span class="{{ $item->is_active ? 'status' : 'muted' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td>{{ $item->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="actions">
                            <a class="button secondary" href="{{ route('admin.media.edit', $item) }}">Edit</a>
                            <form class="inline" method="post" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Delete this media item?')">
                                @csrf
                                @method('delete')
                                <button class="button danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="muted">No media items yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <p>{{ $items->links() }}</p>
    </div>
@endsection

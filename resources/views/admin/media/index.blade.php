@extends('admin.layout', ['title' => 'Media Items'])

@section('content')
    <div class="page-head">
        <div>
            <div class="eyebrow">Library</div>
            <h1>Media Items</h1>
            <p class="lead">Active items appear in category pages. Featured active image/audio items also appear on the app home feed.</p>
        </div>
        <a class="button" href="{{ route('admin.media.create') }}">Add Media</a>
    </div>
    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Title</th><th>Category</th><th>Type</th><th>Status</th><th>Featured</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>
                                <div class="title-cell">{{ $item->title }}</div>
                                <div class="muted small">{{ $item->subtitle ?: $item->size_label }}</div>
                            </td>
                            <td>{{ $item->category?->title ?? 'No category' }}</td>
                            <td><x-admin.badge tone="brand">{{ ucfirst($item->type) }}</x-admin.badge></td>
                            <td>
                                <x-admin.badge :tone="$item->is_active ? 'ok' : 'muted'">
                                    {{ $item->is_active ? 'Active' : 'Hidden' }}
                                </x-admin.badge>
                            </td>
                            <td>
                                <x-admin.badge :tone="$item->is_featured ? 'ok' : 'muted'">
                                    {{ $item->is_featured ? 'Yes' : 'No' }}
                                </x-admin.badge>
                            </td>
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
        </div>
        <div class="panel pad">{{ $items->links() }}</div>
    </div>
@endsection

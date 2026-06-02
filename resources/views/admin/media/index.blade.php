@extends('admin.layout', ['title' => 'Media Items'])

@section('subtitle')
    Active items appear in category pages. Featured active image/audio items also appear on the app home feed.
@endsection

@section('actions')
    <x-admin.button :href="route('admin.media.create')">+ Add Media</x-admin.button>
@endsection

@section('content')
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Title</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Category</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Type</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Status</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Featured</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-4">
                                <div class="text-sm font-semibold text-slate-950">{{ $item->title }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $item->subtitle ?: $item->size_label }}</div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-600">{{ $item->category?->title ?? 'No category' }}</td>
                            <td class="px-5 py-4"><x-admin.badge tone="brand">{{ ucfirst($item->type) }}</x-admin.badge></td>
                            <td class="px-5 py-4">
                                <x-admin.badge :tone="$item->is_active ? 'ok' : 'muted'">
                                    {{ $item->is_active ? 'Active' : 'Hidden' }}
                                </x-admin.badge>
                            </td>
                            <td class="px-5 py-4">
                                <x-admin.badge :tone="$item->is_featured ? 'ok' : 'muted'">
                                    {{ $item->is_featured ? 'Yes' : 'No' }}
                                </x-admin.badge>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a class="inline-flex min-h-9 items-center rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700" href="{{ route('admin.media.edit', $item) }}">Edit</a>
                                    <form class="inline" method="post" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Delete this media item?')">
                                        @csrf
                                        @method('delete')
                                        <button class="inline-flex min-h-9 items-center rounded-lg bg-red-500 px-3 text-sm font-semibold text-white" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">No media items yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 px-5 py-4">
            {{ $items->links() }}
        </div>
    </div>
@endsection

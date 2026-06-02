@extends('admin.layout', ['title' => 'Categories'])

@section('subtitle')
    Categories become tabs and sections in the app when they are Active and have active media.
@endsection

@section('actions')
    <x-admin.button :href="route('admin.categories.create')">+ Add Category</x-admin.button>
@endsection

@section('content')
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Title</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Slug</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Items</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Status</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Sort</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-4 text-sm font-semibold text-slate-950">{{ $category->title }}</td>
                            <td class="px-5 py-4 text-sm text-slate-500">{{ $category->slug }}</td>
                            <td class="px-5 py-4 text-sm text-slate-700">{{ $category->media_items_count }}</td>
                            <td class="px-5 py-4">
                                <x-admin.badge :tone="$category->is_active ? 'ok' : 'muted'">
                                    {{ $category->is_active ? 'Active' : 'Hidden' }}
                                </x-admin.badge>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-700">{{ $category->sort_order }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a class="inline-flex min-h-9 items-center rounded-lg border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                    <form class="inline" method="post" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category and its media items?')">
                                        @csrf
                                        @method('delete')
                                        <button class="inline-flex min-h-9 items-center rounded-lg bg-red-500 px-3 text-sm font-semibold text-white" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

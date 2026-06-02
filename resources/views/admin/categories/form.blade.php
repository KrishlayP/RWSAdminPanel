@extends('admin.layout', ['title' => $category->exists ? 'Edit Category' : 'Add Category'])

@section('subtitle')
    Keep slugs stable after publishing because the app uses them as category IDs.
@endsection

@section('actions')
    <x-admin.button variant="secondary" :href="route('admin.categories.index')">Back</x-admin.button>
@endsection

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        <form method="post" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if ($category->exists)
                @method('put')
            @endif

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="title">Title</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="title" name="title" value="{{ old('title', $category->title) }}" required>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="slug">Slug</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="auto from title">
                    <div class="mt-2 text-xs leading-5 text-slate-500">Leave blank for automatic slug. Avoid changing it after the app is live.</div>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="description">Description</label>
                    <textarea class="min-h-28 w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="description" name="description">{{ old('description', $category->description) }}</textarea>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="sort_order">Sort Order</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                </div>
                <label class="flex min-h-12 items-center gap-3 rounded-xl border border-slate-200 px-3 text-sm font-medium text-slate-700">
                    <input class="rounded border-slate-300 text-emerald-600" name="is_active" type="checkbox" value="1" @checked(old('is_active', $category->is_active ?? true))>
                    Active
                </label>
            </div>

            <div class="mt-6">
                <x-admin.button type="submit">Save Category</x-admin.button>
            </div>
        </form>
    </div>
@endsection

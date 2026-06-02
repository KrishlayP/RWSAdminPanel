@extends('admin.layout', ['title' => $item->exists ? 'Edit Media' : 'Add Media'])

@section('subtitle')
    Use Active to publish in the app. Use Featured for home screen wallpaper, bhajan or ringtone lists.
@endsection

@section('actions')
    <x-admin.button variant="secondary" :href="route('admin.media.index')">Back</x-admin.button>
@endsection

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        <form method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.media.update', $item) : route('admin.media.store') }}">
            @csrf
            @if ($item->exists)
                @method('put')
            @endif

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="category_id">Category</label>
                    <select class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="category_id" name="category_id" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id', $item->category_id) === (string) $category->id)>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="type">Type</label>
                    <select class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="type" name="type" required>
                        @foreach (['image', 'audio', 'video', 'book', 'text'] as $type)
                            <option value="{{ $type }}" @selected(old('type', $item->type) === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="title">Title</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="title" name="title" value="{{ old('title', $item->title) }}" required>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="subtitle">Subtitle</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="subtitle" name="subtitle" value="{{ old('subtitle', $item->subtitle) }}">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="image_files">Upload Images</label>
                    <input class="w-full rounded-xl border border-dashed border-slate-300 px-3 py-3 text-sm text-slate-600" id="image_files" name="image_files[]" type="file" accept="image/*" multiple>
                    <div class="mt-2 text-xs leading-5 text-slate-500">You can select multiple images. First image becomes the main preview.</div>
                    @if ($item->image_url)
                        <p class="mt-2"><a class="text-sm font-medium text-emerald-700" href="{{ $item->image_url }}" target="_blank">View current main image</a></p>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="image_url">Image URL fallback</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="image_url" name="image_url" type="url" value="{{ old('image_url', $item->image_url) }}" placeholder="https://...">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="media_file">Upload Audio / PDF / File</label>
                    <input class="w-full rounded-xl border border-dashed border-slate-300 px-3 py-3 text-sm text-slate-600" id="media_file" name="media_file" type="file" accept="audio/*,video/*,application/pdf,image/*">
                    @if ($item->media_url)
                        <p class="mt-2"><a class="text-sm font-medium text-emerald-700" href="{{ $item->media_url }}" target="_blank">View current media file</a></p>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="media_url">Download/Media URL fallback</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="media_url" name="media_url" type="url" value="{{ old('media_url', $item->media_url) }}" placeholder="https://...">
                    <div class="mt-2 text-xs leading-5 text-slate-500">React Native needs a public URL, so confirm this opens without login.</div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="size_label">Size Label</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="size_label" name="size_label" value="{{ old('size_label', $item->size_label) }}" placeholder="2.1 MB">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="sort_order">Sort Order</label>
                    <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                </div>
                <label class="flex min-h-12 items-center gap-3 rounded-xl border border-slate-200 px-3 text-sm font-medium text-slate-700">
                    <input class="rounded border-slate-300 text-emerald-600" name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $item->is_featured ?? false))>
                    Featured on home
                </label>
                <label class="flex min-h-12 items-center gap-3 rounded-xl border border-slate-200 px-3 text-sm font-medium text-slate-700">
                    <input class="rounded border-slate-300 text-emerald-600" name="is_active" type="checkbox" value="1" @checked(old('is_active', $item->is_active ?? true))>
                    Active
                </label>
            </div>

            <div class="mt-6">
                <x-admin.button type="submit">Save Media</x-admin.button>
            </div>
        </form>
    </div>
@endsection

@extends('admin.layout', ['title' => $item->exists ? 'Edit Media' : 'Add Media'])

@section('content')
    <div class="page-head">
        <div>
            <div class="eyebrow">Media editor</div>
            <h1>{{ $item->exists ? 'Edit Media' : 'Add Media' }}</h1>
            <p class="lead">Use Active to publish in the app. Use Featured for home screen wallpaper, bhajan or ringtone lists.</p>
        </div>
        <a class="button secondary" href="{{ route('admin.media.index') }}">Back</a>
    </div>
    <div class="panel pad">
        @if ($errors->any())
            <div class="errors">{{ $errors->first() }}</div>
        @endif
        <form method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.media.update', $item) : route('admin.media.store') }}">
            @csrf
            @if ($item->exists)
                @method('put')
            @endif
            <div class="form-grid">
                <div class="field">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id', $item->category_id) === (string) $category->id)>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="type">Type</label>
                    <select id="type" name="type" required>
                        @foreach (['image', 'audio', 'video', 'book', 'text'] as $type)
                            <option value="{{ $type }}" @selected(old('type', $item->type) === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="title">Title</label>
                    <input id="title" name="title" value="{{ old('title', $item->title) }}" required>
                </div>
                <div class="field">
                    <label for="subtitle">Subtitle</label>
                    <input id="subtitle" name="subtitle" value="{{ old('subtitle', $item->subtitle) }}">
                </div>
                <div class="field full">
                    <label for="image_files">Upload Images</label>
                    <input id="image_files" name="image_files[]" type="file" accept="image/*" multiple>
                    <div class="help">You can select multiple images. First image becomes the main preview.</div>
                    @if ($item->image_url)
                        <p><a href="{{ $item->image_url }}" target="_blank">View current main image</a></p>
                    @endif
                </div>
                <div class="field full">
                    <label for="image_url">Image URL fallback</label>
                    <input id="image_url" name="image_url" type="url" value="{{ old('image_url', $item->image_url) }}" placeholder="https://...">
                    <div class="help">Use this when the image is already hosted elsewhere.</div>
                </div>
                <div class="field full">
                    <label for="media_file">Upload Audio / PDF / File</label>
                    <input id="media_file" name="media_file" type="file" accept="audio/*,video/*,application/pdf,image/*">
                    @if ($item->media_url)
                        <p><a href="{{ $item->media_url }}" target="_blank">View current media file</a></p>
                    @endif
                </div>
                <div class="field full">
                    <label for="media_url">Download/Media URL fallback</label>
                    <input id="media_url" name="media_url" type="url" value="{{ old('media_url', $item->media_url) }}" placeholder="https://...">
                    <div class="help">React Native needs a public URL, so confirm this opens without login.</div>
                </div>
                <div class="field">
                    <label for="size_label">Size Label</label>
                    <input id="size_label" name="size_label" value="{{ old('size_label', $item->size_label) }}" placeholder="2.1 MB">
                </div>
                <div class="field">
                    <label for="sort_order">Sort Order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                </div>
                <label class="check">
                    <input name="is_featured" type="checkbox" value="1" @checked(old('is_featured', $item->is_featured ?? false))>
                    Featured on home
                </label>
                <label class="check">
                    <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $item->is_active ?? true))>
                    Active
                </label>
            </div>
            <p><button class="button" type="submit">Save Media</button></p>
        </form>
    </div>
@endsection

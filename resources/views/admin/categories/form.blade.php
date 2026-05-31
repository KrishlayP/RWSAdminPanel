@extends('admin.layout', ['title' => $category->exists ? 'Edit Category' : 'Add Category'])

@section('content')
    <div class="page-head">
        <div>
            <div class="eyebrow">Category editor</div>
            <h1>{{ $category->exists ? 'Edit Category' : 'Add Category' }}</h1>
            <p class="lead">Keep slugs stable after publishing because the app uses them as category IDs.</p>
        </div>
        <a class="button secondary" href="{{ route('admin.categories.index') }}">Back</a>
    </div>
    <div class="panel pad">
        @if ($errors->any())
            <div class="errors">{{ $errors->first() }}</div>
        @endif
        <form method="post" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if ($category->exists)
                @method('put')
            @endif
            <div class="form-grid">
                <div class="field">
                    <label for="title">Title</label>
                    <input id="title" name="title" value="{{ old('title', $category->title) }}" required>
                </div>
                <div class="field">
                    <label for="slug">Slug</label>
                    <input id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="auto from title">
                    <div class="help">Leave blank for automatic slug. Avoid changing it after the app is live.</div>
                </div>
                <div class="field full">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="field">
                    <label for="sort_order">Sort Order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                </div>
                <label class="check">
                    <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $category->is_active ?? true))>
                    Active
                </label>
            </div>
            <p><button class="button" type="submit">Save Category</button></p>
        </form>
    </div>
@endsection

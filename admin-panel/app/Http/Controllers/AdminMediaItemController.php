<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MediaItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminMediaItemController extends Controller
{
    public function index(): View
    {
        return view('admin.media.index', [
            'items' => MediaItem::with('category')->orderByDesc('created_at')->paginate(25),
        ]);
    }

    public function create(): View
    {
        return view('admin.media.form', [
            'item' => new MediaItem(['type' => 'image', 'is_active' => true]),
            'categories' => Category::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        MediaItem::create($this->validated($request));

        return redirect()->route('admin.media.index')->with('status', 'Media item created.');
    }

    public function edit(MediaItem $medium): View
    {
        return view('admin.media.form', [
            'item' => $medium,
            'categories' => Category::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, MediaItem $medium): RedirectResponse
    {
        $medium->update($this->validated($request));

        return redirect()->route('admin.media.index')->with('status', 'Media item updated.');
    }

    public function destroy(MediaItem $medium): RedirectResponse
    {
        $medium->delete();

        return redirect()->route('admin.media.index')->with('status', 'Media item deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'type' => ['required', 'in:image,audio,video,book,text'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'image_files' => ['nullable', 'array'],
            'image_files.*' => ['image', 'max:5120'],
            'media_url' => ['nullable', 'url', 'max:2048'],
            'media_file' => ['nullable', 'file', 'max:20480'],
            'size_label' => ['nullable', 'string', 'max:64'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        unset($data['image_files'], $data['media_file']);

        $imageUrls = [];

        foreach ($request->file('image_files', []) as $imageFile) {
            $imageUrls[] = Storage::disk('public')->url(
                $imageFile->store('media/images', 'public'),
            );
        }

        if ($data['image_url'] ?? null) {
            array_unshift($imageUrls, $data['image_url']);
        }

        if ($imageUrls) {
            $data['image_url'] = $imageUrls[0];
            $data['gallery_urls'] = array_values(array_unique($imageUrls));
        }

        if ($request->hasFile('media_file')) {
            $mediaPath = $request->file('media_file')->store('media/files', 'public');
            $data['media_url'] = Storage::disk('public')->url($mediaPath);
            $data['size_label'] = $data['size_label'] ?: $this->formatBytes($request->file('media_file')->getSize());
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        return max(1, round($bytes / 1024)).' KB';
    }
}

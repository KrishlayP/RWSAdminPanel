<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MediaItem;
use Illuminate\Http\JsonResponse;

class ApiContentController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with(['mediaItems' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')->orderBy('title')])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $categoryContent = $categories->mapWithKeys(fn (Category $category) => [
            $category->slug => [
                'title' => $category->title,
                'description' => $category->description,
                'items' => $category->mediaItems->map(fn (MediaItem $item) => $this->formatItem($item))->values(),
            ],
        ]);

        $mediaItems = MediaItem::query()
            ->with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->map(fn (MediaItem $item) => [
                'id' => (string) $item->id,
                'type' => $item->type === 'image' ? 'wallpaper' : ($item->type === 'audio' ? 'song' : $item->type),
                'size' => $item->size_label,
                'categoryId' => $item->category?->slug,
                'image' => $item->image_url,
                'images' => $item->gallery_urls ?: array_values(array_filter([$item->image_url])),
                'title' => $item->title,
            ])
            ->values();

        return response()->json([
            'categories' => $categories->map(fn (Category $category) => [
                'id' => $category->slug,
                'title' => $category->title,
                'description' => $category->description,
            ])->values(),
            'categoryContent' => $categoryContent,
            'mediaItems' => $mediaItems,
        ]);
    }

    private function formatItem(MediaItem $item): array
    {
        return [
            'id' => (string) $item->id,
            'title' => $item->title,
            'subtitle' => $item->subtitle,
            'type' => $item->type,
            'image' => $item->image_url,
            'images' => $item->gallery_urls ?: array_values(array_filter([$item->image_url])),
            'mediaUrl' => $item->media_url,
            'size' => $item->size_label,
        ];
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\MediaItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DashboardMetrics extends Component
{
    public int $refreshes = 0;

    public function refreshMetrics(): void
    {
        Cache::store('file')->forget('admin.dashboard.metrics');
        $this->refreshes++;
    }

    public function render(): View
    {
        $metrics = Cache::store('file')->remember('admin.dashboard.metrics', now()->addMinutes(5), function () {
            $categoryCount = Category::query()->count();
            $mediaCount = MediaItem::query()->count();
            $activeMediaCount = MediaItem::query()->where('is_active', true)->count();
            $featuredMediaCount = MediaItem::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->count();
            $imageCount = MediaItem::query()->where('type', 'image')->count();
            $audioCount = MediaItem::query()->where('type', 'audio')->count();

            return [
                'activeMediaCount' => $activeMediaCount,
                'audioCount' => $audioCount,
                'categoryCount' => $categoryCount,
                'featuredMediaCount' => $featuredMediaCount,
                'imageCount' => $imageCount,
                'mediaCount' => $mediaCount,
                'otherCount' => max(0, $mediaCount - $imageCount - $audioCount),
            ];
        });

        return view('livewire.admin.dashboard-metrics', [
            ...$metrics,
            'apiUrl' => route('api.content'),
        ]);
    }
}

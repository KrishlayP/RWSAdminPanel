<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MediaItem;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'wallpapers', 'title' => 'Wallpapers', 'description' => 'HD devotional wallpapers for mobile screens.'],
            ['slug' => 'ringtone', 'title' => 'Ringtones', 'description' => 'Short bhakti ringtone collection.'],
            ['slug' => 'aarti', 'title' => 'Aarti Bhajan', 'description' => 'Popular aarti and bhajan collection.'],
            ['slug' => 'tv', 'title' => 'Sanatan TV', 'description' => 'Live and recorded devotional programs.'],
            ['slug' => 'books', 'title' => 'Books', 'description' => 'Devotional books and reading material.'],
            ['slug' => 'mantra', 'title' => 'Mantra and Stuti', 'description' => 'Mantras, stuti and devotional chants.'],
            ['slug' => 'status', 'title' => 'Status', 'description' => 'Ready-to-share devotional status templates.'],
            ['slug' => 'horoscope', 'title' => "Today's Horoscope", 'description' => 'Daily horoscope content.'],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category + ['sort_order' => $index + 1, 'is_active' => true],
            );
        }

        $items = [
            ['wallpapers', 'image', 'Mahadev Trishul HD', '1080x1920 mobile wallpaper', 'https://images.unsplash.com/photo-1631217879881-e7eb7ea652a3?auto=format&fit=crop&w=900&q=80', null, '2.1 MB', true],
            ['wallpapers', 'image', 'Morning Temple Darshan', '4K peaceful devotional wallpaper', 'https://images.unsplash.com/photo-1606293927186-20fad5f0a1db?auto=format&fit=crop&w=900&q=80', null, '1.8 MB', true],
            ['ringtone', 'audio', 'Om Namah Shivay Tone', '30 sec ringtone', null, null, '420 KB', true],
            ['ringtone', 'audio', 'Jai Shri Ram Tone', '24 sec ringtone', null, null, '390 KB', false],
            ['aarti', 'audio', 'Ganesh Aarti', 'Morning prayer 5:12', null, null, '4.9 MB', true],
            ['aarti', 'audio', 'Hanuman Chalisa', 'Devotional 7:45', null, null, '5.4 MB', false],
            ['mantra', 'audio', 'Mahamrityunjaya Mantra', '108 times audio', null, null, '5.0 MB', true],
            ['status', 'image', 'Good Morning Bhakti Status', 'Image status 1080x1080', 'https://images.unsplash.com/photo-1604079628040-94301bb21b91?auto=format&fit=crop&w=900&q=80', null, '900 KB', true],
        ];

        foreach ($items as $index => [$slug, $type, $title, $subtitle, $imageUrl, $mediaUrl, $size, $featured]) {
            $category = Category::where('slug', $slug)->firstOrFail();

            MediaItem::updateOrCreate(
                ['category_id' => $category->id, 'title' => $title],
                [
                    'type' => $type,
                    'subtitle' => $subtitle,
                    'image_url' => $imageUrl,
                    'media_url' => $mediaUrl,
                    'size_label' => $size,
                    'sort_order' => $index + 1,
                    'is_featured' => $featured,
                    'is_active' => true,
                ],
            );
        }
    }
}

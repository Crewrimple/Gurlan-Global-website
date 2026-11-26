<?php

namespace App\Services;

use App\Models\ContentBlock;
use App\Models\MediaAsset;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class SiteContentService
{
    private ?Collection $blocks = null;

    private ?Collection $media = null;

    private ?Collection $settings = null;

    public function text(string $locale, string $page, string $key): string
    {
        $override = $this->loadBlocks()->get($page.'|'.$key.'|'.$locale);

        return $override ?? (string) data_get(config('site_content.pages'), "$page.$key.values.$locale", '');
    }

    public function setting(string $key): string
    {
        return $this->loadSettings()->get($key)
            ?? (string) data_get(config('site_content.settings'), "$key.value", '');
    }

    public function media(string $key): string
    {
        $path = $this->loadMedia()->get($key)
            ?? (string) data_get(config('site_content.media'), "$key.path", '');

        if ($path === '' || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'gurlan-assets/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    private function loadBlocks(): Collection
    {
        if ($this->blocks === null) {
            $this->blocks = ContentBlock::query()
                ->get(['page', 'key', 'locale', 'value'])
                ->keyBy(fn (ContentBlock $block): string => $block->page.'|'.$block->key.'|'.$block->locale)
                ->map(fn (ContentBlock $block): string => $block->value);
        }

        return $this->blocks;
    }

    private function loadMedia(): Collection
    {
        if ($this->media === null) {
            $this->media = MediaAsset::query()->pluck('file_path', 'key');
        }

        return $this->media;
    }

    private function loadSettings(): Collection
    {
        if ($this->settings === null) {
            $this->settings = SiteSetting::query()->pluck('value', 'key');
        }

        return $this->settings;
    }
}

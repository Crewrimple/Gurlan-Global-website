<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaAssetController extends Controller
{
    public function index(): View
    {
        return view('admin.media.index', [
            'definitions' => config('site_content.media'),
            'assets' => MediaAsset::query()->with([])->get()->keyBy('key'),
        ]);
    }

    public function update(Request $request, string $medium): RedirectResponse
    {
        $definition = config('site_content.media.'.$medium);
        abort_unless($definition, 422);
        $asset = MediaAsset::query()->firstOrCreate(
            ['key' => $medium],
            ['label' => $definition['label'], 'file_path' => $definition['path']],
        );

        $validated = $request->validate([
            'url' => ['nullable', 'url:http,https', 'max:2000'],
            'file' => [
                'nullable',
                'file',
                $medium === 'home_video' ? 'mimes:mp4,webm' : 'image',
                $medium === 'home_video' ? 'mimetypes:video/mp4,video/webm' : 'mimes:jpg,jpeg,png,webp',
                'max:51200',
                ...($medium === 'logo' ? ['dimensions:min_width=64,min_height=32,max_width=3000,max_height=3000'] : []),
            ],
        ]);

        if (! $request->hasFile('file') && ! filled($validated['url'] ?? null)) {
            return back()->withErrors(['file' => 'Выберите файл или укажите ссылку.']);
        }

        $oldPath = $asset->file_path;
        $path = $request->hasFile('file')
            ? $request->file('file')->storePublicly('media', 'public')
            : $validated['url'];

        $asset->update(['file_path' => $path]);

        if (! str_starts_with($oldPath, 'gurlan-assets/') && ! str_starts_with($oldPath, 'http')) {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()->route('admin.media.index')->with('status', 'Медиафайл обновлён.');
    }
}

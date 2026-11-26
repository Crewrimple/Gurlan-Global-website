<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentBlockController extends Controller
{
    public function index(Request $request): View
    {
        $page = (string) $request->string('page', 'home');
        $pages = config('site_content.pages');
        abort_unless(isset($pages[$page]), 404);

        $stored = ContentBlock::query()
            ->where('page', $page)
            ->get()
            ->keyBy(fn (ContentBlock $block): string => $block->key.'|'.$block->locale);

        return view('admin.content.index', compact('page', 'pages', 'stored'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'blocks' => ['required', 'array'],
            'blocks.*.page' => ['required', 'string'],
            'blocks.*.key' => ['required', 'string'],
            'blocks.*.locale' => ['required', 'in:ru,en,uz'],
            'blocks.*.label' => ['required', 'string', 'max:255'],
            'blocks.*.value' => ['required', 'string'],
        ]);

        $pages = config('site_content.pages');

        foreach ($validated['blocks'] as $block) {
            abort_unless(isset($pages[$block['page']][$block['key']]), 422);

            ContentBlock::query()->updateOrCreate(
                [
                    'page' => $block['page'],
                    'key' => $block['key'],
                    'locale' => $block['locale'],
                ],
                [
                    'label' => $block['label'],
                    'value' => $block['value'],
                ],
            );
        }

        return redirect()
            ->route('admin.content.index', ['page' => $validated['blocks'][0]['page']])
            ->with('status', 'Тексты сохранены.');
    }
}

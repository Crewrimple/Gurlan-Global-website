<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsPostController extends Controller
{
    public function index(): View
    {
        return view('admin.news.index', ['posts' => NewsPost::latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.news.form', ['post' => new NewsPost]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateNews($request);
        $validated['image_path'] = $request->hasFile('image')
            ? $request->file('image')->storePublicly('news', 'public')
            : null;
        $validated['published_at'] = $request->boolean('is_published')
            ? $request->date('published_at', 'Y-m-d\TH:i')
            : null;
        NewsPost::create($validated);

        return redirect()->route('admin.news.index')->with('status', 'Новость сохранена.');
    }

    public function edit(NewsPost $news): View
    {
        return view('admin.news.form', ['post' => $news]);
    }

    public function update(Request $request, NewsPost $news): RedirectResponse
    {
        $validated = $this->validateNews($request);

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }

            $validated['image_path'] = $request->file('image')->storePublicly('news', 'public');
        }

        $validated['published_at'] = $request->boolean('is_published')
            ? $request->date('published_at', 'Y-m-d\TH:i')
            : null;
        $news->update($validated);

        return redirect()->route('admin.news.index')->with('status', 'Новость обновлена.');
    }

    public function destroy(NewsPost $news): RedirectResponse
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Новость удалена.');
    }

    /** @return array<string, mixed> */
    private function validateNews(Request $request): array
    {
        return $request->validate([
            'title_ru' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_uz' => ['required', 'string', 'max:255'],
            'summary_ru' => ['nullable', 'string', 'max:2000'],
            'summary_en' => ['nullable', 'string', 'max:2000'],
            'summary_uz' => ['nullable', 'string', 'max:2000'],
            'body_ru' => ['required', 'string'],
            'body_en' => ['required', 'string'],
            'body_uz' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'dimensions:min_width=600,min_height=338,max_width=12000,max_height=12000', 'max:8192'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}

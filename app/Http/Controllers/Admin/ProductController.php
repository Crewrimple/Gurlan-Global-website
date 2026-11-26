<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = '%'.$request->string('search')->trim().'%';
                $query->where(function ($query) use ($search): void {
                    $query->where('name_ru', 'like', $search)
                        ->orWhere('name_en', 'like', $search)
                        ->orWhere('name_uz', 'like', $search);
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->string('status') === 'active'))
            ->orderBy('category')
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'hiddenProducts' => Product::where('is_active', false)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', ['product' => new Product]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        $validated['image_path'] = $request->file('image')->storePublicly('products', 'public');
        $validated['is_active'] = $request->boolean('is_active');
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('status', 'Продукт добавлен.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, false);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $this->deleteUploadedFile($product->image_path);
            $validated['image_path'] = $request->file('image')->storePublicly('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('status', 'Продукт обновлён.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteUploadedFile($product->image_path);
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Продукт удалён.');
    }

    /** @return array<string, mixed> */
    private function validateProduct(Request $request, bool $requiresImage = true): array
    {
        return $request->validate([
            'category' => ['required', 'in:women,men,fabric'],
            'name_ru' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_uz' => ['required', 'string', 'max:255'],
            'description_ru' => ['nullable', 'string', 'max:3000'],
            'description_en' => ['nullable', 'string', 'max:3000'],
            'description_uz' => ['nullable', 'string', 'max:3000'],
            'image' => [$requiresImage ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function deleteUploadedFile(string $path): void
    {
        if (! str_starts_with($path, 'gurlan-assets/')) {
            Storage::disk('public')->delete($path);
        }
    }
}

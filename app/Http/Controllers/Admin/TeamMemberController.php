<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.team.index', ['members' => TeamMember::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.team.form', ['member' => new TeamMember]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMember($request);
        $validated['image_path'] = $request->file('image')->storePublicly('team', 'public');
        TeamMember::create($validated);

        return redirect()->route('admin.team.index')->with('status', 'Сотрудник добавлен.');
    }

    public function edit(TeamMember $team): View
    {
        return view('admin.team.form', ['member' => $team]);
    }

    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $validated = $this->validateMember($request, false);

        if ($request->hasFile('image')) {
            $this->deleteUploadedFile($team->image_path);
            $validated['image_path'] = $request->file('image')->storePublicly('team', 'public');
        }

        $team->update($validated);

        return redirect()->route('admin.team.index')->with('status', 'Сотрудник обновлён.');
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        $this->deleteUploadedFile($team->image_path);
        $team->delete();

        return redirect()->route('admin.team.index')->with('status', 'Сотрудник удалён.');
    }

    /** @return array<string, mixed> */
    private function validateMember(Request $request, bool $requiresImage = true): array
    {
        return $request->validate([
            'name_ru' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_uz' => ['required', 'string', 'max:255'],
            'position_ru' => ['required', 'string', 'max:255'],
            'position_en' => ['required', 'string', 'max:255'],
            'position_uz' => ['required', 'string', 'max:255'],
            'image' => [$requiresImage ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'dimensions:min_width=300,min_height=400,max_width=12000,max_height=12000', 'max:8192'],
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

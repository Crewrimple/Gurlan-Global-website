<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'definitions' => config('site_content.settings'),
            'settings' => SiteSetting::query()->pluck('value', 'key'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['required', 'string', 'max:2000'],
        ]);
        $definitions = config('site_content.settings');

        foreach ($validated['settings'] as $key => $value) {
            abort_unless(isset($definitions[$key]), 422);
            SiteSetting::query()->updateOrCreate(compact('key'), compact('value'));
        }

        return redirect()->route('admin.settings.edit')->with('status', 'Настройки сохранены.');
    }
}

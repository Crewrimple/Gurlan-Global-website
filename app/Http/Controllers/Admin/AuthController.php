<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.login', [
            'setupRequired' => ! User::query()->where('is_admin', true)->exists(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $throttleKey = Str::transliterate(Str::lower($request->string('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            abort(429, 'Слишком много попыток. Повторите позже.');
        }

        if (! User::query()->where('is_admin', true)->exists()) {
            return $this->setup($request);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt([...$credentials, 'is_admin' => true], $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors(['email' => 'Неверный email или пароль.'])->onlyInput('email');
    }

    private function setup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'setup_key' => ['required', 'string', 'min:32'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(16)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        $configuredKey = (string) config('admin.setup_key');

        abort_if($configuredKey === '' || ! hash_equals($configuredKey, $validated['setup_key']), 403);

        $user = Cache::lock('admin:initial-setup', 15)->block(5, function () use ($validated): User {
            abort_if(User::query()->where('is_admin', true)->exists(), 403);

            return User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'is_admin' => true,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

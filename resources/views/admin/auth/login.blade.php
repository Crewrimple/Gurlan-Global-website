<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setupRequired ? 'Первичная настройка' : 'Вход' }} — Gurlan Global</title>
    <link rel="icon" type="image/png" href="{{ asset('gurlan-assets/Gurlan_global-03.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-login">
    <main class="admin-login-card">
        <p class="text-sm font-semibold text-emerald-700">GURLAN GLOBAL TEKS</p>
        <h1 class="mt-2 text-2xl font-semibold">{{ $setupRequired ? 'Создание единственного администратора' : 'Вход в админ-панель' }}</h1>
        <p class="mt-2 text-sm text-stone-500">{{ $setupRequired ? 'Регистрация доступна один раз. Для защиты требуется секретный ключ из ADMIN_SETUP_KEY.' : 'Введите данные администратора.' }}</p>
        @if ($errors->any())
            <div class="mt-5 rounded-xl bg-red-50 p-3 text-sm text-red-800" role="alert">{{ $errors->first() }}</div>
        @endif
        <form class="mt-6 grid gap-4" method="POST" action="{{ route('admin.authenticate') }}">
            @csrf
            @if ($setupRequired)
                <label class="grid gap-1 text-sm">Секретный ключ установки<input class="rounded-xl border border-stone-300 px-3 py-2" type="password" name="setup_key" autocomplete="off" minlength="32" required></label>
                <label class="grid gap-1 text-sm">Имя<input class="rounded-xl border border-stone-300 px-3 py-2" name="name" value="{{ old('name') }}" autocomplete="name" required></label>
            @endif
            <label class="grid gap-1 text-sm">Email<input class="rounded-xl border border-stone-300 px-3 py-2" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required></label>
            <label class="grid gap-1 text-sm">Пароль<input class="rounded-xl border border-stone-300 px-3 py-2" type="password" name="password" autocomplete="{{ $setupRequired ? 'new-password' : 'current-password' }}" required></label>
            @if ($setupRequired)
                <label class="grid gap-1 text-sm">Подтвердите пароль<input class="rounded-xl border border-stone-300 px-3 py-2" type="password" name="password_confirmation" autocomplete="new-password" required></label>
            @else
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" value="1">Запомнить меня</label>
            @endif
            <button class="rounded-xl bg-emerald-700 px-4 py-3 font-medium text-white hover:bg-emerald-800" type="submit">{{ $setupRequired ? 'Создать администратора' : 'Войти' }}</button>
        </form>
    </main>
</body>
</html>

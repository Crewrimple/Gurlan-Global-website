@extends('admin.layouts.admin')

@section('title', 'Команда')
@section('content')
    <div class="flex items-center justify-between gap-4"><h1 class="text-3xl font-semibold">Команда</h1><a class="rounded-xl bg-emerald-700 px-4 py-2 text-sm font-medium text-white" href="{{ route('admin.team.create') }}">Добавить сотрудника</a></div>
    <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($members as $member)
            <article class="rounded-2xl border border-stone-200 bg-white p-5">
                <img class="aspect-square w-full rounded-xl object-cover" src="{{ str_starts_with($member->image_path, 'gurlan-assets/') ? asset($member->image_path) : asset('storage/'.$member->image_path) }}" alt="">
                <h2 class="mt-4 font-semibold">{{ $member->name_ru }}</h2><p class="text-sm text-stone-500">{{ $member->position_ru }}</p>
                <div class="admin-card-actions mt-4"><a class="admin-action-button" href="{{ route('admin.team.edit', $member) }}">Изменить</a><form class="admin-action-form" method="POST" action="{{ route('admin.team.destroy', $member) }}" onsubmit="return confirm('Удалить сотрудника?')">@csrf @method('DELETE')<button class="admin-action-button is-danger" type="submit">Удалить</button></form></div>
            </article>
        @endforeach
    </div>
@endsection

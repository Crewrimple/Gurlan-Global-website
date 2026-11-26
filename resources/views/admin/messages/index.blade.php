@extends('admin.layouts.admin')

@section('title', 'Заявки')
@section('content')
    <div class="admin-message-heading">
        <div>
            <p class="admin-kicker">Обращения клиентов</p>
            <h1 class="text-3xl font-semibold">Заявки</h1>
            <p class="admin-page-description">Все запросы с формы сайта. Новые заявки появляются сверху.</p>
        </div>
        <div class="admin-message-summary">
            <strong>{{ $messages->total() }}</strong>
            <span>{{ trans_choice('заявка|заявки|заявок', $messages->total()) }}</span>
        </div>
    </div>

    <div class="admin-message-list">
        @forelse ($messages as $message)
            <article class="admin-message-card {{ $message->is_read ? '' : 'is-new' }}">
                <div class="admin-message-main">
                    <div class="admin-message-avatar">{{ mb_strtoupper(mb_substr($message->name, 0, 1)) }}</div>
                    <div class="admin-message-person">
                        <div class="admin-message-name-row">
                            <h2>{{ $message->name }}</h2>
                            <span class="admin-message-badge">{{ $message->is_read ? 'Прочитано' : 'Новая' }}</span>
                        </div>
                        <div class="admin-message-contacts">
                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                            <span aria-hidden="true">·</span>
                            <a href="tel:{{ preg_replace('/\s+/', '', $message->phone) }}">{{ $message->phone }}</a>
                            @if ($message->country_name)
                                <span aria-hidden="true">·</span>
                                <span>{{ $message->country_name }}</span>
                            @endif
                        </div>
                    </div>
                    <time datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->format('d.m.Y · H:i') }}</time>
                </div>

                <div class="admin-message-body">{{ $message->message }}</div>

                <div class="admin-card-actions">
                    <a class="admin-action-button" href="tel:{{ preg_replace('/\s+/', '', $message->phone) }}">Позвонить</a>
                    <a class="admin-action-button" href="mailto:{{ $message->email }}">Написать</a>
                    @unless ($message->is_read)
                        <form class="admin-action-form" method="POST" action="{{ route('admin.messages.read', $message) }}">
                            @csrf
                            @method('PATCH')
                            <button class="admin-action-button" type="submit">Отметить прочитанной</button>
                        </form>
                    @endunless
                    <form class="admin-action-form admin-delete-action" method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Удалить заявку?')">
                        @csrf
                        @method('DELETE')
                        <button class="admin-action-button is-danger" type="submit">Удалить</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-empty-state">
                <span aria-hidden="true">✉</span>
                <h2>Новых заявок пока нет</h2>
                <p>Когда посетитель отправит форму на сайте, обращение появится здесь.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-5">{{ $messages->links() }}</div>
@endsection

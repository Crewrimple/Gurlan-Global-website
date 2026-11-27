@extends('layouts.site')

@section('title', $site->text($locale, 'common', 'contact_title'))

@section('content')
    @php
        $english = $locale === 'en';
        $uzbek = $locale === 'uz';
    @endphp

    <section class="contact-page">
        <div class="section-shell">
            <div class="contact-intro">
                <p class="eyebrow">{{ $english ? 'CONTACTS' : ($uzbek ? 'ALOQA' : 'КОНТАКТЫ') }}</p>
                <h1>{{ $site->text($locale, 'contact', 'page_heading') }}</h1>
            </div>

            @if (session('status'))
                <div class="contact-success contact-success-top" role="status" aria-live="polite">
                    <span aria-hidden="true">✓</span>
                    <div>
                        <strong>{{ $english ? 'Request received' : ($uzbek ? 'So‘rov qabul qilindi' : 'Ваша заявка отправлена') }}</strong>
                        <p>{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <div class="contact-methods">
                <article>
                    <h2>{{ $uzbek ? 'Elektron pochta' : 'Email' }}</h2>
                    <a href="mailto:{{ $site->setting('email') }}">{{ $site->setting('email') }}</a>
                </article>
                <article>
                    <h2>{{ $english ? 'Phone' : ($uzbek ? 'Telefon' : 'Телефон') }}</h2>
                    <a href="tel:{{ $site->setting('phone') }}">{{ $site->setting('phone') }}</a>
                </article>
                <article>
                    <h2>Telegram</h2>
                    <a href="{{ $site->setting('telegram') }}" target="_blank" rel="noopener noreferrer">{{ $site->setting('telegram') }}</a>
                </article>
                <article>
                    <h2>WhatsApp</h2>
                    <a href="{{ $site->setting('whatsapp') }}" target="_blank" rel="noopener noreferrer">{{ $site->setting('phone') }}</a>
                </article>
                <article>
                    <h2>Instagram</h2>
                    <a href="{{ $site->setting('instagram') }}" target="_blank" rel="noopener noreferrer">{{ $site->setting('instagram') }}</a>
                </article>
            </div>

            <section class="contact-map-section" id="map">
                <h2>{{ $english ? 'DIRECTIONS' : ($uzbek ? 'YO‘NALISH' : 'СХЕМА ПРОЕЗДА') }}</h2>
                <div class="contact-map">
                    <iframe
                        title="{{ $english ? 'Map to Gurlan Global Teks' : ($uzbek ? 'Gurlan Global Teks manzili xaritada' : 'Карта проезда к Gurlan Global Teks') }}"
                        src="{{ $site->setting('map_embed') }}"
                        loading="lazy"
                        referrerpolicy="no-referrer"
                    ></iframe>
                    <div class="map-caption">
                        <div>
                            <strong>Gurlan Global Teks</strong>
                            <p>{{ $site->text($locale, 'contact', 'map_address') }}</p>
                        </div>
                        <a class="map-route" href="{{ $site->setting('map_directions') }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('gurlan-assets/map-route-qr.png') }}" alt="" width="80" height="80">
                            {{ $english ? 'GET DIRECTIONS' : ($uzbek ? 'YO‘NALISHNI KO‘RISH' : 'ПРОЛОЖИТЬ МАРШРУТ') }} ↗
                        </a>
                    </div>
                </div>
            </section>

            <section class="contact-form-section">
                <div class="contact-form-heading">
                    <p class="eyebrow">{{ $english ? 'REQUEST / 01' : ($uzbek ? 'SO‘ROV / 01' : 'ЗАЯВКА / 01') }}</p>
                    <h2>{{ $site->text($locale, 'contact', 'form_heading') }}</h2>
                    <p>{{ $site->text($locale, 'contact', 'form_intro') }}</p>
                </div>

                <div class="contact-form-showcase">
                    <div class="contact-form-card">
                        <div class="contact-form-card-header">
                            <span>{{ $english ? '01 / REQUEST AN OFFER' : ($uzbek ? '01 / TAKLIF SO‘RASH' : '01 / ЗАПРОСИТЬ ПРЕДЛОЖЕНИЕ') }}</span>
                            <span class="contact-form-card-mark" aria-hidden="true">↗</span>
                        </div>

                        @if ($errors->any())
                            <p class="form-message form-error" role="alert">{{ $errors->first() }}</p>
                        @endif
                        <form class="contact-form" method="POST" action="{{ route('site.contact.store', ['locale' => $locale]) }}" data-contact-form>
                            @csrf
                            <input type="text" name="website" value="" autocomplete="off" tabindex="-1" aria-hidden="true" style="position:absolute;left:-9999px">
                            <div class="contact-fields">
                                <label>
                                    <span>{{ $english ? '[ Company / contact person ]*' : ($uzbek ? '[ Kompaniya / mas’ul shaxs ]*' : '[ Компания / контактное лицо ]*') }}</span>
                                    <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="{{ $english ? 'Company or contact name' : ($uzbek ? 'Kompaniya yoki mas’ul shaxs nomi' : 'Название компании или имя') }}" required>
                                </label>
                                <label>
                                    <span>{{ $uzbek ? '[ Elektron pochta ]*' : '[ E-mail ]*' }}</span>
                                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="name@company.com" required>
                                </label>
                                <label>
                                    <span>{{ $english ? '[ Phone ]*' : ($uzbek ? '[ Telefon ]*' : '[ Телефон ]*') }}</span>
                                    <div class="phone-country-input">
                                        <select name="country" aria-label="{{ $english ? 'Country' : ($uzbek ? 'Mamlakat' : 'Страна') }}" required>
                                            @foreach (config('countries') as $code => $country)
                                                @php
                                                    $flag = implode('', array_map(
                                                        fn (string $letter): string => mb_chr(ord($letter) - 65 + 127462),
                                                        str_split($code),
                                                    ));
                                                @endphp
                                                <option value="{{ $code }}" @selected(old('country', 'UZ') === $code)>{{ $flag }} {{ $country['name'] }} {{ $country['dial'] }}</option>
                                            @endforeach
                                        </select>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel-national" inputmode="tel" placeholder="90 123 45 67" required>
                                    </div>
                                </label>
                                <label class="message-field">
                                    <span>{{ $english ? '[ Product, volume and timeline ]*' : ($uzbek ? '[ Mahsulot, hajm va muddatlar ]*' : '[ Продукция, объём и сроки ]*') }}</span>
                                    <textarea name="message" rows="4" placeholder="{{ $english ? 'Tell us what you are looking for' : ($uzbek ? 'Sizni qaysi mahsulot qiziqtirayotganini yozing' : 'Расскажите, какая продукция вас интересует') }}" required>{{ old('message') }}</textarea>
                                </label>
                            </div>
                            <label class="consent-row">
                                <input type="checkbox" name="consent" required>
                                <span>
                                    {{ $english ? 'I confirm that I have read and agree to the' : ($uzbek ? 'Men quyidagi hujjat bilan tanishganimni tasdiqlayman va' : 'Я подтверждаю ознакомление и даю') }}
                                    <a href="#">{{ $english ? 'personal data processing consent' : ($uzbek ? 'shaxsiy ma’lumotlarni qayta ishlashga rozilik beraman' : 'согласие на обработку моих персональных данных') }}</a>
                                    {{ $english ? 'under the applicable personal data policy.' : ($uzbek ? 'O‘zbekiston Respublikasining amaldagi shaxsiy ma’lumotlarni himoya qilish qonunchiligiga muvofiq.' : 'в соответствии с Законом Республики Узбекистан «О персональных данных» от 02.07.2019 г. № ЗРУ-547 и Политикой обработки персональных данных.') }}
                                </span>
                            </label>
                            <div class="contact-submit-row">
                                <button class="submit-button" type="submit">{{ $english ? 'Send request' : ($uzbek ? 'So‘rov yuborish' : 'Отправить запрос') }} <span>↗</span></button>
                                <div class="captcha-control">
                                    <label>
                                        <span data-captcha-question></span>
                                        <input type="number" name="captcha" inputmode="numeric" required aria-label="{{ $english ? 'Captcha answer' : ($uzbek ? 'Misol javobi' : 'Ответ на пример') }}">
                                    </label>
                                    <button type="button" data-captcha-refresh aria-label="{{ $english ? 'Refresh question' : ($uzbek ? 'Misolni yangilash' : 'Обновить пример') }}">↻</button>
                                </div>
                            </div>
                            <p class="form-message form-error" data-form-error role="alert" hidden></p>
                            <p class="form-message form-success" data-form-note role="status" hidden></p>
                        </form>
                    </div>

                    <div class="contact-form-aside">
                        <a class="contact-aside-card" href="{{ route('site.page', ['locale' => $locale, 'page' => 'products']) }}">
                            <span class="contact-aside-kicker">{{ $english ? '01 / PRODUCT RANGE' : ($uzbek ? '01 / ASSORTIMENT' : '01 / КАТАЛОГ') }}</span>
                            <div>
                                <h3>{{ $english ? 'Explore our products' : ($uzbek ? 'Mahsulotlarimiz bilan tanishing' : 'Ассортимент продукции') }}</h3>
                                <p>{{ $english ? 'Browse our collections and choose a direction for your order.' : ($uzbek ? 'Mahsulotlarimizni ko‘rib chiqing va buyurtmangiz uchun yo‘nalishni tanlang.' : 'Посмотрите ассортимент и выберите направление будущего заказа.') }}</p>
                            </div>
                            <span class="contact-aside-action">{{ $english ? 'View product range' : ($uzbek ? 'Assortimentni ko‘rish' : 'Смотреть ассортимент') }} <b>↗</b></span>
                        </a>
                        <article class="contact-aside-card">
                            <span class="contact-aside-kicker">{{ $english ? '02 / QUICK CONTACT' : ($uzbek ? '02 / TEZKOR ALOQA' : '02 / БЫСТРЫЙ КОНТАКТ') }}</span>
                            <div>
                                <h3>{{ $english ? 'Talk to a manager' : ($uzbek ? 'Menejer bilan bog‘lanish' : 'Связаться с менеджером') }}</h3>
                                <p>{{ $english ? 'Choose the messenger that works best for you.' : ($uzbek ? 'O‘zingizga qulay messenjer orqali yozing — mahsulotlar va hamkorlik haqidagi savollaringizga javob beramiz.' : 'Напишите в удобный мессенджер — ответим на вопросы о продукции и сотрудничестве.') }}</p>
                            </div>
                            <div class="contact-aside-links">
                                <a href="https://t.me/ggt_inc" target="_blank" rel="noopener noreferrer">Telegram ↗</a>
                                <a href="{{ $site->setting('whatsapp') }}" target="_blank" rel="noopener noreferrer">WhatsApp ↗</a>
                            </div>
                        </article>
                        <article class="contact-aside-card">
                            <span class="contact-aside-kicker">{{ $english ? '03 / NEXT STEP' : ($uzbek ? '03 / KEYINGI QADAM' : '03 / ПОСЛЕ ОТПРАВКИ') }}</span>
                            <div>
                                <h3>{{ $english ? 'A clear next step' : ($uzbek ? 'Keyingi qadam aniq' : 'Понятное подтверждение') }}</h3>
                                <p>{{ $english ? 'After verification, your request is securely saved and sent to our team. A manager will contact you.' : ($uzbek ? 'Tekshiruvdan so‘ng so‘rovingiz xavfsiz saqlanadi va jamoamizga yuboriladi. Menejer siz bilan bog‘lanadi.' : 'После проверки заявка безопасно сохраняется и поступает нашей команде. Менеджер свяжется с вами.') }}</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

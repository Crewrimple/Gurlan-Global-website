@extends('layouts.site')

@section('title', $locale === 'en' ? 'Contacts - Gurlan Global Teks' : ($locale === 'uz' ? 'Aloqa - Gurlan Global Teks' : 'Контакты - Gurlan Global Teks'))

@section('content')
    @php
        $english = $locale === 'en';
        $uzbek = $locale === 'uz';
    @endphp

    <section class="contact-page">
        <div class="section-shell">
            <div class="contact-intro">
                <p class="eyebrow">{{ $english ? 'CONTACTS' : ($uzbek ? 'ALOQA' : 'КОНТАКТЫ') }}</p>
                <h1>{{ $english ? "WE'RE HERE TO HELP" : ($uzbek ? 'SIZGA YORDAM BERISHGA TAYYORMIZ' : 'МЫ ЗДЕСЬ, ЧТОБЫ ПОМОЧЬ') }}</h1>
            </div>

            <div class="contact-methods">
                <article>
                    <h2>{{ $uzbek ? 'Elektron pochta' : 'Email' }}</h2>
                    <a href="mailto:gurlanglobal@gmail.com">gurlanglobal@gmail.com</a>
                </article>
                <article>
                    <h2>{{ $english ? 'Phone' : ($uzbek ? 'Telefon' : 'Телефон') }}</h2>
                    <a href="tel:+998919858707">+998 91 985 87 07</a>
                </article>
                <article>
                    <h2>Telegram</h2>
                    <a href="https://t.me/ggt_inc" target="_blank" rel="noopener noreferrer">@ggt_inc</a>
                </article>
                <article>
                    <h2>WhatsApp</h2>
                    <a href="https://wa.me/998919858707" target="_blank" rel="noopener noreferrer">+998 91 985 87 07</a>
                </article>
                <article>
                    <h2>Instagram</h2>
                    <a href="https://www.instagram.com/ggt_textile/" target="_blank" rel="noopener noreferrer">@ggt_textile</a>
                </article>
            </div>

            <section class="contact-map-section" id="map">
                <h2>{{ $english ? 'DIRECTIONS' : ($uzbek ? 'YO‘NALISH' : 'СХЕМА ПРОЕЗДА') }}</h2>
                <div class="contact-map">
                    <iframe
                        title="{{ $english ? 'Map to Gurlan Global Teks' : ($uzbek ? 'Gurlan Global Teks manzili xaritada' : 'Карта проезда к Gurlan Global Teks') }}"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=60.311165%2C41.781346%2C60.441165%2C41.871346&amp;layer=mapnik&amp;marker=41.8263463%2C60.3761645"
                        loading="lazy"
                        referrerpolicy="no-referrer"
                    ></iframe>
                    <div class="map-caption">
                        <div>
                            <strong>Gurlan Global Teks</strong>
                            <p>{{ $english ? 'Mustaqillik Street, 5, Gurlan District, Khorezm Region, Uzbekistan' : ($uzbek ? 'Mustaqillik ko‘chasi, 5, Gurlan tumani, Xorazm viloyati, O‘zbekiston' : 'ул. Мустакиллик, 5, Гурленский район, Хорезмская область, Узбекистан') }}</p>
                        </div>
                        <a class="map-route" href="https://www.google.com/maps/dir/?api=1&amp;destination=41.8263463%2C60.3761645" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('gurlan-assets/map-route-qr.png') }}" alt="" width="80" height="80">
                            {{ $english ? 'GET DIRECTIONS' : ($uzbek ? 'YO‘NALISHNI KO‘RISH' : 'ПРОЛОЖИТЬ МАРШРУТ') }} ↗
                        </a>
                    </div>
                </div>
            </section>

            <section class="contact-form-section">
                <div class="contact-form-heading">
                    <p class="eyebrow">{{ $english ? 'REQUEST / 01' : ($uzbek ? 'SO‘ROV / 01' : 'ЗАЯВКА / 01') }}</p>
                    <h2>{{ $english ? 'Contact us' : ($uzbek ? 'Biz bilan bog‘laning' : 'Свяжитесь с нами') }}</h2>
                    <p>{{ $english ? 'Share a few details about your project and the products you need.' : ($uzbek ? 'Loyihangiz va sizga kerakli mahsulotlar haqida qisqacha ma’lumot bering.' : 'Расскажите о проекте и пожеланиях — форма подготовит письмо с нужной информацией.') }}</p>
                </div>

                <div class="contact-form-showcase">
                    <div class="contact-form-card">
                        <div class="contact-form-card-header">
                            <span>{{ $english ? '01 / REQUEST AN OFFER' : ($uzbek ? '01 / TAKLIF SO‘RASH' : '01 / ЗАПРОСИТЬ ПРЕДЛОЖЕНИЕ') }}</span>
                            <span class="contact-form-card-mark" aria-hidden="true">↗</span>
                        </div>

                        <form class="contact-form" data-contact-form data-contact-email="gurlanglobal@gmail.com">
                            <div class="contact-fields">
                                <label>
                                    <span>{{ $english ? '[ Company / contact person ]*' : ($uzbek ? '[ Kompaniya / mas’ul shaxs ]*' : '[ Компания / контактное лицо ]*') }}</span>
                                    <input type="text" name="name" autocomplete="name" placeholder="{{ $english ? 'Company or contact name' : ($uzbek ? 'Kompaniya yoki mas’ul shaxs nomi' : 'Название компании или имя') }}" required>
                                </label>
                                <label>
                                    <span>{{ $uzbek ? '[ Elektron pochta ]*' : '[ E-mail ]*' }}</span>
                                    <input type="email" name="email" autocomplete="email" placeholder="name@company.com" required>
                                </label>
                                <label>
                                    <span>{{ $english ? '[ Phone ]*' : ($uzbek ? '[ Telefon ]*' : '[ Телефон ]*') }}</span>
                                    <input type="tel" name="phone" autocomplete="tel" placeholder="+998" required>
                                </label>
                                <label class="message-field">
                                    <span>{{ $english ? '[ Product, volume and timeline ]*' : ($uzbek ? '[ Mahsulot, hajm va muddatlar ]*' : '[ Продукция, объём и сроки ]*') }}</span>
                                    <textarea name="message" rows="4" placeholder="{{ $english ? 'Tell us what you are looking for' : ($uzbek ? 'Sizni qaysi mahsulot qiziqtirayotganini yozing' : 'Расскажите, какая продукция вас интересует') }}" required></textarea>
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
                                <a href="https://wa.me/998919858707" target="_blank" rel="noopener noreferrer">WhatsApp ↗</a>
                            </div>
                        </article>
                        <article class="contact-aside-card">
                            <span class="contact-aside-kicker">{{ $english ? '03 / NEXT STEP' : ($uzbek ? '03 / KEYINGI QADAM' : '03 / ПОСЛЕ ОТПРАВКИ') }}</span>
                            <div>
                                <h3>{{ $english ? 'A clear next step' : ($uzbek ? 'Keyingi qadam aniq' : 'Понятное подтверждение') }}</h3>
                                <p>{{ $english ? 'After captcha verification, your e-mail app opens with a prepared message. Send it to reach our team.' : ($uzbek ? 'Tekshiruvdan so‘ng tayyor xabar bilan elektron pochta ilovasi ochiladi. So‘rovingizni yuborish uchun xatni jo‘nating.' : 'После проверки капчи откроется почтовое приложение с подготовленным письмом. Нажмите «Отправить», чтобы передать запрос.') }}</p>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

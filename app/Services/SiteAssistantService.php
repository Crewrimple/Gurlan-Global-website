<?php

namespace App\Services;

use App\Models\NewsPost;
use App\Models\Product;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use UnexpectedValueException;

class SiteAssistantService
{
    public function __construct(private readonly SiteContentService $site) {}

    public function answer(string $question, string $locale): string
    {
        $apiKey = (string) config('services.openai.key');

        if ($apiKey === '') {
            return $this->answerFromSiteKnowledge($this->normalizeQuestion($question), $locale);
        }

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->connectTimeout(5)
            ->timeout(20)
            ->post((string) config('services.openai.endpoint'), [
                'model' => (string) config('services.openai.model'),
                'instructions' => implode(' ', [
                    'You are the helpful website assistant for Gurlan Global Teks.',
                    'Answer only from the supplied website knowledge.',
                    'Do not invent prices, order minimums, delivery dates, certificates, capacities, or company claims.',
                    'If the answer is unavailable, direct the visitor to the contact page and contact details.',
                    "Respond concisely in the language requested ({$locale}), using plain text.",
                ]),
                'input' => "Website knowledge:\n{$this->knowledge($locale)}\n\nVisitor question:\n{$question}",
                'max_output_tokens' => 450,
            ])
            ->throw();

        $payload = $response->json();
        $answer = data_get($payload, 'output_text');

        if (! is_string($answer) || trim($answer) === '') {
            $answer = collect(data_get($payload, 'output', []))
                ->flatMap(fn (array $output): array => data_get($output, 'content', []))
                ->filter(fn (array $content): bool => data_get($content, 'type') === 'output_text')
                ->pluck('text')
                ->filter(fn (mixed $text): bool => is_string($text) && trim($text) !== '')
                ->implode("\n");
        }

        if (trim($answer) === '') {
            throw new UnexpectedValueException('OpenAI returned an empty assistant response.');
        }

        return $this->removeRawUrls($answer);
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    public function actions(string $question, string $locale): array
    {
        $normalizedQuestion = Str::lower($question);
        $actions = [];

        if (preg_match('/продук|ассортимент|product|catalog|mahsulot|assortiment|ip-kalava|yarn|cotton|paxta/u', $normalizedQuestion) === 1) {
            $actions[] = [
                'label' => match ($locale) {
                    'en' => 'View products',
                    'uz' => 'Mahsulotlarni ko‘rish',
                    default => 'Смотреть продукцию',
                },
                'url' => route('site.page', ['locale' => $locale, 'page' => 'products']),
            ];
        }

        if (preg_match('/сертифик|мощност|производ|iso|sedex|oeko|capacity|production|sertifikat|ishlab chiqar|quvvat/u', $normalizedQuestion) === 1) {
            $actions[] = [
                'label' => match ($locale) {
                    'en' => 'View production',
                    'uz' => 'Ishlab chiqarish',
                    default => 'О производстве',
                },
                'url' => route('site.page', ['locale' => $locale, 'page' => 'production']),
            ];
        }

        $actions[] = [
            'label' => match ($locale) {
                'en' => 'Contact our team',
                'uz' => 'Biz bilan bog‘laning',
                default => 'Связаться с нами',
            },
            'url' => route('site.page', ['locale' => $locale, 'page' => 'contact']),
        ];

        return $actions;
    }

    private function knowledge(string $locale): string
    {
        $sections = collect(config('site_content.pages', []))
            ->flatMap(function (array $entries, string $page) use ($locale): array {
                return collect($entries)
                    ->map(function (array $entry, string $key) use ($locale): string {
                        return (string) data_get($entry, "values.{$locale}", '');
                    })
                    ->filter()
                    ->map(fn (string $value, string $key): string => "{$page}.{$key}: {$value}")
                    ->values()
                    ->all();
            })
            ->values()
            ->all();

        $sections[] = 'Company facts: Gurlan Global Teks was founded in 2020. Annual capacity: 4,000 tons of yarn, 3,500 tons of dyed fabric, 4,000 tons of fabric and 6,000,000 garments.';
        $sections[] = 'Certifications: OEKO-TEX, SEDEX and ISO. BCI and Better Cotton certification are in progress.';
        $sections[] = 'Production time: 7-35 working days. Production is private-label/full-cycle.';
        $sections[] = 'Phone: '.$this->site->setting('phone');
        $sections[] = 'Email: '.$this->site->setting('email');
        $sections[] = 'Address: '.$this->site->setting('address_'.$locale);
        $sections[] = 'Telegram: '.$this->site->setting('telegram');
        $sections[] = 'WhatsApp: '.$this->site->setting('whatsapp');
        $sections[] = 'Uzum marketplace: '.$this->site->setting('uzum');

        Product::active()->orderBy('sort_order')->get()->each(function (Product $product) use (&$sections, $locale): void {
            $sections[] = 'Product: '.$product->localized($locale, 'name').' — '.$product->localized($locale, 'description');
        });

        TeamMember::query()->orderBy('sort_order')->limit(20)->get()->each(function (TeamMember $member) use (&$sections, $locale): void {
            $sections[] = 'Team: '.$member->localized($locale, 'name').' — '.$member->localized($locale, 'position');
        });

        NewsPost::published()->latest('published_at')->limit(10)->get()->each(function (NewsPost $post) use (&$sections, $locale): void {
            $sections[] = 'News: '.$post->localized($locale, 'title').' — '.Str::limit(strip_tags($post->localized($locale, 'summary')), 500);
        });

        return Str::limit(implode("\n", $sections), 32000);
    }

    private function answerFromSiteKnowledge(string $question, string $locale): string
    {
        $normalizedQuestion = Str::lower($question);

        if (preg_match('/цен|стоим|price|cost|narx|qancha tur|minimum|минималь|минимум|минимал/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Цена и минимальный объём рассчитываются отдельно для каждого заказа: они зависят от модели, состава ткани, плотности, цвета, отделки, размеров и количества. Чтобы получить точную смету, отправьте заявку команде — желательно указать фото или техническое задание, объём и срок поставки.',
                'Pricing and minimum order quantity are calculated individually for each project and depend on the product, fabric composition, weight, colour, finishing, sizing and quantity. Send the team your reference, technical specification, quantity and required delivery date for an exact quotation.',
                'Narx va minimal buyurtma hajmi har bir loyiha uchun alohida hisoblanadi: mahsulot turi, mato tarkibi va zichligi, rang, pardoz, o‘lcham hamda miqdorga bog‘liq. Aniq taklif olish uchun surat yoki texnik topshiriq, hajm va kerakli muddat bilan jamoamizga murojaat qiling.',
            );
        }

        if (preg_match('/состав|плотност|ткан|fabric|material|composition|tarkib|mato|полотн/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Фабрика производит трикотажные полотна, включая двух- и трёхнитку, кулирку, велюр, интерлок, кашкорсе, махру, пике и супрем. Возможный состав, плотность, окрашивание и отделка уточняются под конкретный заказ и технические требования.',
                'The factory offers knitted fabrics including two-thread and three-thread fleece, single jersey, velour, interlock, rib, terry, piqué and Suprem. Composition, weight, dyeing and finishing are selected according to the specific order and technical requirements.',
                'Fabrika ikki va uch ipli trikotaj, kulirka, velur, interlok, kashkorse, mahra, pike va supremlarni ishlab chiqaradi. Tarkib, zichlik, bo‘yash va pardozlash aniq buyurtma hamda texnik talabga qarab aniqlanadi.',
            );
        }

        if (preg_match('/срок|заказ|достав|месец|дней|день|delivery|lead time|timeline|muddat|buyurtma|yetkaz/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Срок выполнения производственного заказа зависит от модели, объёма и подготовки материалов. На сайте указаны ориентировочные сроки производства — от 7 до 35 рабочих дней. Для точного расчёта менеджеру нужны вид продукции, объём, состав, цвет, размеры и желаемая дата поставки.',
                'Production time depends on the product, quantity and material preparation. The website lists an estimated production period of 7 to 35 working days. For an exact quote, our team needs the product type, quantity, composition, colours, sizes and required delivery date.',
                'Buyurtma muddati mahsulot turiga, hajmiga va materiallar tayyorligiga bog‘liq. Saytda ishlab chiqarish muddati 7 kundan 35 ish kunigacha ko‘rsatilgan. Aniq hisob uchun mahsulot turi, hajmi, tarkibi, rangi, o‘lchamlari va kerakli yetkazib berish sanasini yuboring.',
            );
        }

        if (preg_match('/партнер|сотруд|private|label|brand|стм|brend|hamkor|xususiy|brendingiz/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Gurlan Global Teks производит продукцию для частных брендов под ключ: от собственно выращенного хлопка и пряжи до трикотажа, окрашивания, пошива и упаковки. Мы предлагаем полный цикл, контроль качества на каждом этапе, стабильные поставки и работу по требованиям вашего бренда.',
                'Gurlan Global Teks provides private-label manufacturing from start to finish: cotton and yarn, knitting, dyeing, garment production and packaging. We offer a full-cycle process, quality control at every stage, stable supply and production tailored to your brand requirements.',
                'Gurlan Global Teks xususiy brendlar uchun to‘liq sikl asosida ishlab chiqaradi: paxta va ip-kalavadan to trikotaj, bo‘yash, tikuv va qadoqlashgacha. Brendingiz talablariga mos ishlab chiqarish, har bosqichda sifat nazorati va barqaror yetkazib berishni taklif qilamiz.',
            );
        }

        if (preg_match('/почему|преимущ|выбрать|why|advantage|choose|nega|afzallik|tanlash/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Главные преимущества: вертикально интегрированный цикл без посредников, собственные хлопок и пряжа, современное оборудование, производство до 6 000 000 изделий в год, стандарты ISO, OEKO-TEX и SEDEX, собственные отделы прядения и окрашивания, а также прозрачное сотрудничество с клиентом.',
                'Key advantages include a vertically integrated cycle without intermediaries, our own cotton and yarn, modern equipment, capacity of up to 6,000,000 garments per year, ISO, OEKO-TEX and SEDEX standards, in-house spinning and dyeing, and transparent customer cooperation.',
                'Asosiy afzalliklar: vositachilarsiz vertikal integratsiya, o‘z paxta va ip-kalavasi, zamonaviy uskuna, yiliga 6 000 000 tagacha mahsulot quvvati, ISO, OEKO-TEX va SEDEX standartlari, o‘z yigiruv va bo‘yash ishlab chiqarishi hamda shaffof hamkorlik.',
            );
        }

        if (preg_match('/компан|gurlan|о вас|about|kompaniya|haqida|основан|2020|hozir/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Gurlan Global Teks — текстильный кластер полного цикла из Хорезмской области, основанный в 2020 году. Компания объединяет выращивание хлопка, производство пряжи, вязание, окрашивание, пошив и упаковку. Основной фокус — качество, экспорт, международные стандарты и долгосрочное партнёрство.',
                'Gurlan Global Teks is a full-cycle textile cluster in the Khorezm region, founded in 2020. It brings together cotton farming, yarn production, knitting, dyeing, garment manufacturing and packaging, with a focus on quality, export, international standards and long-term partnerships.',
                'Gurlan Global Teks — 2020-yilda tashkil etilgan Xorazm viloyatidagi to‘liq siklli tekstil klasteri. U paxta yetishtirish, ip-kalava, trikotaj, bo‘yash, tikuv va qadoqlashni birlashtiradi. Asosiy yo‘nalishlar — sifat, eksport, xalqaro standartlar va uzoq muddatli hamkorlik.',
            );
        }

        if (preg_match('/сотруд|работ|персон|команд|team|employee|xodim|ishchi|jamoa/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'В команде Gurlan Global Teks работает более 1 000 квалифицированных сотрудников. Компания объединяет специалистов по сельскому хозяйству, прядению, вязанию, окрашиванию, пошиву, контролю качества и экспорту.',
                'Gurlan Global Teks employs more than 1,000 qualified people across agriculture, spinning, knitting, dyeing, garment production, quality control and export.',
                'Gurlan Global Teksda 1 000 dan ortiq malakali xodim ishlaydi. Jamoa paxtachilik, yigiruv, trikotaj, bo‘yash, tikuvchilik, sifat nazorati va eksport mutaxassislarini birlashtiradi.',
            );
        }

        if (preg_match('/экспорт|международ|страна|foreign|international|export|xorij|xalqaro/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Gurlan Global Teks ориентирована на международное сотрудничество и имеет опыт поставок на внешние рынки. Страна доставки, логистика и условия сделки согласуются индивидуально с каждым клиентом.',
                'Gurlan Global Teks is export-oriented and has experience supplying international markets. Destination country, logistics and commercial terms are agreed individually with each customer.',
                'Gurlan Global Teks eksportga yo‘naltirilgan kompaniya bo‘lib, xalqaro bozorlarga yetkazib berish tajribasiga ega. Yetkazish mamlakati, logistika va shartnomaviy shartlar har bir mijoz bilan alohida kelishiladi.',
            );
        }

        if (preg_match('/контакт|связ|телефон|email|почт|address|contact|phone|aloqa|bog.lan|telefon|manzil/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                "Связаться с нами: {$this->site->setting('phone')}, {$this->site->setting('email')}. Адрес: {$this->site->setting('address_'.$locale)}.",
                "Contact us: {$this->site->setting('phone')}, {$this->site->setting('email')}. Address: {$this->site->setting('address_'.$locale)}.",
                "Biz bilan bog‘laning: {$this->site->setting('phone')}, {$this->site->setting('email')}. Manzil: {$this->site->setting('address_'.$locale)}.",
            );
        }

        if (preg_match('/продук|ассортимент|product|catalog|mahsulot|assortiment|палат|ip-kalava|yarn|cotton|paxta/u', $normalizedQuestion) === 1) {
            $products = Product::active()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Product $product): string => $product->localized($locale, 'name'))
                ->filter()
                ->take(12)
                ->implode(', ');

            return $this->localizedAnswer(
                $locale,
                'Мы производим хлопок, пряжу, окрашенные и готовые ткани, а также готовую одежду.'.($products !== '' ? " Актуальный каталог: {$products}." : ''),
                'We produce cotton, yarn, dyed and finished knitted fabrics, and finished garments.'.($products !== '' ? " Current catalogue: {$products}." : ''),
                'Biz paxta, ip-kalava, bo‘yalgan va tayyor trikotaj matolar hamda tayyor kiyim ishlab chiqaramiz.'.($products !== '' ? " Amaldagi katalog: {$products}." : ''),
            );
        }

        if (preg_match('/сертифик|iso|sedex|oeko|sertifikat/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Компания работает по стандартам ISO, OEKO-TEX и SEDEX. Сертификация BCI и Better Cotton находится в процессе.',
                'The company works to ISO, OEKO-TEX and SEDEX standards. BCI and Better Cotton certification is in progress.',
                'Kompaniya ISO, OEKO-TEX va SEDEX standartlari asosida ishlaydi. BCI va Better Cotton sertifikatlari jarayonda.',
            );
        }

        if (preg_match('/скольк|мощност|производ|capacity|produce|quvvat|ishlab chiqar|yiliga|когда|год|since|founded|2020/u', $normalizedQuestion) === 1) {
            return $this->localizedAnswer(
                $locale,
                'Компания основана в 2020 году. Ежегодные мощности: 4 000 тонн пряжи, 3 500 тонн окрашенного полотна, 4 000 тонн ткани и до 6 000 000 готовых изделий.',
                'The company was founded in 2020. Annual capacity: 4,000 tons of yarn, 3,500 tons of dyed fabric, 4,000 tons of fabric and up to 6,000,000 finished garments.',
                'Kompaniya 2020-yilda tashkil etilgan. Yillik quvvat: 4 000 tonna ip-kalava, 3 500 tonna bo‘yalgan polotno, 4 000 tonna mato va 6 000 000 tagacha tayyor kiyim.',
            );
        }

        return $this->localizedAnswer(
            $locale,
            'Gurlan Global Teks — текстильное производство полного цикла: хлопок, пряжа, ткани, окрашивание, пошив и упаковка. Годовая мощность — до 6 000 000 изделий. Я могу подробнее рассказать о продукции, мощности, сертификатах, сроках, производстве под вашим брендом и контактах.',
            'Gurlan Global Teks is a full-cycle textile manufacturer covering cotton, yarn, fabrics, dyeing, garment production and packaging, with annual capacity of up to 6,000,000 garments. Ask me about products, capacity, certificates, lead times, private-label production or contacts.',
            'Gurlan Global Teks — paxta, ip-kalava, mato, bo‘yash, tikuv va qadoqlashni qamrab olgan to‘liq siklli tekstil ishlab chiqaruvchi. Yillik quvvat — 6 000 000 tagacha mahsulot. Mahsulotlar, quvvat, sertifikatlar, muddatlar, brendingiz uchun ishlab chiqarish yoki aloqa haqida so‘rashingiz mumkin.',
        );
    }

    private function localizedAnswer(string $locale, string $russian, string $english, string $uzbek): string
    {
        return match ($locale) {
            'uz' => $uzbek,
            'en' => $english,
            default => $russian,
        };
    }

    private function normalizeQuestion(string $question): string
    {
        return Str::of($question)
            ->replace(['’', '‘', '`', 'ʼ'], "'")
            ->replaceMatches('/\s+/u', ' ')
            ->trim()
            ->toString();
    }

    private function removeRawUrls(string $answer): string
    {
        return trim((string) preg_replace('~https?://[^\s<]+~iu', '', $answer));
    }
}

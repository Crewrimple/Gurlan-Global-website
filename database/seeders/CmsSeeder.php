<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\MediaAsset;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (config('site_content.pages') as $page => $blocks) {
            foreach ($blocks as $key => $block) {
                foreach ($block['values'] as $locale => $value) {
                    ContentBlock::query()->updateOrCreate(
                        compact('page', 'key', 'locale'),
                        ['label' => $block['label'], 'value' => $value],
                    );
                }
            }
        }

        foreach (config('site_content.media') as $key => $asset) {
            MediaAsset::query()->updateOrCreate(
                ['key' => $key],
                ['label' => $asset['label'], 'file_path' => $asset['path']],
            );
        }

        foreach (config('site_content.settings') as $key => $setting) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $setting['value']],
            );
        }

        $fabrics = [
            ['2 нитка', '2-thread fabric', '2 ipli mato'],
            ['3 нитка', '3-thread fabric', '3 ipli mato'],
            ['Кулирка', 'Single jersey', 'Kulirka'],
            ['Велюр', 'Velour', 'Velur'],
            ['Интерлок', 'Interlock', 'Interlok'],
            ['Кашкорсе', 'Rib knit', 'Kashkorse'],
            ['Махра', 'Terry', 'Mahra'],
            ['Пике', 'Piqué', 'Pike'],
            ['Супрем', 'Suprem knit', 'Suprem'],
        ];

        foreach (['women' => 15, 'men' => 14, 'fabric' => 9] as $category => $count) {
            for ($index = 1; $index <= $count; $index++) {
                $number = str_pad((string) $index, 2, '0', STR_PAD_LEFT);
                $names = $category === 'fabric'
                    ? $fabrics[$index - 1]
                    : [
                        $category === 'women' ? "Женская модель $number" : "Мужская модель $number",
                        ucfirst($category)." model $number",
                        $category === 'women' ? "Ayollar modeli $number" : "Erkaklar modeli $number",
                    ];

                Product::query()->updateOrCreate(
                    ['category' => $category, 'image_path' => "gurlan-assets/products/$category/$index.jpg"],
                    [
                        'name_ru' => $names[0],
                        'name_en' => $names[1],
                        'name_uz' => $names[2],
                        'sort_order' => $index,
                        'is_active' => true,
                    ],
                );
            }
        }

        $team = [
            ['Исмаилов Темур', 'Temur Ismoilov', 'Temur Ismoilov', 'Генеральный директор', 'General Director', 'Bosh direktor', 'Ismailov_Temur.jpg'],
            ['Курбонов Шерзод', 'Sherzod Kurbonov', 'Sherzod Qurbonov', 'Заместитель генерального директора', 'Deputy General Director', 'Bosh direktor o‘rinbosari', 'Sherzod_Kurbanov.jpg'],
            ['Исмаилов Исмаил', 'Ismoil Ismoilov', 'Ismoil Ismoilov', 'Заместитель директора', 'Deputy Director', 'Direktor o‘rinbosari', 'Ismailov_Ismail.jpg'],
            ['Самандаров Темур', 'Temur Samandarov', 'Temur Samandarov', 'Директор по переработке хлопка', 'Director of Cotton Processing', 'Paxtani qayta ishlash bo‘yicha direktor', 'Samandarov_Temur.jpg'],
        ];

        foreach ($team as $index => $member) {
            TeamMember::query()->updateOrCreate(
                ['image_path' => 'gurlan-assets/about/about_s4/'.$member[6]],
                [
                    'name_ru' => $member[0],
                    'name_en' => $member[1],
                    'name_uz' => $member[2],
                    'position_ru' => $member[3],
                    'position_en' => $member[4],
                    'position_uz' => $member[5],
                    'sort_order' => $index + 1,
                ],
            );
        }
    }
}

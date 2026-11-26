<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name_ru', 'name_en', 'name_uz', 'position_ru', 'position_en', 'position_uz', 'image_path', 'sort_order'])]
class TeamMember extends Model
{
    protected function casts(): array
    {
        return ['sort_order' => 'integer'];
    }

    public function localized(string $locale, string $attribute): string
    {
        return (string) $this->getAttribute($attribute.'_'.$locale);
    }
}

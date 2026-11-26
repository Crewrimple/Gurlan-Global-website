<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title_ru', 'title_en', 'title_uz', 'summary_ru', 'summary_en', 'summary_uz', 'body_ru', 'body_en', 'body_uz', 'image_path', 'published_at'])]
class NewsPost extends Model
{
    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function localized(string $locale, string $attribute): string
    {
        return (string) $this->getAttribute($attribute.'_'.$locale);
    }
}

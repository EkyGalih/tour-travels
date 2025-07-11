<?php

namespace App\Models;

use App\Traits\AutoTranslateOnSave;
use App\Traits\FormatCurrency;
use App\Traits\HasUuid;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasUuid, HasTranslations, AutoTranslateOnSave, FormatCurrency;

    protected $guarded = [];
    public $translatable = ['name', 'description'];

    public static function booted(): void
    {
        static::creating(function ($category) {
            // gunakan locale aktif
            $currentLocale = app()->getLocale();
            $name = $category->name;

            // kalau name translatable, ambil yang sesuai locale aktif
            if (is_array($name) && isset($name[$currentLocale])) {
                $nameForSlug = $name[$currentLocale];
            } else {
                $nameForSlug = $name;
            }

            $category->slug = Str::slug($nameForSlug) . '-' . Str::random(5);
        });
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'model', 'media_relationships');
    }

    public function getPriceRangeAttribute(): array
    {
        $min = $this->tours->min('lowest_price');
        $max = $this->tours->max('highest_price');

        return [
            'min' => $min,
            'max' => $max,
        ];
    }
}

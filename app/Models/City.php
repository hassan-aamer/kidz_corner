<?php

namespace App\Models;

use App\Models\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;
    public $translatable = ['title'];
    protected $guarded = [''];

    public function parent()
    {
        return $this->belongsTo(City::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(City::class, 'parent_id');
    }
}

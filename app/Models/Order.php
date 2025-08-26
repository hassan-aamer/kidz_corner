<?php

namespace App\Models;

use App\Models\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTranslations;
    protected $guarded = [''];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
        public function city()
    {
        return $this->belongsTo(City::class);
    }
}

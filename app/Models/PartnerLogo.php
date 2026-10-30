<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerLogo extends Model
{
    protected $fillable = [
        'name',
        'image',
        'url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'partnes/')) {
            return asset($this->image);
        }

        return asset('storage/'.$this->image);
    }
}

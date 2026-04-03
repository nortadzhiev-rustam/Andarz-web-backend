<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'bio', 'image_url', 'is_active'])]
class Author extends Model {
    use HasFactory;
    protected $attributes = ['is_active' => true];
    public function quotes(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Quote::class);
    }
    protected static function booted(): void {
        static::creating(function (Author $a) {
            if (empty($a->slug)) $a->slug = Str::slug($a->name);
        });
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'description', 'is_active'])]
class Category extends Model {
    use HasFactory;
    protected $attributes = ['is_active' => true];
    public function quotes(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Quote::class);
    }
    protected static function booted(): void {
        static::creating(function (Category $c) {
            if (empty($c->slug)) $c->slug = Str::slug($c->name);
        });
    }
}

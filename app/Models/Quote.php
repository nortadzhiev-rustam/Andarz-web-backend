<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['content', 'translation', 'language', 'author_id', 'category_id', 'user_id', 'is_featured', 'is_active'])]
class Quote extends Model {
    use HasFactory;
    protected $attributes = ['language' => 'fa', 'is_featured' => false, 'is_active' => true];
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Author::class);
    }
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Category::class);
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder {
        return $query->where('is_active', true);
    }
    public function scopeFeatured(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder {
        return $query->where('is_featured', true);
    }
}

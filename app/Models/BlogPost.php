<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class BlogPost extends Model {
    use HasFactory;
    protected $fillable = ['title','slug','excerpt','content','thumbnail','author_id','tags','category','published_at','reading_time','is_published'];
    protected function casts(): array { return ['tags'=>'array','is_published'=>'boolean','published_at'=>'date:Y-m-d']; }
    protected static function booted(): void {
        static::creating(function (BlogPost $p) {
            if (empty($p->slug)) $p->slug = Str::slug($p->title);
        });
    }
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(Instructor::class, 'author_id'); }
    public function scopePublished(\Illuminate\Database\Eloquent\Builder $q): \Illuminate\Database\Eloquent\Builder { return $q->where('is_published', true); }
}

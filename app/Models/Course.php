<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Course extends Model {
    use HasFactory;
    protected $fillable = [
        'title','slug','description','short_description','thumbnail',
        'price','discount_price','level','category','tags','instructor_id',
        'duration','students_count','rating','reviews_count','language',
        'last_updated','is_published','is_featured',
    ];
    protected function casts(): array {
        return ['tags'=>'array','is_published'=>'boolean','is_featured'=>'boolean','last_updated'=>'date:Y-m-d','price'=>'float','discount_price'=>'float','rating'=>'float'];
    }
    protected static function booted(): void {
        static::creating(function (Course $c) {
            if (empty($c->slug)) $c->slug = Str::slug($c->title);
        });
    }
    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Instructor::class);
    }
    public function modules(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(CourseModule::class)->orderBy('order');
    }
    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(User::class, 'course_user')->withTimestamps();
    }
    public function scopePublished(\Illuminate\Database\Eloquent\Builder $q): \Illuminate\Database\Eloquent\Builder {
        return $q->where('is_published', true);
    }
    public function scopeFeatured(\Illuminate\Database\Eloquent\Builder $q): \Illuminate\Database\Eloquent\Builder {
        return $q->where('is_featured', true);
    }
}

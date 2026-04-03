<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Instructor extends Model {
    use HasFactory;
    protected $fillable = ['name', 'avatar', 'bio'];
    public function courses(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Course::class);
    }
    public function blogPosts(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}

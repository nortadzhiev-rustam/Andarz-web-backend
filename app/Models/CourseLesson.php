<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CourseLesson extends Model {
    use HasFactory;
    protected $fillable = ['course_module_id', 'title', 'duration', 'video_url', 'is_free', 'order'];
    protected function casts(): array { return ['is_free' => 'boolean']; }
    public function module(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(CourseModule::class, 'course_module_id'); }
}

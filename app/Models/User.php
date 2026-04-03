<?php
namespace App\Models;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];
    protected $hidden   = ['password', 'remember_token'];
    protected $attributes = ['role' => 'student'];
    protected function casts(): array {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isInstructor(): bool { return $this->role === 'instructor'; }
    public function enrolledCourses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(Course::class, 'course_user')->withTimestamps();
    }
}

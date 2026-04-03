<?php
namespace App\Repositories;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
class EloquentUserRepository extends EloquentRepository implements UserRepositoryInterface {
    public function __construct(User $model) { parent::__construct($model); }
    public function findByEmail(string $email): ?User { return User::where('email',$email)->first(); }
}

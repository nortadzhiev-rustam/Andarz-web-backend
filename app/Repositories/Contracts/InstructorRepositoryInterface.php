<?php
namespace App\Repositories\Contracts;
use App\Models\Instructor;
interface InstructorRepositoryInterface extends RepositoryInterface {
    public function findById(int $id): Instructor;
}

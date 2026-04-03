<?php
namespace App\Repositories;
use App\Models\Instructor;
use App\Repositories\Contracts\InstructorRepositoryInterface;
class EloquentInstructorRepository extends EloquentRepository implements InstructorRepositoryInterface {
    public function __construct(Instructor $model) { parent::__construct($model); }
    public function findById(int $id): Instructor { return $this->findOrFail($id); }
}

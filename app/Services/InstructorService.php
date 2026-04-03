<?php
namespace App\Services;
use App\Models\Instructor;
use App\Repositories\Contracts\InstructorRepositoryInterface;
use Illuminate\Support\Collection;
class InstructorService {
    public function __construct(private readonly InstructorRepositoryInterface $instructorRepository) {}
    public function getAll(): Collection { return $this->instructorRepository->all(); }
    public function findById(int $id): Instructor { return $this->instructorRepository->findOrFail($id); }
    public function create(array $data): Instructor { return $this->instructorRepository->create($data); }
    public function update(int $id, array $data): Instructor { return $this->instructorRepository->update($id, $data); }
    public function delete(int $id): bool { return $this->instructorRepository->delete($id); }
}

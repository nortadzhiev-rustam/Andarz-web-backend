<?php
namespace App\Repositories;
use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
abstract class EloquentRepository implements RepositoryInterface {
    public function __construct(protected Model $model) {}
    public function all(): Collection { return $this->model->all(); }
    public function paginate(int $perPage = 15): LengthAwarePaginator {
        return $this->model->newQuery()->latest()->paginate($perPage);
    }
    public function find(int $id): ?Model { return $this->model->find($id); }
    public function findOrFail(int $id): Model {
        $m = $this->find($id);
        if (!$m) throw new ModelNotFoundException("Model not found: {$id}");
        return $m;
    }
    public function create(array $data): Model { return $this->model->newQuery()->create($data); }
    public function update(int $id, array $data): Model {
        $m = $this->findOrFail($id); $m->update($data); return $m->fresh();
    }
    public function delete(int $id): bool { return (bool) $this->findOrFail($id)->delete(); }
}

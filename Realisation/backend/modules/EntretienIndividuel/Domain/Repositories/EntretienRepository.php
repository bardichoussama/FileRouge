<?php

namespace Modules\EntretienIndividuel\Domain\Repositories\Eloquent;

use Modules\EntretienIndividuel\Domain\Entities\Entretien;
use Modules\EntretienIndividuel\Domain\Repositories\Interfaces\EntretienRepositoryInterface;

class EntretienRepository implements EntretienRepositoryInterface
{
    protected $model;

    public function __construct(Entretien $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
} 
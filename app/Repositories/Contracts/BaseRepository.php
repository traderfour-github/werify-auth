<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected string $model = '';

    public function getModel(): Model
    {
        return new ($this->model)();
    }

    public function update($id, $data)
    {
        return $this->getModel()->findOrFail($id)->update($data);
    }
}

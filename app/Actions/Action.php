<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

abstract class Action implements ActionContract
{
    /**
     * @param Model $model
     * @param array $request
     * @return mixed
     */
    public function execute(Model $model, array $request)
    {
        return $this->action($model, $request);
    }
}

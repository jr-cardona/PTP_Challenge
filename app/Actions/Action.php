<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

abstract class Action implements ActionContract
{
    /**
     * @param Model $model
     * @param Request $request
     * @return mixed
     */
    public function execute(Model $model, Request $request)
    {
        return $this->action($model, $request);
    }
}

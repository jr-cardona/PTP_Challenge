<?php
namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface ActionContract
{
    public function execute(Model $model, Request $request);
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ImportRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportController extends Controller
{
    /**
     * Imports a listing of the resource.
     * @param ImportRequest $request
     * @return RedirectResponse | Response
     * @throws AuthorizationException
     */
    public function import(ImportRequest $request)
    {
        $this->authorize('import', $request->input('model'));

        $file = $request->file('file');
        $import = $request->input('import_model');

        try {
            $import = new $import;
            Excel::import($import, $file);
            $cant = $import->getRowCount();

            return redirect()->back()->with('success', ("Se importaron {$cant} registros satisfactoriamente"));
        } catch (ValidationException $err) {
            return $this->displayErrors($err);
        }
    }

    public function displayErrors($err)
    {
        $failures_unsorted = $err->failures();
        $failures_sorted = array();
        foreach ($failures_unsorted as $failure) {
            $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
        }
        return response()->view('imports.errors', [
            'failures' => $failures_sorted,
        ]);
    }
}

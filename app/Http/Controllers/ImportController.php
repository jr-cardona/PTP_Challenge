<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class ImportController extends Controller
{
    /**
     * Imports a listing of the resource.
     * @param Request $request
     * @return RedirectResponse | Response
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function import(Request $request)
    {
        $this->authorize('import', $request->get('model'));

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $redirect = $request->get('redirect');
        $import = $request->input('import-model');

        try {
            $import = new $import;
            Excel::import($import, $file);
            $cant = $import->getRowCount();

            return redirect()->route($redirect)->with('success', ("Se importaron {$cant} registros satisfactoriamente"));
        } catch (ExcelValidationException $err) {
            return $this->displayErrors($err, $redirect);
        }
    }

    public function displayErrors($err, $route)
    {
        $failures_unsorted = $err->failures();
        $failures_sorted = array();
        foreach ($failures_unsorted as $failure) {
            $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
        }
        return response()->view('imports.errors', [
            'failures' => $failures_sorted,
            'route' => $route
        ]);
    }
}

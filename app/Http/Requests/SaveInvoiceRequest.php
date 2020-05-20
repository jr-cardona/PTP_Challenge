<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class SaveInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $start_date = Carbon::now()->subWeek()->toDateString();
        $final_date = Carbon::now()->toDateString();
        return [
            'issued_at' => 'required|date|after_or_equal:' . $start_date . '|before_or_equal:' . $final_date,
            'client_id' => 'required|numeric|exists:clients,id',
            'description' => 'nullable|string|max:255'
        ];
    }
}

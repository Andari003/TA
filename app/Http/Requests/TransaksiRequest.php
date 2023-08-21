<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nomor' => 'string|required|min:3',
            'tgl' => 'required',
            'details.*.division_id' => 'required|integer|exists:divisions,id',
            'details.*.qty' => 'required|numeric',
            'details.*.harga' => 'required|numeric',


        ];
    }
}

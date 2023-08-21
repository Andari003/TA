<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validations\Validator;
use Illuminate\Http\Request;

class TypeRequest extends BaseApiRequest
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
            'name' => 'string|required|min:3',
            'description' => 'required',
            'content' => 'string|required',
            'division_id' => 'required|integer|exists:divisions,id',
            'area_id' => 'required|integer|exists:areas,id',
            'group_equipment_id' => 'required|integer|exists:group_equipment,id',
            'equipment_id' => 'required|integer|exists:equipment,id',
            ];
    }
}

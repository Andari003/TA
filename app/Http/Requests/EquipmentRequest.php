<?php

namespace App\Http\Requests;

use Faker\Provider\Base;
use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends BaseApiRequest
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
                'division_id' => 'required|integer|exists:divisions,id',
                'area_id' => 'required|integer|exists:areas,id',
                'group_equipment_id' => 'required|integer|exists:group_equipment,id',
        ];
    }
}

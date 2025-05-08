<?php

namespace App\Http\Requests\API;

use App\Models\House;
use InfyOm\Generator\Request\APIRequest;

class UpdateHouseAPIRequest extends APIRequest
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
        $rules = House::$rules;
        $rules['house_number'] = $rules['house_number'].','.$this->route('house');

        return $rules;
    }
}

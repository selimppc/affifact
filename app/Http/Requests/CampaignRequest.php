<?php

namespace App\Http\Requests;

use App\Http\Requests;
use Route;
use Input;

use App\Http\Requests\Request;

class CampaignRequest extends Request
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
        $id = Route::input('id')?Route::input('id'):'';
        return [
            'name' => 'required|max:64|unique:campaign,name,'.$id,
            'popping_email_id'=>'required|unique:campaign,popping_email_id,'.$id,
        ];
    }
    public function messages()
    {
        return [
            'popping_email_id.required' => 'Please add a new popping email',
            'popping_email_id.unique' => 'Popping email already exists',
        ];
    }
}

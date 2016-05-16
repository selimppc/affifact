<?php

namespace App\Http\Requests;

use App\Http\Requests;

use Route;
use Input;

class PublicDomainRequest extends Request
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
            'title' => 'required|max:64|unique:public_domain,title,'.$id,
            //'domain_name' => 'required|unique:public_domain,domain_name,'.$id,
            //'status' => 'required',
        ];
    }
}

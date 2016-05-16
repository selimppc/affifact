<?php

namespace App\Http\Requests;

use App\Http\Requests;

use Route;
use Input;

class PoppingEmailRequest extends Request
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
        $id = Route::input('id') ? Route::input('id') : '';
        return [
            'name' => 'required|max:64|unique:popping_email,name,'.$id,
            'email' => 'required|max:128',
            'password' => 'required|max:64',
            'smtp_id' => 'required',
            'imap_id' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;
use App\Http\Requests;

use Route;
use Input;

class ImapRequest extends Request
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
            'name' => 'required|max:64|unique:imap,name,'.$id,
//            'host' => array('required', 'regex:/(^(([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]{1,2}|1[0-9]{2}|2[0-4][0-9]|25[0-5])$)|(^[a-zA-Z0-9-][a-zA-Z0-9]*[a-zA-Z0-9]$)/'),
//            'host' => array('required', 'regex:/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/'),
            'host' =>'required',
            'port' => 'required|numeric',
            'charset' => 'required',
            'secure' => 'required',
        ];
    }
}

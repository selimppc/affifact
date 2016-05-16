<?php

namespace App\Http\Requests;

use App\Http\Requests;

use Route;
use Input;

class SmtpRequest extends Request
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
            'name' => 'required|max:64|unique:smtp,name,'.$id,
//            'server_username' => 'required|max:64',
//            'server_password' => 'required',
//           'host' => 'regex:([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$|required',
            'host' => 'required',
            'auth' => 'required',
            'secure' => 'required',
            'port' => 'required|numeric',
            'mails_per_day_per_email' => 'required|numeric'
        ];
    }
}

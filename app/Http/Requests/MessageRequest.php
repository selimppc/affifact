<?php

namespace App\Http\Requests;
use App\Http\Requests;
use Route;
use Input;

class MessageRequest extends Request
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
        return [
            'campaign_id' => 'required',
            'html' => 'required',
            'delay' => 'required|numeric',
        ];
    }
}

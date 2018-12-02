<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRsvp extends FormRequest
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
            'name' => 'required|max:65',
            'email' => 'required|email',
            'rsvp' => 'required|max:10',
            'tickets' => 'max:10',
            'dietary' => 'max:125',
            'additional' => 'max:125',
            'captcha' => 'required|max:10'
        ];
    }
}

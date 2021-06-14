<?php
/**
 * Class HMenuStoreRequest
 * @package Domain\HMenu\Requests
 * @date: 09.11.2020
 */

namespace Domain\HMenu\Requests;


use Illuminate\Foundation\Http\FormRequest;

class HMenuStoreRequest extends FormRequest
{
    public function wantsJson() {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'status' => 'boolean',
            'locale_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'status.boolean' => 'Status should be boolean',
            'locale_id.required' => 'Locale is required',
            'locale_id.integer' => 'Locale must be an integer',
        ];
    }
}

<?php
/**
 * Class LocaleStoreRequest
 * @package Domain\Locale\Requests
 * @date: 09.11.2020
 */

namespace Domain\Locale\Request;


use Illuminate\Foundation\Http\FormRequest;

class LocaleStoreRequest extends FormRequest
{
    public function wantsJson() {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'code' => 'required|unique:locales|max:3',
            'status' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'code.required' => 'Code is required',
            'code.unique' => 'Locale with this code already exists',
            'status.boolean' => 'Status should be boolean',
        ];
    }
}

<?php
/**
 * Class PageStoreRequest
 * @package Domain\Page\Requests
 * @date: 10.11.2020
 */

namespace Domain\Page\Requests;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PageStoreRequest
 *
 * @package Domain\Page\Requests
 */
class PageStoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function wantsJson() {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'data' => 'array',
            'data.1.title' => 'required|string',
            'slug' => 'required|unique:pages',
            'data.*.status' => 'boolean',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'data.array' => 'Data should be an array',
            'data\.1\.title.required' => 'Title of first locale is required',
            'data\.1\.title.required' => 'Title of first locale should be string',
            'slug.required' => 'Slug is required',
            'slug.unique' => 'Slug should be unique',
            'data\.*\.status.boolean' => 'Status should be boolean',
        ];
    }
}

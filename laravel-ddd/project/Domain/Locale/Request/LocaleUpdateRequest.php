<?php
/**
 * Class LocaleUpdateRequest
 * @package Domain\Locale\Requests
 * @date: 09.11.2020
 */

namespace Domain\Locale\Request;


class LocaleUpdateRequest extends LocaleStoreRequest
{
    public function rules()
    {
        $updateRules = [
            'code' => [
                'required',
                'max:3',
                'unique:locales,code,' . $this->id
            ]
        ];
        $rules = array_merge(parent::rules(), $updateRules);

        return $rules;
    }
}

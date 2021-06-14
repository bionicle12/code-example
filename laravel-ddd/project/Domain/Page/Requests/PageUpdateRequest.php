<?php
/**
 * Class PageUpdateRequest
 * @package Domain\Page\Requests
 * @date: 10.11.2020
 */

namespace Domain\Page\Requests;

/**
 * Class PageUpdateRequest
 *
 * @package Domain\Page\Requests
 */
class PageUpdateRequest extends PageStoreRequest
{
    /**
     * @return array|string[]
     */
    public function rules(): array
    {
        $updateRules = [
            'slug' => [
                'required',
                'unique:pages,slug,' . $this->page
            ]
        ];

        return array_merge(parent::rules(), $updateRules);
    }
}

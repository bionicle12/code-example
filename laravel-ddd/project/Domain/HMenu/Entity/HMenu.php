<?php

namespace Domain\HMenu\Entity;

use Domain\HMenu\Model\HMenuModel;
use Domain\Locale\Model\LocaleModel;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class HMenu implements Arrayable, Jsonable, JsonSerializable
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var LocaleModel
     */
    private $locale;

    /**
     * @var HMenuModel
     */
    private $parent;

    /**
     * @var array of HMenuModel
     */
    private $children;

    /**
     * @var integer
     */
    private $sortOrder;

    /**
     * @var string
     */
    private $class;

    /**
     * @var int
     */
    private $id;

    public function __construct(
        string $title,
        string $url = null,
        bool $status = null,
        LocaleModel $locale,
        HMenuModel $parent = null,
        $children = [],
        int $sortOrder = null,
        string $class = null,
        int $id = 0
    )
    {
        $this->title = $title;
        $this->url = $url;
        $this->status = $status;
        $this->locale = $locale;
        $this->parent = $parent;
        $this->children = $children;
        $this->sortOrder = $sortOrder;
        $this->class = $class;
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getId()
    {
        return $this->id;
    }

//    /**
//     * @return false|string
//     */
//    public function __toString(): string
//    {
//        $parent = !empty($this->parent) ? [
//            'title' => $this->parent->title
//        ] : '';
//        $children = [];
//        if (!empty($this->children)) {
//            foreach ($this->children as $child) {
//                $children[] = [
//                    'id' => $child->id,
//                    'title' => $child->title
//                ];
//            }
//        }
//        $data = [
//            'id' => $this->id,
//            'title' => $this->title,
//            'url' => $this->url,
//            'status' => $this->status,
//            'locale' => [
//                'id' => $this->locale->id,
//                'title' => $this->locale->title,
//                'code' => $this->locale->code
//            ],
//            'parent' => $parent,
//            'children' => $children,
//            'sort_order' => $this->sortOrder,
//            'class' => $this->class,
//            'TEST' => 'sdfsdf'
//        ];
//        $json = json_encode($data);
//
//        return $json;
//    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $parent = !empty($this->parent) ? [
            'title' => $this->parent->title
        ] : '';
        $children = [];
        if (!empty($this->children)) {
            foreach ($this->children as $child) {
                $children[] = [
                    'id' => $child->id,
                    'title' => $child->title
                ];
            }
        }
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url ?? '',
            'status' => $this->status,
            'locale' => [
                'id' => $this->locale->id,
                'title' => $this->locale->title,
                'code' => $this->locale->code
            ],
            'parent' => $parent,
            'children' => $children,
            'sort_order' => $this->sortOrder,
            'class' => $this->class
        ];

        return $data;
    }
}

<?php

namespace DDD\HMenu\Entity;

use DDD\HMenu\Model\HMenuModel;
use DDD\Locale\Model\LocaleModel;
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
     * @var int
     */
    private $parent_id;

    /**
     * @var array of HMenu
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

    public function __construct(string $title, string $url = null, bool $status = null, $parent_id = null, $children = [], int $sortOrder = null, string $class = null, int $id = null)
    {
        $this->title = $title;
        $this->url = $url;
        $this->status = $status;
        $this->parent_id = $parent_id;
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

    public function getParentId()
    {
        return $this->parent_id;
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
            'parent_id' => $this->parent_id,
            'children' => $children,
            'sort_order' => $this->sortOrder,
            'class' => $this->class
        ];

        return $data;
    }

    public function addChild(HMenu $item)
    {
        $this->children[$item->getId()] = $item;
    }
}

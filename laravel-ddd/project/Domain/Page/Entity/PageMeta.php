<?php

namespace DDD\Page\Entity;

final class PageMeta
{
    protected $meta_title;
    protected $meta_description;
    protected $meta_keywords;
    protected $meta_image;

    public function __construct($meta_title = null, $meta_description = null, $meta_keywords = null, $meta_image = null)
    {
        $this->meta_title = $meta_title;
        $this->meta_description = $meta_description;
        $this->meta_keywords = $meta_keywords;
        $this->meta_image = $meta_image;
    }

    public function getTitle()
    {
        return $this->meta_title;
    }

    public function getDescription()
    {
        return $this->meta_description;
    }

    public function getKeywords()
    {
        return $this->meta_keywords;
    }

    public function getImage()
    {
        return $this->meta_image;
    }

    public function getImageLink()
    {
        if ($this->meta_image) {
            return getenv('STATIC_DOMAIN') . $this->meta_image;
        }
    }
}

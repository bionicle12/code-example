<?php

namespace Domain\Page\Entity;

/**
 * Class PageMeta
 *
 * @package Domain\Page\Entity
 */
final class PageMeta
{
    /**
     * @var mixed|null
     */
    protected $meta_title;

    /**
     * @var mixed|null
     */
    protected $meta_description;

    /**
     * @var mixed|null
     */
    protected $meta_keywords;

    /**
     * @var mixed|null
     */
    protected $meta_image;

    /**
     * PageMeta constructor.
     *
     * @param null $meta_title
     * @param null $meta_description
     * @param null $meta_keywords
     * @param null $meta_image
     */
    public function __construct($meta_title = null, $meta_description = null, $meta_keywords = null, $meta_image = null)
    {
        $this->meta_title = $meta_title;
        $this->meta_description = $meta_description;
        $this->meta_keywords = $meta_keywords;
        $this->meta_image = $meta_image;
    }

    /**
     * @return mixed|null
     */
    public function getTitle()
    {
        return $this->meta_title;
    }

    /**
     * @return mixed|null
     */
    public function getDescription()
    {
        return $this->meta_description;
    }

    /**
     * @return mixed|null
     */
    public function getKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * @return mixed|null
     */
    public function getImage()
    {
        return $this->meta_image;
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return getenv('STATIC_DOMAIN') . $this->meta_image;
    }
}

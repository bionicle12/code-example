<?php

namespace Domain\Page\Entity;

use Domain\Page\Exceptions\InvalidArgumentException;

/**
 * Class PageTitle
 *
 * @package Domain\Page\Entity
 */
final class PageTitle
{
    /**
     * @var string
     */
    private $title;

    /**
     * PageTitle constructor.
     *
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}

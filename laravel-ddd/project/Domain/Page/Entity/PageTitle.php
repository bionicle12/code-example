<?php

namespace DDD\Page\Entity;

use DDD\Page\Exceptions\InvalidArgumentException;

final class PageTitle
{
    private $title;

    public function __construct(string $title)
    {
        if (empty($title)) {
            throw new InvalidArgumentException("Title should not be empty");
        }

        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}

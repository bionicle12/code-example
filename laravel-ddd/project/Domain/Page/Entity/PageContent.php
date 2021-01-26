<?php

namespace DDD\Page\Entity;

use DDD\Locale\Model\LocaleModel;

final class PageContent
{
    public const STATUS_PUBLISH = 1;
    public const STATUS_DRAFT = 0;
    /**
     * @var PageTitle
     */
    protected $title;
    protected $content;
    /**
     * @var PageMeta
     */
    protected $metaContent;
    protected $status;

    protected $id;

    public function __construct(PageTitle $title, string $content = null, PageMeta $metaContent, $status, $id = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->metaContent = $metaContent;
        $this->status = $status;
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMeta(): PageMeta
    {
        return $this->metaContent;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getId()
    {
        return $this->id;
    }
}

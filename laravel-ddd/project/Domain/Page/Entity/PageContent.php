<?php

namespace Domain\Page\Entity;

use Domain\Locale\Model\LocaleModel;

/**
 * Class PageContent
 *
 * @package Domain\Page\Entity
 */
final class PageContent
{
    public const PAGE_STATUS_PUBLISH = 1;
    public const PAGE_STATUS_DRAFT = 0;

    /**
     * @var \Domain\Page\Entity\PageTitle
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $content;

    /**
     * @var string|null
     */
    protected $styles;

    /**
     * @var \Domain\Page\Entity\PageMeta
     */
    protected $metaContent;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var \Domain\Locale\Model\LocaleModel
     */
    protected $locale;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * PageContent constructor.
     *
     * @param \Domain\Page\Entity\PageTitle $title
     * @param string|null $content
     * @param string|null $styles
     * @param \Domain\Page\Entity\PageMeta $metaContent
     * @param \Domain\Locale\Model\LocaleModel $locale
     * @param string $status
     * @param int|null $id
     */
    public function __construct(PageTitle $title, string $content = null, string $styles = null, PageMeta $metaContent, LocaleModel $locale, string $status, int $id = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->styles = $styles;
        $this->metaContent = $metaContent;
        $this->locale = $locale;
        $this->status = $status;
        $this->id = $id;
    }

    /**
     * @return \Domain\Page\Entity\PageTitle
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \Domain\Locale\Model\LocaleModel
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return \Domain\Page\Entity\PageMeta
     */
    public function getMeta(): PageMeta
    {
        return $this->metaContent;
    }

    /**
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
}

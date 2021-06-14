<?php

namespace Domain\Page\Model;

use Domain\Locale\Service\LocaleService;
use Domain\Page\Entity\PageContent;
use Domain\Page\Entity\PageMeta;
use Domain\Page\Entity\PageTitle;
use Illuminate\Database\Eloquent\Model;
use Domain\ModelInterface;

/**
 * Class PageContentModel
 *
 * @package Domain\Page\Model
 */
class PageContentModel extends Model implements ModelInterface
{
    /**
     * @var string
     */
    protected $table = "page_contents";

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo('Domain\Page\Model\PageModel');
    }

    /**
     * @return \Domain\Page\Entity\PageContent
     * @throws \Domain\Locale\Exceptions\NotFoundException
     */
    public function toDomain()
    {
        $locale = LocaleService::findById($this->locale_id);

        return new PageContent(
            new PageTitle($this->title),
            $this->content,
            $this->styles,
            new PageMeta($this->meta_title, $this->meta_description, $this->meta_keywords, $this->meta_image),
            $locale,
            (int)$this->status,
            $this->id
        );
    }
}

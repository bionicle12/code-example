<?php

namespace DDD\Page\Model;

use DDD\Locale\Model\LocaleModel;
use DDD\Page\Entity\PageContent;
use DDD\Page\Entity\PageMeta;
use DDD\Page\Entity\PageTitle;
use Illuminate\Database\Eloquent\Model;
use DDD\ModelInterface;

class PageContentModel extends Model implements ModelInterface
{
    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLISH = 1;

    protected $table = "page_contents";

    public $timestamps = false;

    public function page()
    {
        return $this->belongsTo('DDD\Page\Model\PageModel');
    }

    public function locale()
    {
        return $this->belongsTo(LocaleModel::class, 'locale_id');
    }

    public function toDomain()
    {
        return new PageContent(
            new PageTitle($this->title),
            $this->content,
            new PageMeta($this->meta_title, $this->meta_description, $this->meta_keywords, $this->meta_image),
            $this->status,
            $this->id
        );
    }
}

<?php

namespace Domain\Page\Model;

use App\Models\User;
use Domain\Page\Entity\Page;
use Domain\Page\Model\PageContentModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Domain\ModelInterface;

/**
 * Class PageModel
 *
 * @package Domain\Page\Model
 */
class PageModel extends Model implements ModelInterface
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "pages";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function content()
    {
        return $this->hasMany('Domain\Page\Model\PageContentModel', 'page_id');
    }

    /**
     * @return \Domain\Page\Entity\Page
     */
    public function toDomain(): Page
    {
        $content = $this->content->keyBy('locale_id')->map(function ($item) { return $item->toDomain(); });

        return new Page(
            $this->category,
            $this->slug,
            $content,
            User::find(1),
            $this->id,
            $this->created_at
        );
    }

    /**
     *
     */
    public static function booted()
    {
        static::deleted(function ($page) {
            $page->content()->delete();
        });
    }
}

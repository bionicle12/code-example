<?php

namespace DDD\Page\Model;

use App\Models\User;
use DDD\Page\Entity\Page;
use DDD\Page\Model\PageContentModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DDD\ModelInterface;
use Illuminate\Support\Facades\App;

class PageModel extends Model implements ModelInterface
{
    use HasFactory;

    protected $table = "pages";

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function content()
    {
        return $this->hasMany('DDD\Page\Model\PageContentModel', 'page_id');
    }

    public function activeContentByLang()
    {
        //select * from page_contents left join locales where status=1 and locales.code=en

        return $this->content()
            ->join('locales', 'page_contents.locale_id', '=', 'locales.id')
            ->where('page_contents.status', PageContentModel::STATUS_PUBLISH)
            ->where('locales.code', App::getLocale())->first();
    }

    public function toDomain(): Page
    {
        $content = $this->activeContentByLang();

        if ($content) {
            $content = $content->toDomain();
        }

        return new Page(
            $this->category,
            $this->slug,
            $content,
            User::find(1),
            $this->id,
            $this->created_at
        );
    }
}

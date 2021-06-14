<?php

namespace Domain\Page\Repository;

use Domain\Page\Entity\Page;
use Domain\Page\Exceptions\NotFoundException;
use Domain\Page\Model\PageContentModel;
use Domain\Page\Model\PageModel;
use Domain\ModelInterface;

/**
 * Class PageRepository
 *
 * @package Domain\Page\Repository
 */
class PageRepository implements PageRepositoryInterface
{
    /**
     * @param int $id
     * @return \Domain\Page\Entity\Page
     */
    public function findById(int $id): Page
    {
        $pageModel = PageModel::findOrFail($id);

        $page = $pageModel->toDomain();

        return $page;
    }

    /**
     * @param int $pager
     * @return \Illuminate\Support\Collection
     */
    public function findAll(int $pager = 0): \Illuminate\Support\Collection
    {
        $pagesModelItems = PageModel::with(['content'])->paginate(15);

        $pages = $pagesModelItems->map(function (ModelInterface $entity) {
            return $entity->toDomain();
        });

        return $pages;
    }

    /**
     * @param \Domain\Page\Entity\Page $page
     * @param int|null $pageId
     * @return mixed
     */
    public function store(
        Page $page,
        int $pageId = null
    ) {
        $pageModel = $pageId ? PageModel::findOrFail($pageId) : new PageModel();
        $pageModel->category = $page->getCategory();
        $pageModel->slug = $page->getSlug();
        $pageModel->user_id = 1;
        $pageModel->created_at = $page->getCreatedAt();
        $pageModel->updated_at = $page->getUpdatedAt();
        $pageModel->save();

        $pageIdForEdit = $pageModel->id;

        foreach ($page->getContent() as $content) {
            $pageContentModel = $pageId ? PageContentModel::where('page_id', $pageId)
                ->where('locale_id', $content->getLocale()->id)
                ->first() : new PageContentModel();

            // при PageContentModel null не создает новые страницы на других языках
            if(is_null($pageContentModel)){
                $pageContentModel = new PageContentModel();
            }

            $pageContentModel->title = $content->getTitle();
            $pageContentModel->locale_id = $content->getLocale()->id;
            $pageContentModel->content = $content->getContent();
            $pageContentModel->styles = $content->getStyles();
            $pageContentModel->status = $content->getStatus();
            $pageContentModel->page_id = $pageModel->id;

            $pageContentModel->meta_title = $content->getMeta()
                ->getTitle();
            $pageContentModel->meta_description = $content->getMeta()
                ->getDescription();
            $pageContentModel->meta_keywords = $content->getMeta()
                ->getKeywords();
            $pageContentModel->meta_image = $content->getMeta()
                ->getImage();

            $pageContentModel->save();
        }

        return $pageIdForEdit;
    }

    /**
     * @param $pageId
     * @return mixed
     */
    public function destroy($pageId)
    {
        $pageModel = PageModel::findOrFail($pageId);

        return $pageModel->delete();
    }
}

<?php

namespace Domain\HMenu\Service;

use Domain\HMenu\Entity\HMenu;
use Domain\HMenu\Exceptions\NotFoundException;
use Domain\HMenu\Model\HMenuModel;
use Domain\HMenu\Repository\HMenuRepositoryInterface;
use Domain\Locale\Model\LocaleModel;
use Domain\ModelInterface;
use Illuminate\Http\Request;

class HMenuService implements HMenuServiceInterface
{
    /**
     * @var null HMenuRepositoryInterface
     */
    private $hMenuRepository = null;

    private $itemsPerPage = 10;

    public function __construct(HMenuRepositoryInterface $hMenuRepository)
    {
        $this->hMenuRepository = $hMenuRepository;
        $this->itemsPerPage = config('app.items_per_page');
    }

    public function findPaginatedAll()
    {
        $items = $this->hMenuRepository->findPaginatedAll($this->itemsPerPage);

        return $items;
    }

    public function findAll()
    {
        $items = $this->hMenuRepository->findAll();

        return $items;
    }

    public function findAllActive()
    {
        $items = HMenuModel::where('status', HMenuModel::HMENU_STATUS_PUBLISH)->get();

        return $items;
    }

    public function findById(int $id)
    {
        $model = HMenuModel::findOrFail($id);

        return $model;
    }

    public function store(Request $request)
    {
        $locale = LocaleModel::findOrFail($request->locale_id);
        $parent = HMenuModel::find($request->parent_id) ?? null;

        $menu = new HMenu(
            $request->title,
            $request->url,
            $request->status,
            $locale,
            $parent,
            [],
            $request->sort_order,
            $request->class
        );
        $result = $this->hMenuRepository->store($menu);

        return $result;
    }

    public function destroy(ModelInterface $model)
    {
        return $model->delete();
    }

    public function update(Request $request, HMenuModel $menu)
    {
        $request->status = (int)$request->status;
        $menu->update($request->all());

        return $menu;
    }
}

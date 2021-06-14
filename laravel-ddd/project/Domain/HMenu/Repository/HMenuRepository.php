<?php

namespace Domain\HMenu\Repository;

use Domain\HMenu\Entity\HMenu;
use Domain\HMenu\Exceptions\NotFoundException;
use Domain\HMenu\Model\HMenuModel;
use Domain\Locale\Model\LocaleModel;
use function MongoDB\BSON\toJSON;

class HMenuRepository implements HMenuRepositoryInterface
{
    private function prepareSort()
    {
        $sorterValues = request()->sorterValue ? (array)json_decode(request()->sorterValue) : [];
        if ($sorterValues) {
            $sorterValues['order'] = $sorterValues['asc'] ? 'asc' : 'desc';
            unset($sorterValues['asc']);
        }
        return $sorterValues;
    }

    private function prepareFilter()
    {
        $filterValues = request()->columnFilterValue ? array_filter((array)json_decode(request()->columnFilterValue)) : [];
        $whereFilter = [];
        foreach ($filterValues as $key=>$value) {
            $whereFilter[] = [
                $key,
                'like',
                 '%' . $value . '%'
            ];
        }
        return $whereFilter;
    }

    private function getFilteredSortedMenu($itemsPerPage)
    {
        $sorterValues = $this->prepareSort();
        $filterValues = $this->prepareFilter();
        if($sorterValues && $filterValues) {
            $menu = HMenuModel::with(['locale', 'parent', 'children'])->where($filterValues)
                ->orderBy($sorterValues['column'], $sorterValues['order'])
                ->paginate($itemsPerPage);
        } elseif ($sorterValues) {
            $menu = HMenuModel::with(['locale', 'parent', 'children'])->orderBy($sorterValues['column'], $sorterValues['order'])
                ->paginate($itemsPerPage);
        } elseif ($filterValues) {
            $menu = HMenuModel::with(['locale', 'parent', 'children'])->where($filterValues)
                ->paginate($itemsPerPage);
        } else {
            $menu = HMenuModel::with(['locale', 'parent', 'children'])->paginate($itemsPerPage);
        }

        return $menu;
    }

    public function findPaginatedAll($itemsPerPage)
    {
        $menu = $this->getFilteredSortedMenu($itemsPerPage);

        $menu->getCollection()->transform(function($item) {
            return $item->toDomain();
        });

        return $menu;
    }

    public function findAll()
    {
        $hMenuModel = HMenuModel::all();
        $menu = $hMenuModel->map(function($item) {
            return $item->toDomain();
        });

        return $menu;
    }

    public function findById(int $Id)
    {
        // TODO: Implement findById() method.
    }

    public function store(HMenu $hMenu, int $id = null)
    {
        $menu = new HMenuModel();
        $menu->title = $hMenu->getTitle();
        $menu->url = $hMenu->getUrl();
        $menu->status = $hMenu->getStatus();
        $menu->locale_id = $hMenu->getLocale()->id;
        $menu->parent_id = $hMenu->getParent() ? $hMenu->getParent()->id : 0;
        $menu->sort_order = $hMenu->getSortOrder();
        $menu->class = $hMenu->getClass();
        $menu->save();

        return $menu->id;
    }

    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }
}

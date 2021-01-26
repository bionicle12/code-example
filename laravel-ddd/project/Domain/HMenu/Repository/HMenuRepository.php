<?php

namespace DDD\HMenu\Repository;

use DDD\HMenu\Entity\HMenu;
use DDD\HMenu\Model\HMenuModel;
use DDD\ModelInterface;
use Illuminate\Support\Facades\App;

class HMenuRepository implements HMenuRepositoryInterface
{
    public function findAll()
    {
        $hMenuModels = HMenuModel::leftJoin('locales', 'hmenus.locale_id', '=', 'locales.id')
            ->select('hmenus.*')
            ->where('locales.code', App::getLocale())
            ->where('hmenus.status', '=', HMenuModel::STATUS_PUBLISH)
            ->orderBy('hmenus.sort_order')
            ->get()->keyBy('id');

        $menuEntities = $hMenuModels->map(function (ModelInterface $entity) {
            return $entity->toDomain();
        });

        return $this->prepareMenuWithParents($menuEntities);
    }

    private function prepareMenuWithParents($allMenuItems)
    {
        $parentMenu = $allMenuItems->filter(function($item, $key) {
            return !$item->getParentId();
        });

        foreach ($allMenuItems as $key=>$item) {
            if ($item->getParentId()) {
                $parentMenu[$item->getParentId()]->addChild($item);
            }
        }

        return $parentMenu;
    }
}

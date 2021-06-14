<?php

namespace Domain\HMenu\Service;

use Domain\HMenu\Model\HMenuModel;
use Domain\ModelInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface HMenuServiceInterface
{
    /**
     * @return Collection
     */
    public function findAll();

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * @param Request $request
     * @param int|null $id
     * @return mixed
     */
    public function store(Request $request);

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(ModelInterface $model);
}

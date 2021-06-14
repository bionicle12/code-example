<?php

namespace App\Http\Controllers\HMenu;

use App\Http\Controllers\Controller;
use Domain\HMenu\Requests\HMenuStoreRequest;
use Domain\HMenu\Requests\HMenuUpdateRequest;
use Domain\HMenu\Service\HMenuServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\ValidationException;

class HMenuController extends Controller
{
    private $hMenuService = null;

    public function __construct(HMenuServiceInterface $hMenuService)
    {
        $this->hMenuService = $hMenuService;
    }

    public function index(Request $request)
    {
        $menus = $this->hMenuService->findPaginatedAll();

        return response()->json($menus);
    }

    public function list()
    {
        $menus = $this->hMenuService->findAll();

        return response()->json($menus);
    }

    public function store(HMenuStoreRequest $request)
    {
        $menu = $this->hMenuService->store($request);

        return response()->json($menu);
    }

    public function edit(Request $request, int $id)
    {
        $menuItem = $this->hMenuService->findById($id);

        return response()->json($menuItem);
    }

    public function update(HMenuUpdateRequest $request, int $id)
    {
        $menu = $this->hMenuService->findById($id);

        $menu = $this->hMenuService->update($request, $menu);

        return response()->json($menu);
    }

    public function destroy(int $id)
    {
        $menu = $this->hMenuService->findById($id);

        $menu = $this->hMenuService->destroy($menu);

        return response()->json($menu);
    }
}

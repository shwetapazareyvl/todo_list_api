<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    private $itemService;

    /**
     * @param ItemService $itemService
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function saveItem(Request $request) {
        $validator = $this->itemService->validateFields($request);
        if ($validator->fails()) {
            return response()->json(["status" => Response::HTTP_BAD_REQUEST, "validation_errors" => $validator->errors()]);
        }else {
            $this->itemService->saveItem($request);
            return response()->json(["status" => Response::HTTP_OK]);
        }
    }

    /**
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function items($status = null) {
        return response()->json(["status" => Response::HTTP_OK, "data" => $this->itemService->getItems($status)]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteItem($id) {
        Item::where("id", $id)->delete();
        return response()->json(["status" => Response::HTTP_OK]);
    }
}

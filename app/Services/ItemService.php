<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class ItemService
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateFields(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                "title" => "required",
                "body" => "required",
                "filename" => "required",
                "status" => "required",
                "reminder" => "exists:reminders,id",
            ]
        );
        return $validator;
    }

    /**
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function saveItem(Request $request)
    {
        //todo:: implement file upload
        $inputArray = $request->all();
        $inputArray['user_id'] = Auth::user()->id;
        try {
            if(!empty($request->route()->parameter("id"))) {
                Item::where("id", $request->route()->parameter("id"))->update($inputArray);
            } else {
                Item::create($inputArray);
            }
        }
        catch (\Exception $e) {
            //todo:: log in logger
            throw new \Exception($e->getMessage());
        }

    }

    /**
     * @param $status
     * @return mixed
     */
    public function getItems($status = null)
    {
        $user = Auth::user();
        $filters = ["user_id" =>$user->id];
        if (!is_null($status)) {
            $filters["status"] = $status;
        }
        return Item::where($filters)->get()->toArray();
    }

}

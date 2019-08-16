<?php

namespace App\Http\Controllers\Api;

use App\Jobs\TrackAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TrackController extends BaseController
{
    public function add(Request $request) {

        $validator = Validator::make($request->all(), [
            'source_label' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        dispatch(new TrackAction($request['source_label'], Auth::guard('api')->user()->id));

        return $this->sendResponse(true, 'Tracked.');
    }
}

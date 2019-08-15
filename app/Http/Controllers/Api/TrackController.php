<?php

namespace App\Http\Controllers\Api;

use App\Services\SlowStorage\SlowStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TrackActionService;
use Illuminate\Support\Facades\Validator;

class TrackController extends BaseController
{
    /** @var TrackActionService $trackActionService */
    private $trackActionService;

    /** @var SlowStorageService $slowStorageService */
    private $slowStorageService;

    public function __construct(TrackActionService $trackActionService, SlowStorageService $slowStorageService)
    {
        $this->trackActionService = $trackActionService;
        $this->slowStorageService = $slowStorageService;
    }

    public function add(Request $request) {

        $validator = Validator::make($request->all(), [
            'source_label' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $track = $this->trackActionService->make($request['source_label'], $this->slowStorageService);

        return $this->sendResponse($track, 'Tracked.');
    }
}

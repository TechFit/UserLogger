<?php

namespace App\Jobs;

use App\Services\SlowStorage\SlowStorageService;
use App\Services\TrackActionService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TrackAction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var TrackActionService $trackActionService */
    private $trackActionService;

    /** @var SlowStorageService $slowStorageService */
    private $slowStorageService;

    /** @var string $track_action */
    private $track_action;

    /** @var int $user_id */
    private $user_id;

    public function __construct(string $track_action, int $user_id)
    {
        $this->trackActionService = new TrackActionService();
        $this->slowStorageService = new SlowStorageService();
        $this->track_action = $track_action;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->trackActionService->make($this->track_action, $this->user_id, $this->slowStorageService);
    }
}

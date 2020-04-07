<?php

namespace App\Jobs;

use App\Entities\User;
use App\Entities\Report;
use Illuminate\Bus\Queueable;
use App\Notifications\ExportReady;
use App\Notifications\ExportGenerated;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyCompletedExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $filePath;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $filePath
     */
    public function __construct($user, $filePath)
    {
        $this->user = $user;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $report = Report::create([
            'file_path' => $this->filePath,
            'created_by' => $this->user->id,
        ]);

        $admins = User::Role('admin')->get();
        Notification::send($admins, new ExportGenerated($report));

        $this->user->notify(new ExportReady());
    }
}

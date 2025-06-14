<?php

namespace App\Jobs;

use App\Mail\UserManuscriptNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserManuscriptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    public $tries = 3;
    public $maxExceptions = 3;
    public $backoff = [60, 180, 360]; // Retry after 1 min, 3 mins, 6 mins

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new UserManuscriptNotification($this->details['user'], $this->details['journal'], $this->details['messageBody']);
        Mail::to($this->details['user']['email'])->send($email);
    }
}

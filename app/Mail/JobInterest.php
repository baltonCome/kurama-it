<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Job;

class JobInterest extends Mailable{
    
    use Queueable, SerializesModels;

    public $interested;
    public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $interested, Job $job){

        $this->interested = $interested;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.jobs.job_interest')->subject('Someone have   interest in the posted Job');
    }
}

<?php
// SendEmployeeMailJob.php
namespace App\Jobs;

use App\Mail\EmployeeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmployeeMailJob implements ShouldQueue
{
    use Queueable;
    public array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function handle(): void
    {
        Mail::to('rd936236@gmail.com')->send(new EmployeeMail($this->data));
    }
}

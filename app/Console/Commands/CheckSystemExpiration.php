<?php

namespace App\Console\Commands;

use App\Models\SystemExpiration;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSystemExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiration:check';

    protected $description = 'Check system expiration';

    public function handle()
    {
        $expiration = SystemExpiration::first();

        if ($expiration) {
            $expirationDate = Carbon::parse($expiration->expiration_date);

            if ($expirationDate->isPast()) {
                // Perform actions when the system has expired
                $this->info('The system has expired.');
            } else {
                // Perform actions when the system is still valid
                $this->info('The system is still valid.');
            }
        } else {
            // Handle if no expiration date is set
            $this->error('No expiration date found.');
        }
    }
}

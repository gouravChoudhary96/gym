<?php

namespace App\Console\Commands;

use App\Models\ScheduledClass;
use Illuminate\Console\Command;

class IncrementDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:increment-date {--days=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment all the scheduled class dates by one day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Incrementing all the scheduled class dates by one day...');
        $scheduledClasses = ScheduledClass::latest('date_time')->get();
        $scheduledClasses->each(function ($class) {
            $this->info("Start Old Date: for ScheduledClass id - $class->id ->" . $class->date_time);
            $class->date_time = $class->date_time->addDays($this->option('days'));
            $class->save();
            $this->info("End with New Date: for ScheduledClass id - $class->id ->" . $class->date_time);

        });

        $this->info('All scheduled class dates have been incremented by one day.');
        return Command::SUCCESS;
    }
}

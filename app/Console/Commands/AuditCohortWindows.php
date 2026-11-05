<?php

namespace App\Console\Commands;

use App\Models\Workshop;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('workshops:audit-windows')]
#[Description('Audit application windows for upcoming and active cohorts')]
class AuditCohortWindows extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $workshops = Workshop::where('status', 'published')->get();

        if ($workshops->isEmpty()) {
            $this->warn('No published workshops found.');

            return self::SUCCESS;
        }

        $rows = [];

        foreach ($workshops as $workshop) {
            $status = $workshop->application_window_status;

            $rows[] = [
                $workshop->id,
                $workshop->title,
                $workshop->track_type,
                $workshop->application_starts_at->format('Y-m-d H:i'),
                $workshop->application_deadline->format('Y-m-d H:i'),
                $status['label'],
                $status['detail'],
                $workshop->applications()->count().' applicants',
            ];
        }

        $this->table(
            ['ID', 'Cohort Title', 'Track', 'Opens At', 'Deadline', 'Window State', 'Window Detail', 'Applications'],
            $rows
        );

        $this->info("Successfully audited {$workshops->count()} workshop application windows.");

        return self::SUCCESS;
    }
}

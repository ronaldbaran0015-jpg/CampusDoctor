<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class MarkMissedAppointment extends Command
{
    protected $signature = 'appointments:mark-missed';
    protected $description = 'Automatically mark missed appointments';

    public function handle()
    {
        $now = Carbon::now();

        $appointments = Appointment::where('status', 'approved')
            ->whereNotNull('scheduled_date')
            ->whereNotNull('start_time')
            ->get();

        foreach ($appointments as $appointment) {

            $appointmentDateTime = Carbon::parse(
                $appointment->scheduled_date . ' ' . $appointment->start_time
            );

            // If the time passed AND patient did not scan QR (still pending attendance)
            if ($appointmentDateTime->isPast() && !$appointment->qr_scanned) {

                $appointment->status = 'missed';
                $appointment->save();

                $this->info("Appointment ID {$appointment->id} marked as MISSED.");
            }
        }

        return Command::SUCCESS;
    }
}
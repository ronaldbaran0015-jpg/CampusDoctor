<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'scheduleid';
    protected $fillable = ['docid', 'title', 'scheduledate', 'start_time', 'end_time', 'nop'];

    // Each schedule belongs to a doctor
    public function mydoctor()
    {
        return $this->belongsTo(Doctor::class, 'docid', 'docid');
    }

    // Each schedule can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'scheduleid', 'scheduleid');
    }
}

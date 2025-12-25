<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'appoid';
    protected $fillable = ['pid', 'docid', 'apponum', 'scheduleid', 'appodate', 'start_time', 'end_time', 'status', 'qr_scanned', 'reason'];
 
    // Appointment model
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'scheduleid', 'scheduleid');
    }
    public function patient(){
        return $this->belongsTo(Patient::class,'pid', 'pid');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'scheduleid', 'docid'); // adjust if your schema differs
    }


    public function markAsMissed()
    {
        $this->status = 'missed';
        $this->save();
    }
}

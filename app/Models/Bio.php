<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    use HasFactory;
    protected $table = 'bios';

    protected $fillable = ['biography', 'patient_id', 'doctor_id'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'pid');
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'docid');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'patient_id', 'rating', 'review'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'docid');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'pid');
    }
}

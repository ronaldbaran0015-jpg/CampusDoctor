<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProblemReport extends Model
{
  
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'category',
        'description',
        'screenshot',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'pid');
    }

   




    public function replies()
    {
        return $this->hasMany(ProblemReportReply::class);
    }
}

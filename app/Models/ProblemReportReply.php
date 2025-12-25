<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemReportReply extends Model
{
    use HasFactory;
        protected $fillable = [
        'problem_report_id',
        'admin_id',
        'reply',
    ];

    public function problemReport()
    {
        return $this->belongsTo(ProblemReport::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'adminid');
    }
}

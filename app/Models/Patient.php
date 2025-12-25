<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Patient extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, Notifiable, CanResetPassword;
    protected $table = 'patients';
    protected $primaryKey = 'pid';

    protected $fillable = [ 'name', 'email', 'password', 'address', 'dob', 'contact', 'gender', 'relationship', 'image', 'status', 'facebook_id', 'google_id'];
    protected $hidden = ['password', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->password;
    }
    public function hasAppointment(){
        return $this->hasMany(Appointment::class, 'pid', 'pid');
    }

    public function bio()
    {
        return $this->hasOne(Bio::class, 'patient_id', 'pid');
    }


    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'pid');
    }

    public function getProfileCompletionPercentage()
    {
        $completedFields = 0;

        $basicFields = [
            'name',
            'email',
            'address',
            'dob',
            'contact',
            'gender',
            'relationship',
            'image'
        ];

        $totalFields = count($basicFields);

        foreach ($basicFields as $field) {

            // ✅ IMAGE CHECK (counts ONCE)
            if ($field === 'image') {
                if (
                    $this->image &&
                    file_exists(public_path('uploads/patients/' . $this->image))
                ) {
                    $completedFields++;
                }
                continue;
            }

            // ✅ NORMAL FIELD CHECK
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // ✅ BIO (OPTIONAL & SAFE)
        if ($this->bio) {
            $bioFields = ['biography'];
            $totalFields += count($bioFields);

            foreach ($bioFields as $field) {
                if (!empty($this->bio->$field) && $this->bio->$field !== 'Not set') {
                    $completedFields++;
                }
            }
        }

        // 🔒 HARD SAFETY GUARD (NEVER exceed 100%)
        if ($completedFields > $totalFields) {
            $completedFields = $totalFields;
        }

        return round(($completedFields / $totalFields) * 100);
    }
}

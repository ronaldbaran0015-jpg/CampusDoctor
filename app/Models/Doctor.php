<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Doctor extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table = 'doctors';
    protected $primaryKey = 'docid';
    protected $fillable = ['name', 'email', 'contact', 'password', 'specialties','bio', 'image', 'status'];
    protected $hidden = ['password', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->password;
    }
    public function specialty()
    {
        return $this->belongsTo(Specialties::class, 'specialties');
    }

    public function hasSchedule()
    {
        return $this->hasMany(Schedule::class, 'docid', 'docid');
    }

    public function bio()
    {
        return $this->hasOne(Bio::class, 'doctor_id', 'docid');
    }
    
    public function reviews(){
        return $this->hasMany(Review::class, 'doctor_id', 'docid');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id', 'docid');
    }
}

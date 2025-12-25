<?php

namespace App\Models;
use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Staff extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table = 'staff';
    protected $primaryKey = 'staffid';
    protected $fillable = ['staffname', 'staffemail', 'staffcontact', 'staffpassword','staffrole', 'staffimage'];
    protected $hidden = ['staffpassword', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->staffpassword;
    }
}

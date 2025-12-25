<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $primaryKey = 'adminid';
    protected $fillable = ['adminname', 'admincontact', 'adminusername', 'adminpassword', 'adminimage'];
    protected $hidden = ['adminpassword', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->adminpassword;
    }
}

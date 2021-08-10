<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class BoUsers extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = true;
    const CREATED_AT = 'bu_created_at';
    const UPDATED_AT = 'bu_updated_at';
    
    protected $fillable = [
      'bu_name',
      'bu_username',
      'bu_password',
      'bu_email_address',
      'bu_phone',
      'bu_token',
      'bu_reset_password_token',
      'bu_reset_password_expires',
      'bu_2fa',
      'bu_created_at',
      'bu_updated_at',
      'bu_is_active'	
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
      'bu_password',
      'bu_token',
      'bu_reset_password_token',
      'bu_reset_password_expires',
    ];

    public $table = 'bo_users';
}

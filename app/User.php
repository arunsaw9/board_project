<?php

namespace App;

use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $auditExclude = [
        'password',
        'remember_token',
        'api_token',
        'otp',
    ];

    protected $fillable = [
        'username', 'name', 'email', 'password', 'designation', 'role', 'api_token', 'mobile'
    ];

    protected $hidden = [
        'password', 'remember_token', 'otp', 'api_token'
    ];

    // protected $casts = [
    //     'role' => 'array',
    // ];

    public function meetings() {
        return $this->belongsToMany('App\BoardMeeting');
    }

    public function boardAgendas() {
        return $this->belongsToMany('App\BoardAgenda');
    }

    public function committeeAgendas() {
        return $this->belongsToMany('App\CommitteeAgenda');
    }

    public function committees() {
        return $this->belongsToMany('App\Committee');
    }

    public function hasRole($role) {
        if( $this->role === $role) {
            return true;
        }
        return false;
    }

    public function isSecretary() {
        // return $this->id == 1;
        return true;
    }

    public function hasAnyRole($roles) {
        if( is_array($roles) ) {
            foreach($roles as $role) {
                if ( $role == $this->role ) {
                    return true;
                }
            }
            return false;
        } else {
            return $roles == $this->role;
        }
    }

    public function queries() {
        return $this->hasMany('App\Query');
    }

    // public function hasRole($roles) {
    //     if( is_array($roles) ) {
    //         foreach($roles as $role) {
    //             if ( !in_array($role, $this->roles )) {
    //                 return false;
    //             }
    //         }
    //         return true;
    //     } else {
    //         return in_array( $roles, $this->roles );
    //     }
    // }
}

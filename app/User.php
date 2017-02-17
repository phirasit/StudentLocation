<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * get id of that person
     *
     * @return integer
     */
    public function getId() {
        return $this->hashOne('id');
    }

    /**
     * get username of that person
     *
     * @return string
     */
    public function getName() {
        return $this->hashOne('name');
    }

    /**
     * get email of that person
     *
     * @return string
     */
    public function getEmail() {
        return $this->hashOne('email');
    }
}

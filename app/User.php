<?php

namespace App;

use Google\Type\Date;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Attribute that counts how many profile pictures the user has
     * Each user only have to has max 3 images
     * @var int
     */
    protected static $countImages = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'displayName', 'email', 'localId','name', 'lastname',
        'birthday', 'created_at','is_photographer','categories',
        'preference','price','telefono'
    ];

    public static function incCountImages(){
        return self::$countImages = self::$countImages++;
    }
    public static function getCountImages()
    {
        return self::$countImages;
    }

    public function getAuthIdentifierName() {
        return 'localId';
    }

    public function getAuthIdentifier(){
        return $this->localId;
    }

    public function fullName(){
        return $this->name . ' ' . $this->lastname;
    }

    public function getName(){
        return 'name';
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
//        'bday' => 'datetime:d-MM-YYYY H:i:s',
    ];
}

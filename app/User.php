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
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'displayName', 'email', 'localId','name', 'lastname',
        'birthday', 'created_at','is_photographer','categories',
        'preference','price','telefono'
    ];

    public $no_profile_picture = 'holders/no_profile_picture.png';

    public static function incCountImages(){
        return self::$countImages = self::$countImages+1;
    }
    public static function getCountImages()
    {
        return self::$countImages;
    }

    public function getAge(){
        $bday = Carbon::parse($this->birthday);
        $now = Carbon::now();
        $age = $now->subYears($bday->year);
        return $age->year;
    }

    public function getAuthIdentifierName() {
        return 'localId';
    }

    public function getAuthIdentifier(){
        return $this->localId;
    }

    /*public function updateProfilePicture( $path){
        $key = array_search('profile_picture_path',$this->fillable);
        $this->fillable[$key] = 'profile_picture_path';
//        return dd($this->fillable[12], $path, $array);
//        $array = $this->fillable.array_key_last($path);
        return dd($this,'Modelo User');
    }*/

    public function getProfilePicture(){
        if($this->profile_pricture_path == ''){
            return $this->no_profile_picture;
        }
        return $this->profile_pricture_path;
    }
    public function fullName(){
        return $this->name . ' ' . $this->lastname;
    }

    public function getName(){
        return 'name';
    }
    public function getFullName(){
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

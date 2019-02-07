<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

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

    public function setUserInfo(Request $request,string $hash)
    {
        Redis::set("student:{$hash}:email", $request->email);

        if (!is_null($request->file('image'))) {
            $imgPath = File::saveImageStudent($request);

            Redis::set("student:{$hash}:img", $imgPath);
        }
    }
}

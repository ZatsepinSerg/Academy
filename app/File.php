<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Save loaded image
     *
     * @param Request $request
     * @return string
     */
    public static function saveImageUser(Request $request):string
    {
        return $request->file('image')->store('uploads', 'public');
    }
}

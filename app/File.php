<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public static function saveImageStudent(Request $request):string
    {
        return $request->file('image')->store('uploads', 'public');
    }
}

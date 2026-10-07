<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'room_id'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);//стуендту полагается 1 комната
    }
}


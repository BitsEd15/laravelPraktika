<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
     protected $fillable = [
        'room_number',
        'floor',
        'capacity',
     ];
     public function students()
     {
        return $this->hasMany(Student::class);
     }
}
/**
 * Так как одна комната может разместить несколько чел, поэтому связь 
 * $this->hasMany(Student::class) - этот объект имеет много студентов
 */
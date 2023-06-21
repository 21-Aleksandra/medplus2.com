<?php

namespace App\Models;
use App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    protected $fillable= ['name']; 

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}

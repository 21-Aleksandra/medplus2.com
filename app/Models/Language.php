<?php

namespace App\Models;
use App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable= ['code','name']; 

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

}

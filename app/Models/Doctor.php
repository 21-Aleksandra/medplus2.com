<?php

namespace App\Models;
use App\Models\Profession;
use App\Models\Comment;
use App\Models\Appointment;
use App\Models\Language;
use App\Models\Photo;
use App\Models\Subsidiary;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable= ['name', 'gender', 'description', 'profession', 'subsidiary', 'phone']; 

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class);
    }

}

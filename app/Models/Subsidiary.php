<?php

namespace App\Models;
use App\Models\User;
use App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    use HasFactory;

    protected $fillable= ['naming','address','manager_id','e-mail']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
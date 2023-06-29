<?php

namespace App\Models;
use App\Models\Subsidiary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable= ['city', 'street']; 
    public function subsidiary()
    {
        return $this->hasOne(Subsidiary::class);
    }
}

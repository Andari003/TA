<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable=['name','description','division_id'];
    protected $guarded=[];

    public function division(){
        return $this->belongsTo(Division::class);
    }

    public function groupEquipment(){
        return $this->hasMany(GroupEquipment::class);
    }

}

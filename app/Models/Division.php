<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Division extends Model
{
    use HasFactory;
    protected $fillable=['name','description'];
    protected $guarded=[];

    public function areas(){
        return $this->hasMany(Area::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Equipment extends Model
{
    use HasFactory;
    protected $table = "equipment";
    protected $fillable=['division_id','area_id','name','description'];
    protected $guarded=[];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
/**
     * Get the user that owns the type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the user that owns the type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function type(){
        return $this->hasMany(Type::class);
    }
}

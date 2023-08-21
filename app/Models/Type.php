<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
class Type extends Model
{
    use HasFactory;
    protected $table = "type";
    protected $fillable=['division_id','area_id','group_equipment_id','equipment_id','name','description','content','status','user_id','alasan'];
    protected $guarded=[];

    public function images(): MorphMany
    {
        return $this->morphMany(ImageFile::class, 'imageable');
    }

    public function videos(): MorphMany
    {
        return $this->morphMany(VideoFile::class, 'videoable');
    }

    /**
     * Get the user that owns the type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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
    public function groupEquipment(): BelongsTo
    {
        return $this->belongsTo(GroupEquipment::class);
    }
    /**
     * Get the user that owns the type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }


}

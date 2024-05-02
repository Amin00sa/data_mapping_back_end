<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * @return belongsTo
     */
    public function externalDataBase(): belongsTo
    {
        return $this->belongsTo(ExternalDataBase::class);
    }

    /**
     * @return HasMany
     */
    public function dataEntries(): HasMany
    {
        return $this->hasMany(DataEntry::class);
    }
}

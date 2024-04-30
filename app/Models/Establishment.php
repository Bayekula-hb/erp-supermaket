<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Establishment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nameEtablishment',
        'latitudeEtablishment',
        'longitudeEtablishment',
        'address',
        'workers',
        'workingDays',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

                
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function succursales(): HasMany
    {
        return $this->hasMany(Succursale::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'user_id',
        'succursale_id',
        'stock_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

            
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function succursales(): BelongsTo
    {
        return $this->belongsTo(Succursale::class);
    }

    public function stocks(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

}

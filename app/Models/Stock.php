<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'product_id',
       'succursale_id',
       'quantity',
       'price',
       'expiryDate',
   ];
   protected $hidden = [
       'created_at',
       'updated_at',
   ];

   public function Sales(): HasMany
   {
       return $this->hasMany(Sale::class);
   }
           
   public function Products(): BelongsTo
   {
       return $this->belongsTo(Product::class);
   }

   public function succursales(): BelongsTo
   {
       return $this->belongsTo(Succursale::class);
   }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastName',
        'middleName',
        'firstName',
        'userName',
        'gender',
        'phoneNumber',
        'email',
        'password',
    ];

    
    public function userRole(): BelongsToMany
    {
        return $this->BelongsToMany(UserRole::class, 'user_roles');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'sales');
    }

    public function establishment(): HasMany
    {
        return $this->hasMany(Establishment::class, 'establishments');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
        
   public function userRoles(): BelongsToMany
   {
       return $this->BelongsToMany(UserRole::class, 'user_roles');
   }
}

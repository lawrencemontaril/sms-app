<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    // use MustVerifyEmail;

    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'department_id',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    | -------
    |  Casts
    | -------
    */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    | ---------------
    |  Relationships
    | ---------------
    */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function supplyRequests(): HasMany
    {
        return $this->hasMany(SupplyRequest::class);
    }

    public function requisitions(): HasMany
    {
        return $this->hasMany(Requisition::class);
    }

    /*
    | ------------
    |  Attributes
    | ------------
    */
    protected function getRole(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getRoleNames()->first() ?? 'No role',
        );
    }

    protected function isDepartmentHead(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->id === $this->department?->user_id,
        );
    }
}

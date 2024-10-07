<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'name',
        'email',
        'contact',
        'email_verified_at',
        'password',
        'admin_id',
        'external_id',
        'external_auth',
        'updated_at',
        'created_at',
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

    /**
     * Set the admin relation.
     *
     * @return 
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Relación para acceder a la oficina a través del admin
    public function branchOffice()
    {
        // Usamos la relación indirecta a través de 'admin'
        return $this->hasOneThrough(BranchOffice::class, Admin::class, 'id', 'id', 'admin_id', 'branch_id');
    }
}

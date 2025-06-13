<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory, HasRoles; //

    protected $fillable = [ 'name', 'email', 'password', 'role',];
    protected $hidden = ['password', 'remember_token',];
    public function Loan(): HasMany {
        return $this->hasMany(Loan::class, 'id_user', 'id');
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isPustakawan(): bool
    {
        return $this->role === 'pustakawan';
    }
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

/*
    public function bisaManageUser(): bool{
        return $this->isAdmin();
    }
    public function bisaManageBuku(): bool{
        return $this->isPustakawan();
    }
    public function bisaKonfirmasiPeminjaman(): bool{
        return $this->isPustakawan();
    }
    public function bisaMeminjamBuku(): bool{
        return $this->isMember();
    }
*/

}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use PhpParser\Node\Expr\Array_;

/**
 * @property mixed name
 * @property mixed lastname
 * @property mixed cpf
 * @property mixed email
 * @property mixed password
 * @property mixed remember_token
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'lastname',
        'cpf',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [];

    protected $appends = [
      'companies-list',
    ];

    public function getCompaniesListAttribute(): Array
    {
        return DB::table('users_companies')->where('user_id', $this->attributes['id'])->get('company_id')->pluck('company_id');
    }

    public function companies() {
        return $this->belongsToMany(Company::class, 'users_companies', 'user_id', 'company_id', 'id');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'cnpj',
        'certificate',
        'certificate_password',
        'certificate_expire',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function setCertificateExpireAttribute($value)
    {
        $this->attributes['certificate_expire'] = Carbon::parse($value)->format('Y-m-d');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed name
 * @property mixed cnpj
 * @property mixed certificate_pem
 * @property mixed certificate_key
 * @property mixed certificate_password
 * @property mixed certificate_expire
 */
class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'cnpj',
        'certificate_pem',
        'certificate_key',
        'certificate_password',
        'certificate_expire',
    ];

    protected $hidden = [
        'certificate_pem',
        'certificate_key',
        'certificate_password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

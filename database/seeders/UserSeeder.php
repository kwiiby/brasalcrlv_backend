<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $u = new User();
        $u->name = 'Admin';
        $u->lastname = 'Admin';
        $u->cpf = '02952804176';
        $u->email = 'chborges@brasal.com.br';
        $u->password = Hash::make('password');
        $u->remember_token = Str::random(10);
        $u->save();
        $u->companies()->sync([1,2]);
    }
}

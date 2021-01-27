<?php

namespace Database\Seeders;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cs = [
            [
                'name' => 'Brasal refrigerantes',
                'cnpj' => '1111111111111111',
                'certificate' => 'none',
                'certificate_password' => 'none',
                'certificate_expire' => Carbon::now()->addMonths(6)->format('Y-m-d'),
            ],
            [
                'name' => 'Brasal veiculos',
                'cnpj' => '0000000000000000',
                'certificate' => 'none',
                'certificate_password' => 'none',
                'certificate_expire' => Carbon::now()->addMonths(4)->format('Y-m-d'),
            ]
        ];

        Company::insert($cs);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccountType;
use Illuminate\Support\Str;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypes = [ 
            ['name' => 'Individual'], 
            ['name' => 'Day care'], 
            ['name' => 'School Camp']
        ];

        foreach ($accountTypes as $accountTypeData) {
           
            $accountTypeData['slug'] = Str::slug($accountTypeData['name']);

            AccountType::create($accountTypeData);
        }
    }
}
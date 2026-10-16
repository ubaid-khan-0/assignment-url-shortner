<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'superadmin@example.com';

        $alreadyexists = DB::selectOne('SELECT id FROM users WHERE email = ? LIMIT 1',[$email]);

        if ($alreadyexists) {
            return;
        }

        DB::insert(
            'INSERT INTO users (company_id, name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [null,env('SUPERADMIN_NAME', 'Super Admin'),$email,Hash::make('superadmin'),'SuperAdmin',now(),now(),
            ]
        );
    
    }
}

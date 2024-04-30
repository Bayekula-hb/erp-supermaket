<?php

namespace Database\Seeders;

use App\Models\User;
use DateTime;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
        DB::table('roles')->insert([
            [
                "nameRole" => "admin",
                "descriptionRole" => "admin",
            ],
            [
                "nameRole" => "CEO",
                "descriptionRole" => "company manager",
            ],
            [
                "nameRole" => "manager",
                "descriptionRole" => "Manager",
            ],
            [
                "nameRole" => "cashier",
                "descriptionRole" => "Caissier",
            ],
        ]);

        DB::table('users')->insert([ 
            [
                'lastName' => 'admin',
                'firstName' => 'admin',
                'middleName' => 'admin',
                'userName' => 'hobedbayekula@gmail.com',
                'gender' => 'M',
                'phoneNumber' => '+243825135297',
                'email' => 'hobedbayekula@gmail.com',
                'password' => bcrypt('secret0606'),
                // 'created_at' => new DateTime(),
            ],
        ]);    
        
        DB::table('user_roles')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
        ]);
    }
}

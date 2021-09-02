<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'nassim9',
                'firstname'=>'nassim',
                'lastname'=>'talbi',
                'is_admin'=>true,
                'email' => 'nassim@nassim.fr',
                'password' => bcrypt('nassim'),
                'created_at' => now()
            ]    
        ]);
        
        // Créer 50 utilisateurs fictifs
        \App\Models\User::factory(50)->create();
    }
}

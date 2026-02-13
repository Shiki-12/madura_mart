<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'email_verified_at' => '2026-02-05 15:28:47',
                'password' => '$2y$12$NJhoLVPdxikkw.O7BrFQJ.38Io3PHS052bTrWHgmoOYJrnRDD5AGC',
                'role' => 'customer',
                'is_active' => 1,
                'address' => NULL,
                'phone_number' => NULL,
                'picture' => NULL,
                'remember_token' => 'jM1GS6Frap',
                'created_at' => '2026-02-05 15:28:47',
                'updated_at' => '2026-02-05 15:28:47',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Fatar Gaza',
                'email' => 'uknowndonp@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$etkCHYhz6RJIDGepUum8H.VwBncaSSWiCdbZCZJAiDHm3IfPMAUF6',
                'role' => 'owner',
                'is_active' => 1,
                'address' => NULL,
                'phone_number' => NULL,
                'picture' => 'profile_pictures/S46rsvMewrizYXbO0uBr7mvwZiJd7AFCpr0SV2CB.jpg',
                'remember_token' => 'OJBBMwm3943H0sW5MmHWbyNCkhiPYvcCEHmOEwxMVPzBGysi79U4zvcrFVK0',
                'created_at' => '2026-02-05 15:29:05',
                'updated_at' => '2026-02-13 16:05:39',
            ),
        ));
        
        
    }
}
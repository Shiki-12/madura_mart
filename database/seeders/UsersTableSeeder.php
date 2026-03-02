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
                'email' => 'admin@linux.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$bMdET8/d5OR8sdp5QJDxU.e1r6H.d.JPLTrCgx43fuIDJ9OWgbSZW',
                'role' => 'owner',
                'is_active' => 1,
                'address' => NULL,
                'phone_number' => NULL,
                'picture' => 'profile_pictures/1TCfQInll9Ok618Yn9TJr1R1DJVRGS3XonBxEk3o.jpg',
                'remember_token' => '7aGvVUbV5A3ETVzFmnLSlvcPamFMVUF5Q5lfJqcNEBsZCMioUgwBSa2Y4suP',
                'created_at' => '2026-02-05 15:29:05',
                'updated_at' => '2026-03-02 00:53:34',
            ),
        ));
        
        
    }
}
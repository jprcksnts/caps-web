<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('user_types')->insert([
            [
                'type' => 'Admin',
            ],
            [
                'type' => 'Staff',
            ],
        ]);
    }
}

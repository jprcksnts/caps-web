<?php

use App\Models\User\UserType;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User\User::class)->create([
            'name' => 'Jon Doe',
            'email' => 'admin@caps-web.com',
            'user_type_id' => UserType::ADMIN_TYPE_ID,
        ]);

        factory(App\Models\User\User::class)->create([
            'name' => 'Jane Doe',
            'email' => 'staff@caps-web.com',
            'user_type_id' => UserType::STAFF_TYPE_ID,
        ]);
    }
}

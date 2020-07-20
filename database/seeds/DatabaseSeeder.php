<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BranchSeeder::class);

        if (config('app.env') != 'production') {
            $this->call(ProductTypeSeeder::class);
        }
    }
}

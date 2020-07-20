<?php

use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('branches')->insert([
            [
                'name' => 'Warehouse',
                'address' => '123 Street',
                'city' => 'Neverland',
            ]
        ]);
    }
}

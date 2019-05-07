<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('roles')->insert([
			'role_name'=>'REGULAR_USER',
			'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('roles')->insert([
			'role_name'=>'ADMIN',
			'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}

<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
                'name'=>Str::random(10),
                'email'=>Str::random(10).'@gmail.com',
                'password'=>bcrypt('secret'),
                'type_user_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            DB::table('users')->insert([
                'name'=>'bbq',
                'email'=>'bbq@test.com',
                'type_user_id'=>1,
                'password'=>bcrypt('bbq'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        	DB::table('users')->insert([
        		'name'=>'test',
        		'email'=>'test@test.com',
                'type_user_id'=>2,
        		'password'=>bcrypt('test'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
        	]);
    }
}

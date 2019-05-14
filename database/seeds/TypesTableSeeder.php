<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
        	'type_name'=>'client_user',
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
         DB::table('types')->insert([
        	'type_name'=>'bbq_user',
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}

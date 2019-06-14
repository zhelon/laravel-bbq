<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
        	'client_id'		=> 1,
        	'bbq_id'		=> 2,
        	'total_price'	=>'8000',
        	'address'		=> 'Carrera 781',
        	'date_service' 	=> Carbon::now(),
        	'publication_id'=> 1,
        	'client_confirmed' => true,
        	'bbq_confirmed' => false,
        	'status' 		=> 'created',
        	'created_at' 	=> Carbon::now(),
            'updated_at' 	=> Carbon::now()
        ]);
    }

}

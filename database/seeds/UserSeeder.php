<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$faker = Faker::create('id_ID');

    	for($i = 1; $i <=300000; $i++){

    		DB::table('mst_user')->insert([
    			'fullname' => $faker->name,
    			'email' => $faker->companyEmail,
    			'phone' => $faker->phoneNumber,
    			'ktp' =>$faker->randomNumber($nbDigits = NULL, $strict = false)  ,
    			'address' => $faker->address,
    			'password' =>Hash::make('000000'),
    			'verification_token' =>Str::random(100)
    		]);

    	}

    }
}
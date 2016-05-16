<?php

use Illuminate\Database\Seeder;

class TokenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('token')->delete();

        $values = array(
            array('{name}','Customer Full Name',1,1,'2015-10-27 15:47:30','2015-10-27 15:47:32'),
            array('{fname}','Customer First Name',1,1,'2015-10-27 15:47:34','2015-10-27 15:47:37'),
            array('{lname}','Customer Last Name',1,1,'2015-10-27 15:47:39','2015-10-27 15:47:41'),
            array('{email}','Customer Email Address',1,1,'2015-10-27 15:47:44','2015-10-27 15:47:46'),
            array('{subject}','All Message Subject',1,1,'2015-10-27 15:47:44','2015-10-27 15:47:46'),
        );

        foreach($values as $v) {
            \App\Token::insert(array(
                'token' => $v[0],
                'description' => $v[1],
                'created_by' => $v[2],
                'updated_by' => $v[3],
                'created_at' => $v[4],
                'updated_at' => $v[5],
            ));
        }
    }
}

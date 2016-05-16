<?php

use Illuminate\Database\Seeder;

class CentralSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('central_settings')->delete();

        $values = array(
            array('login-notification', 'yes', 'admin'),
            #array('max_public_domain_emails_per_day', '3', 'user'),
            array('is-paused', 'yes', 'user'),
            array('no_of_generate_email', '1', 'admin'),
            array('first-mail-send-by-public-or-domain', 'public', 'admin'),
            array('resume-or-stop-if-msg-order-no-exceed', 'resume', 'admin'),  // value/status = 'resume', 'stop'
            array('how-many-msg-for-new-email', '2', 'admin'),
            array('sender-email-checking', 'yes', 'admin'),
        );

        foreach($values as $v) {
            \App\CentralSettings::insert(array(
                'title' => $v[0],
                'status' => $v[1],
                'user_type' => $v[2],

                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}

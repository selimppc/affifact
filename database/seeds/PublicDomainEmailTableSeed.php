<?php

use Illuminate\Database\Seeder;

class PublicDomainEmailTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('public_domain')->delete();

        $values = array(
            array('ymail.com', 'ymail', '1'),
            array('smtp.mail.yahoo.com', 'smtp', '1'),
            array('yahoo.com', 'yahoo', '1'),
            array('gmail.com', 'gmail', '1'),
            array('smtp.gmail.com', 'smtp', '1'),
            array('google.com', 'google', '1'),
            array('smtp.google.com', 'smtp', '1'),
            array('msn.com', 'msn', '1'),
            array('smtp.msn.com', 'smtp', '1'),
            array('smtp.ymail.com', 'smtp', '1'),
            array('smtp.mail.ymail.com', 'smtp', '1'),
            array('smtp.facebook.com', 'smtp', '1'),
            array('live.com', 'live.com', '1'),
            array('imap.live.com', 'live.com', '1'),
            array('smtp.live.com', 'live.com', '1'),
            array('smtp.zoho.com', 'zoho.com', '1'),
            array('zoho.com', 'zoho.com', '1'),
            array('imap.zoho.com', 'zoho.com', '1'),
            array('smtp.hotmail.com', 'hotmail.com', '1'),
            array('imap.hotmail.com', 'hotmail.com', '1'),
            array('hotmail.com', 'hotmail.com', '1'),
            array('smtp.outlook.com', 'outlook.com', '1'),
            array('outlook.com', 'outlook.com', '1'),
            array('imap-mail.outlook.com', 'outlook.com', '1'),
            array('smtp.aol.com', 'aol.com', '1'),
            array('imap.aol.com', 'aol.com', '1'),
            array('aol.com', 'aol.com', '1'),
            array('facebook.com', 'facebook.com', '1'),
            array('mail.ru', 'mail.ru', '1'),
            array('smtp.mail.ru', 'mail.ru', '1'),
            array('imap.mail.ru', 'mail.ru', '1'),
            array('mail.com', 'mail.com', '1'),
            array('stmp.mail.com', 'mail.com', '1'),
            array('imap.mail.com', 'mail.com', '1'),
            array('gmx.com', 'gmx.com', '1'),
            array('stmp.gmx.com', 'gmx.com', '1'),
            array('imap.gmx.com', 'gmx.com', '1'),
            array('inbox.ru', 'inbox.ru', '1'),
            array('smtp.inbox.ru', 'inbox.ru', '1'),
            array('imap.inbox.ru', 'inbox.ru', '1'),
            array('list.ru', 'list.ru', '1'),
            array('smtp.list.ru', 'list.ru', '1'),
            array('imap.list.ru', 'list.ru', '1'),
            array('bk.ru', 'bk.ru', '1'),
            array('smtp.bk.ru', 'bk.ru', '1'),
            array('imap.bk.ru', 'bk.ru', '1'),
            array('vk.com', 'vk.com', '1'),
            array('smtp.vk.com', 'vk.com', '1'),
            array('imap.vk.com', 'vk.com', '1'),
            array('gmx.com', 'gmx.com', '1'),
            array('smtp.gmx.com', 'gmx.com', '1'),
            array('imap.gmx.com', 'gmx.com', '1'),
        );


        //store into table sender_email
        foreach($values as $v) {
            \App\PublicDomain::insert(array(
                'title' => $v[0],
                'domain_name' => $v[1],
                'status' => $v[1],
                'created_by' => 1,
                'updated_by' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => '',
            ));
        }
    }
}

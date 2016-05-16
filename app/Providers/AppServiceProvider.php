<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Smtp;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*$mail_smtp = DB::table('sender_email as se')
            ->join('smtp as sm', function ($join) {
                $join->on('se.smtp_id', '=', 'sm.id');
            })
            ->where('se.email','=','devdhaka404@yahoo.com')
            ->first();

        /*
         * Configure Mail.php // @Overriding  TODO:: not done yet .. configure them all

        Config::set('mail.driver', 'smtp');
        Config::set('mail.host', $mail_smtp->host);
        Config::set('mail.port', $mail_smtp->port);
        Config::set('mail.from', ['address' => $mail_smtp->email, 'name' => $mail_smtp->name]);
        Config::set('mail.encryption', 'ssl');
        Config::set('mail.username', $mail_smtp->email);
        Config::set('mail.password', $mail_smtp->password);
        Config::set('mail.sendmail', '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', false);*/

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

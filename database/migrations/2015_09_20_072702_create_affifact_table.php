<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffifactTable extends Migration
{
    public function up()
    {


        /*
         * smtp
         */
        Schema::create('smtp', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 64)->unique();
            $table->string('server_username', 64)->nullable();
            $table->string('server_password', 64)->nullable();
            
            $table->string('host', 128)->nullable();
            $table->integer('port', false, 4)->nullable();

            $table->enum('auth',array(
                'true', 'false'
            ))->nullable();
            $table->enum('secure',array(
                'ssl', 'tsl'
            ))->nullable();
            $table->integer('mails_per_day_per_email',false,11);
            $table->integer('count',false,11);

            $table->enum('type',array(
                'email-create', 'no-email-create'
            ))->nullable();
            $table->string('smtp', 128)->nullable();
            $table->integer('c_port',false,11);

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });



        /*
         * imap
         */
        Schema::create('imap', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 64)->nullable();
            $table->string('host', 128)->nullable();
            $table->integer('port', false, 4)->nullable();

            $table->enum('charset',array(
                'utf_8', 'utf_16'
            ))->nullable();
            $table->enum('secure',array(
                'ssl', 'tsl'
            ))->nullable();
            $table->integer('count',false,11);

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });



        /*
         * popping_email
         */
        Schema::create('popping_email', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 64)->unique();
            $table->string('email', 128)->nullable();
            $table->string('password', 64)->nullable();

            $table->unsignedInteger('smtp_id')->nullable();
            $table->unsignedInteger('imap_id')->nullable();

            $table->text('token')->nullable();
            $table->string('code', 128)->nullable();
            $table->string('auth_id', 64)->nullable();
            $table->string('auth_email', 64)->nullable();
            $table->string('auth_avatar', 128)->nullable();
            $table->enum('auth_type', [
                'google', 'facebook', 'twitter', 'linkedin'
            ])->nullable();


            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('popping_email', function($table) {
            $table->foreign('smtp_id')->references('id')->on('smtp');
            $table->foreign('imap_id')->references('id')->on('imap');
        });



        /*
         * campaign
         */
        Schema::create('campaign', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->unique();
            $table->unsignedInteger('popping_email_id')->nullable();
            $table->enum('status',array(
                'active', 'inactive'
            ))->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('campaign', function($table) {
            $table->foreign('popping_email_id')->references('id')->on('popping_email');
        });



        /*
         * sender_email
         */
        Schema::create('sender_email', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id')->nullable();

            $table->string('name', 64)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('password', 64)->nullable();

            $table->unique(['campaign_id', 'email']);

            $table->unsignedInteger('smtp_id')->nullable();
            $table->unsignedInteger('imap_id')->nullable();
            $table->enum('popping_status',array(
                'true', 'false'
            ))->nullable();
            $table->enum('status',array(
                'public', 'domain','invalid',
            ))->nullable();

            $table->enum('type',array(
                'generated', 'not-generated'
            ))->nullable();

            $table->integer('count', false, 10);
            $table->integer('count_per_min_pm', false, 10);
            $table->integer('max_email_send', false, 10)->nullable();
            $table->text('auth_token')->nullable();
            $table->string('auth_code', 128)->nullable();
            $table->string('auth_id', 64)->nullable();
            $table->string('auth_email', 64)->nullable();
            $table->string('auth_avatar', 128)->nullable();
            $table->enum('api_type',array(
                'api', 'non-api', 'google'
            ))->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('sender_email', function($table) {
            $table->foreign('campaign_id')->references('id')->on('campaign');
            $table->foreign('smtp_id')->references('id')->on('smtp');
            $table->foreign('imap_id')->references('id')->on('imap');
        });


        /*
         * message
         */
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id')->nullable();
            $table->enum('html',array(
                'true', 'false'
            ))->nullable();
            $table->tinyInteger('delay', false, 3)->nullable();
            $table->tinyInteger('order', false, 3)->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('message', function($table) {
            $table->foreign('campaign_id')->references('id')->on('campaign');
        });

        /*
         * sub_message
         */
        Schema::create('sub_message', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('message_id')->nullable();

            $table->string('title', 64)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('order', false, 3)->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('sub_message', function($table) {
            $table->foreign('message_id')->references('id')->on('message');
        });


        /*
         * message_attachment
         */
        Schema::create('sub_message_attachment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sub_message_id')->nullable();

            $table->string('file_name', 128)->nullable();
            $table->string('file_type', 16)->nullable();
            $table->integer('file_size',false,  8)->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('sub_message_attachment', function($table) {
            $table->foreign('sub_message_id')->references('id')->on('sub_message');
        });


        /*
         * message_followup
         */
        Schema::create('followup_message', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id')->nullable();
            $table->enum('html',array(
                'true', 'false'
            ))->nullable();
            $table->tinyInteger('delay', false, 3)->nullable();
            $table->text('description')->nullable();
            $table->integer('order', false, 11);

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('followup_message', function($table) {
            $table->foreign('campaign_id')->references('id')->on('campaign');
        });

        /*
         * followup_sub_message
         */
        Schema::create('followup_sub_message', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('followup_message_id')->nullable();

            $table->string('title', 64)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('order', false, 3)->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('followup_sub_message', function($table) {
            $table->foreign('followup_message_id')->references('id')->on('followup_message');
        });


        /*
         * message_attachment_followup
        */
        Schema::create('followup_sub_message_attachment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('followup_sub_message_id')->nullable();

            $table->string('file_name', 128)->nullable();
            $table->string('file_type', 16)->nullable();
            $table->integer('file_size',false,  8)->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('followup_sub_message_attachment', function($table) {
            $table->foreign('followup_sub_message_id')->references('id')->on('followup_sub_message');
        });




        /*
         * popped_message_header
         */
        Schema::create('popped_message_header', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id')->nullable();
            $table->string('user_email', 64)->nullable();
            $table->string('user_name', 64)->nullable();
            $table->string('subject', 256)->nullable();

            $table->unsignedInteger('message_order')->nullable();
            $table->unsignedInteger('followup_message_order')->nullable();

            $table->enum('status', [
                'queued', 'not-queued', 'inactive', 'msg-ord-exceeded'
            ])->nullable();
            #$table->string('sender_email', 64)->nullable();
            $table->unsignedInteger('sender_email_id')->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('popped_message_header', function($table) {
            $table->foreign('campaign_id')->references('id')->on('campaign');
            $table->foreign('sender_email_id')->references('id')->on('sender_email');
        });




        /*
         * popped_message_detail
         */
        Schema::create('popped_message_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('popped_message_header_id')->nullable();
            $table->unsignedInteger('sub_message_id')->nullable();
            $table->unsignedInteger('followup_sub_message_id')->nullable();
            $table->string('sender_email', 64)->nullable();
            $table->enum('d_status', ['mail-read','mail-sent'])->nullable();

            $table->timestamp('sent_time')->nullable();
            $table->text('user_message_body')->nullable();
            $table->text('custom_message')->nullable();
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('popped_message_detail', function($table) {
            $table->foreign('popped_message_header_id')->references('id')->on('popped_message_header');
            $table->foreign('sub_message_id')->references('id')->on('sub_message');
            $table->foreign('followup_sub_message_id')->references('id')->on('followup_sub_message');
        });


        /*
         * email_queue
         */
        Schema::create('email_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('popped_message_header_id')->nullable();
            $table->unsignedInteger('sub_message_id')->nullable();
            $table->unsignedInteger('followup_sub_message_id')->nullable();

            $table->timestamp('send_time')->nullable();

            $table->string('reply_to', 64)->nullable();

            #$table->string('sender_email', 64)->nullable();
            $table->unsignedInteger('sender_email_id')->nullable();

            $table->string('to_email', 64)->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('email_queue', function($table) {
            $table->foreign('popped_message_header_id')->references('id')->on('popped_message_header');
            $table->foreign('sub_message_id')->references('id')->on('sub_message');
            $table->foreign('followup_sub_message_id')->references('id')->on('followup_sub_message');
            $table->foreign('sender_email_id')->references('id')->on('sender_email');
        });


        /*
         * email_queue_tmp
         */
        Schema::create('email_queue_tmp', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('popped_message_header_id')->nullable();
            $table->unsignedInteger('sub_message_id')->nullable();
            $table->unsignedInteger('followup_sub_message_id')->nullable();

            $table->timestamp('send_time')->nullable();

            $table->string('reply_to', 64)->nullable();

            $table->unsignedInteger('sender_email_id')->nullable();

            $table->string('to_email', 64)->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('email_queue_tmp', function($table) {
            $table->foreign('popped_message_header_id')->references('id')->on('popped_message_header');
            $table->foreign('sub_message_id')->references('id')->on('sub_message');
            $table->foreign('followup_sub_message_id')->references('id')->on('followup_sub_message');
            $table->foreign('sender_email_id')->references('id')->on('sender_email');
        });





        /*
         * Filter
         */
        Schema::create('filter', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->unique();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        /*
         * Token
         */
        Schema::create('token', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 64)->unique();
            $table->text('description')->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });



        /*
         * tmp_garbage
         */
        Schema::create('tmp_garbage', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host', 64)->nullable();
            $table->string('port', 64)->nullable();

            $table->unsignedInteger('sub_message_id')->nullable();
            $table->unsignedInteger('followup_sub_message_id')->nullable();

            $table->integer('campaign_id', false, 11);
            $table->integer('sender_email_id', false, 11);
            $table->integer('popped_message_header_id', false, 11);
            $table->integer('popped_message_detail_id', false, 11);
            $table->string('from_email', 128)->nullable();
            $table->string('from_name', 128)->nullable();
            $table->string('username', 128)->nullable();
            $table->string('password', 128)->nullable();
            $table->string('to_email', 128)->nullable();
            $table->text('subject')->nullable();
            $table->text('body')->nullable();
            $table->text('file_name')->nullable();
            $table->string('reply_to', 128)->nullable();
            $table->string('reply_to_name', 128)->nullable();
            $table->text('auth_token')->nullable();
            $table->string('auth_code', 128)->nullable();

            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::table('tmp_garbage', function($table) {
            $table->foreign('sub_message_id')->references('id')->on('sub_message');
            $table->foreign('followup_sub_message_id')->references('id')->on('followup_sub_message');
        });


    }


    public function down()
    {
        Schema::drop('smtp');
        Schema::drop('imap');
        Schema::drop('popping_email');
        Schema::drop('campaign');
        Schema::drop('sender_email');

        Schema::drop('message');
        Schema::drop('sub_message');
        Schema::drop('sub_message_attachment');
        Schema::drop('popped_message_header');
        Schema::drop('popped_message_detail');
        Schema::drop('followup_message');
        Schema::drop('followup_sub_message');

        Schema::drop('followup_sub_message_attachment');
        Schema::drop('email_queue');
        Schema::drop('filter');
        Schema::drop('token');
        Schema::drop('tmp_garbage');
    }
}

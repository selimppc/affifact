<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendMailFailedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_mail_failed', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host', 64)->nullable();
            $table->string('port', 64)->nullable();
            $table->integer('campaign_id', false, 11);
            $table->integer('sender_email_id', false, 11);
            $table->string('from_email', 128)->nullable();
            $table->string('from_name', 128)->nullable();
            $table->string('username', 128)->nullable();
            $table->string('password', 128)->nullable();
            $table->string('to_email', 128)->nullable();

            $table->integer('popped_message_header_id', false, 11);
            $table->integer('popped_message_detail_id', false, 11);

            $table->text('subject')->nullable();
            $table->text('body')->nullable();
            $table->text('file_name')->nullable();
            $table->string('reply_to', 128)->nullable();
            $table->string('reply_to_name', 128)->nullable();

            $table->string('start_time', 128)->nullable();
            $table->string('end_time', 128)->nullable();
            $table->integer('no_of_try', false, 11);
            $table->text('msg')->nullable();
            $table->text('auth_token')->nullable();
            $table->string('auth_code', 128)->nullable();
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('send_mail_failed');
    }
}

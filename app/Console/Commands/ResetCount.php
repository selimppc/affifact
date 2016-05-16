<?php

namespace App\Console\Commands;

use App\PoppedMessageDetail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class ResetCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:resetcount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /* reset_count_mails  from EmailQueueController */

        // Start transaction
        DB::beginTransaction();
        try
        {
            // Update count for sender_email
            DB::table('sender_email')
                //->where('status', 'public')
                //->where('type', 'not-generated')
                ->update(['count' => 0]);


            // TODO:: delete previous 24 message from Popped_Message_detail
            $previous_date = date("Y-m-d H:m:s", strtotime('-24 hours', time()));
            PoppedMessageDetail::where('d_status', '=', 'mail-sent')
                ->where('sent_time', '<=', $previous_date)
                ->delete();

            // Update count for smtp
            /*DB::table('smtp')
                //->where('type', 'no-email-create')
                ->update(['count' => 0]);*/

            //Commit
            DB::commit();
            print_r('Success');

        }
        catch (\Exception $e)
        {
            DB::rollback();
            print_r($e->getMessage());

        }

        return true;
    }
}

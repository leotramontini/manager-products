<?php

use Illuminate\Database\Seeder;
use Manager\Support\StatusSupport;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(StatusSupport::getAllStatuses() as $status) {
            DB::table('statuses')->insert($status);
        }
    }
}

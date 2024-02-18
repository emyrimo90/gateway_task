<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GatewaySettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        \DB::table('gateway_settings')->truncate();
        Schema::enableForeignKeyConstraints();
        \DB::table('gateway_settings')->insert([
            [
                'id' => 1,
                'name' => 'paypal',
                'type' => 'TEST',
                'client_id' => 'ATS3VkOb9Lyx5UL0m7JR411zo3689VwQ8LbKTvYBlKb_KWbhgEy7GMu-kOZu0__nTCl158pYbGPsyn7v',
                'client_secret' => 'EPXhTn-vhL30XTotHeU7Dp4p7kOFJGsIApZAD-RjmhhXvNdKUeuhi4g9CnqLVusshjyonffCCBxDJ-J5',
                'status' => 0,
                'response_url' => 'success-transaction',
                'cancel_url' => 'cancel-transaction',
                'currency' => 'USD',
                'created_at' => '2024-02-17 01:31:23',
                'updated_at' => '2024-02-17 05:02:44',
            ],
            [
                'id' => 2,
                'name' => 'stripe',
                'type' => 'TEST',
                'client_id' => 'pk_test_51Oj7mcLxj5aK5uIy3chsKLB7BYgSweU3k6ImFFkgOVg7FOgdolMC8cJr1jKssMLys0j94RczTCksoCmTxZ9a4Fnk001vhL1t2l',
                'client_secret' => 'sk_test_51Oj7mcLxj5aK5uIyowHEcdIRfLnESAz3sMsz8iHqosPWXg3qXGcwG1v1SZ5BoNv16obkpFsfBhyX6ifGlWmJlNaP00r3yV8Fay',
                'status' => 1,
                'response_url' => 'success-transaction',
                'cancel_url' => 'cancel-transaction',
                'currency' => 'USD',
                'created_at' => '2024-02-17 01:31:23',
                'updated_at' => '2024-02-17 05:02:44',
            ]
        ]);


    }
}

<?php


use Illuminate\Database\Seeder;
use App\Models\Company;
use Carbon\Carbon;

class companiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Company::where('email_verified_at' , null)->update(['email_verified_at'=> Carbon::now()]);

    }
}

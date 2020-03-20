<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
//         $this->call(UsersTableSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(UniversitiesSeeder::class);
        $this->call(MajorsSeeder::class);
        // $this->call(companiesSeeder::class);
        $this->call(EmailsUniversities::class);

    }

}

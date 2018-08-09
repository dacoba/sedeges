<?php

use App\Centro;
use App\Infante;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        factory(Centro::class, 20)->create();
        factory(Infante::class, 100)->create();
    }
}

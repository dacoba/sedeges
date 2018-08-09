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
        factory(Centro::class, 20)->create()->each(
            function ($centro) {
                $cantidad = rand(1, $centro->capacidad);
                factory(Infante::class, $cantidad)->create([
                    'centro_id' => $centro->id,
                ]);
            }
        );
    }
}

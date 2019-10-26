<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personnes')->insert([
            'nom' => "bouzid",
            'prenom' => "nourdine",
            'adresse' => "zouhour",
            'tel' => "0727727272",
        ]);
        DB::table('users')->insert([
            'personne_id' => 1,
            'password' => bcrypt(123),
            'email' => "bouzid@gmail.com",
            'role' => "1",
        ]);
        DB::table('magasins')->insert([
            'user_id' => 1,
            'nom' => 'Bouzid-Shop',
            'numero_de_patente' => "UAIIA8829",
            'rc' => "9292992IZIIZ",
            'numero_compte_bancaire' => "9292992IZIIZ",
        ]);
    }
}

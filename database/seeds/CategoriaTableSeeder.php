<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert(['categoria' => 'eletrodomestico']);
        DB::table('categorias')->insert(['categoria' => 'descartavel']);
        DB::table('categorias')->insert(['categoria' => 'batedeira']);
    }
}

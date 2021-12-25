<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Seeder;

class GenerosSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $generos = [
          [
              'id' => 1,
              'genero' => 'Masculino',
              'abreviado' => 'M'
          ],
           [
               'id' => 2,
               'genero' => 'Femenino',
               'abreviado' => 'F'
           ],
           [
               'id' => 3,
               'genero' => 'X',
               'abreviado' => 'X'
           ]
       ];

       foreach ($generos as $genero){
           if ($modelo = Genero::where( 'id', $genero['id'])->first()){
               $modelo->fill($genero);
               $modelo->save();
           }else {
               $modelo = new Genero();
               $modelo->fill($genero);
               $modelo->save();
           }
       }
    }
}

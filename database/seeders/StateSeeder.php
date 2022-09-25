<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::firstOrCreate(['id' => 'AC', 'name' => 'Acre']);
        State::firstOrCreate(['id' => 'AL', 'name' => 'Alagoas']);
        State::firstOrCreate(['id' => 'AP', 'name' => 'Amapá']);
        State::firstOrCreate(['id' => 'AM', 'name' => 'Amazonas']);
        State::firstOrCreate(['id' => 'BA', 'name' => 'Bahia']);
        State::firstOrCreate(['id' => 'CE', 'name' => 'Ceará']);
        State::firstOrCreate(['id' => 'DF', 'name' => 'Distrito Federal']);
        State::firstOrCreate(['id' => 'ES', 'name' => 'Espírito Santo']);
        State::firstOrCreate(['id' => 'GO', 'name' => 'Goiás']);
        State::firstOrCreate(['id' => 'MA', 'name' => 'Maranhão']);
        State::firstOrCreate(['id' => 'MT', 'name' => 'Mato Grosso']);
        State::firstOrCreate(['id' => 'MS', 'name' => 'Mato Grosso do Sul']);
        State::firstOrCreate(['id' => 'MG', 'name' => 'Minas Gerais']);
        State::firstOrCreate(['id' => 'PA', 'name' => 'Pará']);
        State::firstOrCreate(['id' => 'PB', 'name' => 'Paraíba']);
        State::firstOrCreate(['id' => 'PR', 'name' => 'Paraná']);
        State::firstOrCreate(['id' => 'PE', 'name' => 'Pernambuco']);
        State::firstOrCreate(['id' => 'PI', 'name' => 'Piauí']);
        State::firstOrCreate(['id' => 'RJ', 'name' => 'Rio de Janeiro']);
        State::firstOrCreate(['id' => 'RN', 'name' => 'Rio Grande do Norte']);
        State::firstOrCreate(['id' => 'RS', 'name' => 'Rio Grande do Sul']);
        State::firstOrCreate(['id' => 'RO', 'name' => 'Rondônia']);
        State::firstOrCreate(['id' => 'RR', 'name' => 'Roraima']);
        State::firstOrCreate(['id' => 'SC', 'name' => 'Santa Catarina']);
        State::firstOrCreate(['id' => 'SP', 'name' => 'São Paulo']);
        State::firstOrCreate(['id' => 'SE', 'name' => 'Sergipe']);
        State::firstOrCreate(['id' => 'TO', 'name' => 'Tocantins']);
    }
}

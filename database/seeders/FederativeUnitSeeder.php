<?php

namespace Database\Seeders;

use App\Models\FederativeUnit;
use Illuminate\Database\Seeder;

class FederativeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FederativeUnit::firstOrCreate(['id' => 'AC', 'name' => 'Acre']);
        FederativeUnit::firstOrCreate(['id' => 'AL', 'name' => 'Alagoas']);
        FederativeUnit::firstOrCreate(['id' => 'AP', 'name' => 'Amapá']);
        FederativeUnit::firstOrCreate(['id' => 'AM', 'name' => 'Amazonas']);
        FederativeUnit::firstOrCreate(['id' => 'BA', 'name' => 'Bahia']);
        FederativeUnit::firstOrCreate(['id' => 'CE', 'name' => 'Ceará']);
        FederativeUnit::firstOrCreate(['id' => 'DF', 'name' => 'Distrito Federal']);
        FederativeUnit::firstOrCreate(['id' => 'ES', 'name' => 'Espírito Santo']);
        FederativeUnit::firstOrCreate(['id' => 'GO', 'name' => 'Goiás']);
        FederativeUnit::firstOrCreate(['id' => 'MA', 'name' => 'Maranhão']);
        FederativeUnit::firstOrCreate(['id' => 'MT', 'name' => 'Mato Grosso']);
        FederativeUnit::firstOrCreate(['id' => 'MS', 'name' => 'Mato Grosso do Sul']);
        FederativeUnit::firstOrCreate(['id' => 'MG', 'name' => 'Minas Gerais']);
        FederativeUnit::firstOrCreate(['id' => 'PA', 'name' => 'Pará']);
        FederativeUnit::firstOrCreate(['id' => 'PB', 'name' => 'Paraíba']);
        FederativeUnit::firstOrCreate(['id' => 'PR', 'name' => 'Paraná']);
        FederativeUnit::firstOrCreate(['id' => 'PE', 'name' => 'Pernambuco']);
        FederativeUnit::firstOrCreate(['id' => 'PI', 'name' => 'Piauí']);
        FederativeUnit::firstOrCreate(['id' => 'RJ', 'name' => 'Rio de Janeiro']);
        FederativeUnit::firstOrCreate(['id' => 'RN', 'name' => 'Rio Grande do Norte']);
        FederativeUnit::firstOrCreate(['id' => 'RS', 'name' => 'Rio Grande do Sul']);
        FederativeUnit::firstOrCreate(['id' => 'RO', 'name' => 'Rondônia']);
        FederativeUnit::firstOrCreate(['id' => 'RR', 'name' => 'Roraima']);
        FederativeUnit::firstOrCreate(['id' => 'SC', 'name' => 'Santa Catarina']);
        FederativeUnit::firstOrCreate(['id' => 'SP', 'name' => 'São Paulo']);
        FederativeUnit::firstOrCreate(['id' => 'SE', 'name' => 'Sergipe']);
        FederativeUnit::firstOrCreate(['id' => 'TO', 'name' => 'Tocantins']);
    }
}

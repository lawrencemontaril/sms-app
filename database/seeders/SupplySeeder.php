<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supply;

class SupplySeeder extends Seeder
{
    /*
    | -------------------------
    |  Run the database seeds.
    | -------------------------
    */
    public function run(): void
    {
        $supplies = [
            [
                'name' => 'Pen',
                'price' => '12',
                'quantity' => '500',
                'reorder_level' => '100'
            ],
            [
                'name' => 'Pencil',
                'price' => '35',
                'quantity' => '100',
                'reorder_level' => '50'
            ],
            [
                'name' => 'Notebook',
                'price' => '65',
                'quantity' => '300',
                'reorder_level' => '70'
            ],
            [
                'name' => 'Whiteboard marker',
                'price' => '80',
                'quantity' => '40',
                'reorder_level' => '50'
            ],
            [
                'name' => 'Glue stick',
                'price' => '35',
                'quantity' => '100',
                'reorder_level' => '50'
            ],
            [
                'name' => 'Tape',
                'price' => '45',
                'quantity' => '0',
                'reorder_level' => '75'
            ],
        ];

        foreach ($supplies as $supply) {
            $supply = Supply::firstOrCreate($supply);
        }
    }
}

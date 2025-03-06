<?php

use App\Models\Material;
use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Criar 50 materiais
            $materiais = Material::factory(50)->create();

            // Criar 30 documentos (15 entradas e 15 saídas)
            Document::factory(15)->create(['type' => 'entry'])
                ->each(function ($document) use ($materiais) {
                    // Adicionar 3 itens por documento de entrada
                    $document->items()->createMany(
                        Material::inRandomOrder()
                            ->limit(3)
                            ->get()
                            ->map(function ($material) {
                                return [
                                    'material_id' => $material->id,
                                    'quantity' => rand(10, 100),
                                    'unit_price' => $material->average_unit_price
                                ];
                            })->toArray()
                    );

                    // Atualizar estoque e criar movimentações
                    foreach ($document->items as $item) {
                        $material = $item->material;
                        $material->increment('quantity', $item->quantity);
                        
                        $document->movements()->create([
                            'material_id' => $material->id,
                            'type' => 'entry',
                            'quantity' => $item->quantity,
                            'observation' => 'Entrada inicial'
                        ]);
                    }
                });

            Document::factory(15)->create(['type' => 'exit'])
                ->each(function ($document) use ($materiais) {
                    // Adicionar 2 itens por documento de saída
                    $document->items()->createMany(
                        Material::inRandomOrder()
                            ->where('quantity', '>', 10)
                            ->limit(2)
                            ->get()
                            ->map(function ($material) {
                                $qtd = rand(1, $material->quantity);
                                return [
                                    'material_id' => $material->id,
                                    'quantity' => $qtd,
                                    'unit_price' => $material->average_unit_price
                                ];
                            })->toArray()
                    );

                    // Atualizar estoque e criar movimentações
                    foreach ($document->items as $item) {
                        $material = $item->material;
                        $material->decrement('quantity', $item->quantity);
                        
                        $document->movements()->create([
                            'material_id' => $material->id,
                            'type' => 'exit',
                            'quantity' => $item->quantity,
                            'observation' => 'Saída para ' . $document->recipient
                        ]);
                    }
                });
        });
    }
}

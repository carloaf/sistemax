<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // this->call([
        //     SampleDataSeeder::class
        // ]);

        // Criar 50 materiais
        \App\Models\Material::factory(50)->create();

        // Criar 20 documentos com itens e movimentações
        \App\Models\Document::factory(20)
            ->hasDocumentItems(3) // 3 itens por documento
            ->create()
            ->each(function ($document) {
                // Criar movimentação para cada item
                foreach ($document->items as $item) {
                    \App\Models\Movement::create([
                        'material_id' => $item->material_id,
                        'document_id' => $document->id,
                        'type' => 'entry',
                        'quantity' => $item->quantity,
                        'observation' => 'Entrada via documento ' . $document->document_number
                    ]);

                    // Atualizar estoque
                    $material = \App\Models\Material::find($item->material_id);
                    $material->quantity += $item->quantity;
                    $material->save();
                }
            });
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Drink Misterioso',
                'description' => 'Prendi il bicchiere della festeggiata e bevine un sorso senza dire nulla.',
                'max_assignments' => 3,
            ],
            [
                'title' => 'L’apparizione',
                'description' => 'Entra nella stanza urlando: "È arrivato il/la laureato/a... ah no, mi sono sbagliato!"',
                'max_assignments' => 2,
            ],
            [
                'title' => 'Sparizione Improvvisa',
                'description' => 'Inizia a parlare con la festeggiata, poi sparisci a metà frase senza spiegazioni.',
                'max_assignments' => 3,
            ],
            [
                'title' => 'Complimento Strano',
                'description' => 'Fai un complimento alla festeggiata... su qualcosa di totalmente a caso (es. le scarpe del DJ).',
                'max_assignments' => 5,
            ],
            [
                'title' => 'Foto Infiltrata',
                'description' => 'Fatti fare una foto di gruppo e infìltrati senza essere invitato.',
                'max_assignments' => 4,
            ],
            [
                'title' => 'Finta Chiamata',
                'description' => 'Mentre parli con la festeggiata, rispondi al telefono dicendo: "Sì, ho trovato il pacco!"',
                'max_assignments' => 2,
            ],
            [
                'title' => 'Sospiro Profondo',
                'description' => 'Ogni volta che la festeggiata dice qualcosa, fai un grande sospiro e guarda il cielo.',
                'max_assignments' => 3,
            ],
            [
                'title' => 'Complottista',
                'description' => 'Sussurra alla festeggiata: "Stanno parlando tutti di te... ma io non ti ho detto niente!"',
                'max_assignments' => 3,
            ],
            [
                'title' => 'Il Ballo Imbarazzante',
                'description' => 'Balli vicino alla festeggiata in modo ridicolo per almeno 30 secondi.',
                'max_assignments' => 2,
            ],
            [
                'title' => 'Scambio di Identità',
                'description' => 'Presentati alla festeggiata con un nome inventato e una storia assurda.',
                'max_assignments' => 4,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}

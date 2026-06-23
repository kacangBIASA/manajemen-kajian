<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PanitiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panitias = [
            ['name' => 'Ahmad Fauzi', 'email' => 'fauzi@tadzkirah.id'],
            ['name' => 'Siti Rahma', 'email' => 'rahma@tadzkirah.id'],
            ['name' => 'Rizky Maulana', 'email' => 'rizky@tadzkirah.id'],
        ];

        $eventIds = \App\Models\Event::pluck('id')->toArray();

        foreach ($panitias as $data) {
            $panitia = \App\Models\User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => \Illuminate\Support\Facades\Hash::make('panitia123'),
                    'role' => 'panitia',
                ]
            );

            // assign ke semua event yang ada
            if ($eventIds) {
                $panitia->events()->syncWithoutDetaching($eventIds);
            }
        }
    }
}

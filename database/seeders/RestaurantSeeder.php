<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\RestaurantOpenTime;
use App\Models\User;
use Carbon\Carbon;

class RestaurantSeeder extends Seeder
{
    private array $daysMap = [
        'Mon' => 1,
        'Tue' => 2,
        'Wed' => 3,
        'Thu' => 4,
        'Fri' => 5,
        'Sat' => 6,
        'Sun' => 7,
    ];

    private array $initial_data = [
        "Kushi Tsuru" => "Mon-Sun 11:30 am - 9 pm",
        "Osakaya Restaurant" => "Mon-Thu, Sun 11:30 am - 9 pm / Fri-Sat 11:30 am - 9:30 pm",
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();

        foreach ($this->initial_data as $name => $scheduleString) {
            dump($name, $scheduleString);

            $restaurant = Restaurant::firstOrCreate(
                ['name' => $name],
                [
                    'address' => 'Unknown',
                    'phone_number' => null,
                    'note' => null,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]
            );

            // Split by "/"
            $timeComponents = explode('/', $scheduleString);

            foreach ($timeComponents as $component) {

                $component = trim($component);

                // Split days part and time part
                preg_match('/(.+?)\s(\d{1,2}:\d{2}\s?[ap]m\s-\s\d{1,2}(:\d{2})?\s?[ap]m)/i', $component, $matches);

                if (!$matches) continue;

                $daysPart = trim($matches[1]);
                $timePart = trim($matches[2]);

                // Parse time
                [$startRaw, $endRaw] = array_map('trim', explode('-', $timePart));

                $timeStart = Carbon::parse($startRaw)->format('H:i:s');
                $timeEnd   = Carbon::parse($endRaw)->format('H:i:s');

                // Split multiple day groups (comma separated)
                $dayGroups = explode(',', $daysPart);

                foreach ($dayGroups as $group) {

                    $group = trim($group);

                    if (str_contains($group, '-')) {
                        [$startDay, $endDay] = explode('-', $group);

                        $dayStart = $this->daysMap[trim($startDay)];
                        $dayEnd   = $this->daysMap[trim($endDay)];
                    } else {
                        $dayStart = $this->daysMap[$group];
                        $dayEnd   = $dayStart;
                    }

                    $existing = RestaurantOpenTime::where('restaurant_id', $restaurant->id)
                        ->where('day_start', $dayStart)
                        ->where('day_end', $dayEnd)
                        ->where('time_start', $timeStart)
                        ->where('time_end', $timeEnd)
                        ->first();

                    if (!$existing) {
                        RestaurantOpenTime::create([
                            'restaurant_id' => $restaurant->id,
                            'day_start' => $dayStart,
                            'day_end'   => $dayEnd,
                            'time_start'=> $timeStart,
                            'time_end'  => $timeEnd,
                        ]);
                    }
                }
            }
        }
    }
}
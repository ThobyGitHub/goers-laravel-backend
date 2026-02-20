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
        'Tues' => 2,
        'Wed' => 3,
        'Weds' => 3,
        'Thu' => 4,
        'Thurs' => 4,
        'Fri' => 5,
        'Sat' => 6,
        'Sun' => 7,
    ];

    private array $initial_data = [
        "Kushi Tsuru" => "Mon-Sun 11:30 am - 9 pm",
        "Osakaya Restaurant" => "Mon-Thu, Sun 11:30 am - 9 pm / Fri-Sat 11:30 am - 9:30 pm",
        "The Stinking Rose" => "Mon-Thu, Sun 11:30 am - 10 pm / Fri-Sat 11:30 am - 11 pm",
        "McCormick & Kuleto's" => "Mon-Thu, Sun 11:30 am - 10 pm / Fri-Sat 11:30 am - 11 pm",
        "Mifune Restaurant" => "Mon-Sun 11 am - 10 pm",
        "The Cheesecake Factory" => "Mon-Thu 11 am - 11 pm / Fri-Sat 11 am - 12:30 am / Sun 10 am - 11 pm",
        "New Delhi Indian Restaurant" => "Mon-Sat 11:30 am - 10 pm / Sun 5:30 pm - 10 pm",
        "Iroha Restaurant" => "Mon-Thu, Sun 11:30 am - 9:30 pm / Fri-Sat 11:30 am - 10 pm",
        "Rose Pistola" => "Mon-Thu 11:30 am - 10 pm / Fri-Sun 11:30 am - 11 pm",
        "Alioto's Restaurant" => "Mon-Sun 11 am - 11 pm",
        "Canton Seafood & Dim Sum Restaurant" => "Mon-Fri 10:30 am - 9:30 pm / Sat-Sun 10 am - 9:30 pm",
        "All Season Restaurant" => "Mon-Fri 10 am - 9:30 pm / Sat-Sun 9:30 am - 9:30 pm",
        "Bombay Indian Restaurant" => "Mon-Sun 11:30 am - 10:30 pm",
        "Sam's Grill & Seafood Restaurant" => "Mon-Fri 11 am - 9 pm / Sat 5 pm - 9 pm",
        "2G Japanese Brasserie" => "Mon-Thu, Sun 11 am - 10 pm / Fri-Sat 11 am - 11 pm",
        "Restaurant Lulu" => "Mon-Thu, Sun 11:30 am - 9 pm / Fri-Sat 11:30 am - 10 pm",
        "Sudachi" => "Mon-Wed 5 pm - 12:30 am / Thu-Fri 5 pm - 1:30 am / Sat 3 pm - 1:30 am / Sun 3 pm - 11:30 pm",
        "Hanuri" => "Mon-Sun 11 am - 12 am",
        "Herbivore" => "Mon-Thu, Sun 9 am - 10 pm / Fri-Sat 9 am - 11 pm",
        "Penang Garden" => "Mon-Thu 11 am - 10 pm / Fri-Sat 10 am - 10:30 pm / Sun 11 am - 11 pm",
        "John's Grill" => "Mon-Sat 11 am - 10 pm / Sun 12 pm - 10 pm",
        "Quan Bac" => "Mon-Sun 11 am - 10 pm",
        "Bamboo Restaurant" => "Mon-Sat 11 am - 12 am / Sun 12 pm - 12 am",
        "Burger Bar" => "Mon-Thu, Sun 11 am - 10 pm / Fri-Sat 11 am - 12 am",
        "Blu Restaurant" => "Mon-Fri 11:30 am - 10 pm / Sat-Sun 7 am - 3 pm",
        "Naan 'N' Curry" => "Mon-Sun 11 am - 4 am",
        "Shanghai China Restaurant" => "Mon-Sun 11 am - 9:30 pm",
        "Tres" => "Mon-Thu, Sun 11:30 am - 10 pm / Fri-Sat 11:30 am - 11 pm",
        "Isobune Sushi" => "Mon-Sun 11:30 am - 9:30 pm",
        "Viva Pizza Restaurant" => "Mon-Sun 11 am - 12 am",
        "Far East Cafe" => "Mon-Sun 11:30 am - 10 pm",
        "Parallel 37" => "Mon-Sun 11:30 am - 10 pm",
        "Bai Thong Thai Cuisine" => "Mon-Sat 11 am - 11 pm / Sun 11 am - 10 pm",
        "Alhamra" => "Mon-Sun 11 am - 11 pm",
        "A-1 Cafe Restaurant" => "Mon, Wed-Sun 11 am - 10 pm",
        "Nick's Lighthouse" => "Mon-Sun 11 am - 10:30 pm",
        "Paragon Restaurant & Bar" => "Mon-Fri 11:30 am - 10 pm / Sat 5:30 pm - 10 pm",
        "Chili Lemon Garlic" => "Mon-Fri 11 am - 10 pm / Sat-Sun 5 pm - 10 pm",
        "Bow Hon Restaurant" => "Mon-Sun 11 am - 10:30 pm",
        "San Dong House" => "Mon-Sun 11 am - 11 pm",
        "Thai Stick Restaurant" => "Mon-Sun 11 am - 1 am",
        "Cesario's" => "Mon-Thu, Sun 11:30 am - 10 pm / Fri-Sat 11:30 am - 10:30 pm",
        "Colombini Italian Cafe Bistro" => "Mon-Fri 12 pm - 10 pm / Sat-Sun 5 pm - 10 pm",
        "Sabella & La Torre" => "Mon-Thu, Sun 10 am - 10:30 pm / Fri-Sat 10 am - 12:30 am",
        "Soluna Cafe and Lounge" => "Mon-Fri 11:30 am - 10 pm / Sat 5 pm - 10 pm",
        "Tong Palace" => "Mon-Fri 9 am - 9:30 pm / Sat-Sun 9 am - 10 pm",
        "India Garden Restaurant" => "Mon-Sun 10 am - 11 pm",
        "Sapporo-Ya Japanese Restaurant" => "Mon-Sat 11 am - 11 pm / Sun 11 am - 10:30 pm",
        "Santorini's Mediterranean Cuisine" => "Mon-Sun 8 am - 10:30 pm",
        "Kyoto Sushi" => "Mon-Thu 11 am - 10:30 pm / Fri 11 am - 11 pm / Sat 11:30 am - 11 pm / Sun 4:30 pm - 10:30 pm",
        "Marrakech Moroccan Restaurant" => "Mon-Sun 5:30 pm - 2 am",
        "Parallel 37" => "Mon, Fri 5 pm - 6:15 pm / Tues 12:15 pm - 12:15 pm / Weds 1:15 pm - 5:45 pm / Thurs, Sat 10 am - 3 pm / Sun 6:30 am - 12:45 pm"
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
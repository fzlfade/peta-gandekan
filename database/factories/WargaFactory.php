<?php

namespace Database\Factories;

use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Coordinate bounds around the map center so they render on the Leaflet map view
        $latitude = fake()->latitude(-7.734, -7.728);
        $longitude = fake()->longitude(110.337, 110.342);

        // Generate Indonesian addresses and names
        $street = fake('id_ID')->streetName();
        $number = fake()->numberBetween(1, 150);
        $rt = fake()->numberBetween(1, 8);
        $rw = fake()->numberBetween(1, 5);

        return [
            'nama_pemilik' => fake('id_ID')->name(),
            'alamat' => "Jl. {$street} No. {$number}, RT {$rt} / RW {$rw}, Gandekan, Tlogoadi, Mlati, Sleman",
            'latitude' => (float) $latitude,
            'longitude' => (float) $longitude,
        ];
    }
}

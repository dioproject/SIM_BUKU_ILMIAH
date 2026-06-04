<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Buku;

class BookFactory extends Factory
{
    protected $model = Buku::class;

    public function definition()
    {
        return [
            'judul' => $this->faker->sentence(4),
            'template' => $this->faker->text(50),
            'total_bab' => $this->faker->numberBetween(5, 20),
        ];
    }
}

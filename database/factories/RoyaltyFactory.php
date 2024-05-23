<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Royalty;

class RoyaltyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Royalty::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'book_id' => Book::factory(),
            'amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'date' => $this->faker->dateTime(),
            'path_foto' => $this->faker->regexify('[A-Za-z0-9]{150}'),
        ];
    }
}

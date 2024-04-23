<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_book' => $this->faker->numberBetween(-10000, 10000),
            'title' => $this->faker->sentence(4),
            'sub_title' => $this->faker->regexify('[A-Za-z0-9]{40}'),
            'fill' => $this->faker->text,
            'review' => $this->faker->text,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Status;
use App\Models\User;

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
            'title' => $this->faker->sentence(4),
            'template' => $this->faker->regexify('[A-Za-z0-9]{250}'),
            'status_id' => Status::factory(),
            'user_id' => User::factory(),
        ];
    }
}

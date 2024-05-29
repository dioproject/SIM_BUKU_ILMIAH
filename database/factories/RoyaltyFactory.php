<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\User;
use App\Models\Royalty;
use App\Models\Status;

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
            'amount' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'path_foto' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'status_id' => Status::factory(),
            'author_id' => User::factory(),
        ];
    }
}

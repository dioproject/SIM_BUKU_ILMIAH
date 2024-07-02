<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Category;
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
            'script' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'template' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'category_id' => Category::factory(),
            'status_id' => Status::factory(),
            'author_id' => User::factory(),
        ];
    }
}

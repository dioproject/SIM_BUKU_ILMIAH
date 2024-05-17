<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\User;

class ManuscriptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manuscript::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'abstract' => $this->faker->text,
            'fill' => $this->faker->text,
            'submission_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["SUBMITTED","REVIEWING","PUBLISHED","REJECTED"]),
            'author_id' => User::factory(),
            'book_id' => Book::factory(),
        ];
    }
}

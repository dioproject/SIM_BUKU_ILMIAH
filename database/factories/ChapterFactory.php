<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Status;
use App\Models\User;

class ChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chapter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'chapter' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'deadline' => $this->faker->date(),
            'notes' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'file_chapter' => $this->faker->regexify('[A-Za-z0-9]{250}'),
            'file_review' => $this->faker->regexify('[A-Za-z0-9]{250}'),
            'book_id' => Book::factory(),
            'author_id' => User::factory(),
            'reviewer_id' => User::factory(),
            'status_id' => Status::factory(),
        ];
    }
}

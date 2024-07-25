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
            'chapter' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'notes' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'file_chapter' => $this->faker->regexify('[A-Za-z0-9]{250}'),
            'file_review' => $this->faker->regexify('[A-Za-z0-9]{250}'),
            'author_id' => User::factory(),
            'reviewer_id' => User::factory(),
            'book_id' => Book::factory(),
            'status_id' => Status::factory(),
            'deadline' => $this->faker->date(),
            'uploaded_at' => $this->faker->date(),
            'verified_at' => $this->faker->date(),
            'approved_at' => $this->faker->date(),
        ];
    }
}

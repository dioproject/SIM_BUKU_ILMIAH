<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\File;
use App\Models\Status;
use App\Models\User;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(["Template","Chapter","Review"]),
            'book_id' => Book::factory(),
            'chapter_id' => Chapter::factory(),
            'user_id' => User::factory(),
            'status_id' => Status::factory(),
            'deadline' => $this->faker->date(),
            'uploaded_at' => $this->faker->date(),
            'verified_at' => $this->faker->date(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->word,
            'data' => [
                'chapter_id' => Chapter::factory(), 
                'chapter' => $this->faker->sentence,
                'status_id' => Status::factory(),
            ],
            'is_read' => $this->faker->boolean,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bab;
use App\Models\Buku;
use App\Models\Status;
use App\Models\User;

class ChapterFactory extends Factory
{
    protected $model = Bab::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->sentence(3),
            'catatan' => $this->faker->text(50),
            'author_id' => User::factory(),
            'reviewer_id' => User::factory(),
            'buku_id' => Buku::factory(),
            'status_id' => Status::factory(),
        ];
    }
}

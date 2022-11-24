<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommentsScanning>
 */
class CommentsScanningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => 200,
            'last' => $this->faker->unixTime,
            'difference' => 10,
            'requestorIp' => $this->faker->ipv4()
        ];
    }
}

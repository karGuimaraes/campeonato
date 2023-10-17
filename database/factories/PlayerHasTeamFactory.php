<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlayerHasTeam>
 */
class PlayerHasTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $player = Player::factory()->create();
        $team = Team::factory()->create();
        return [
            'player_id' => $player->id,
            'team_id' => $team->id
        ];
    }
}

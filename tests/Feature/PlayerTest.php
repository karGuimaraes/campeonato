<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_query_players()
    {
        $player = Player::factory()->create();

        $this->withHeaders([])->query('players', ['data' => ['id']])
        ->assertJson([
            'data' => [
                'players' => [
                    'data' => [
                        ['id' => $player->id]
                    ],
                ],
            ],
        ]);
    }

    public function test_query_player()
    {
        $player = Player::factory()->create();

        $this->withHeaders([])->query('player', ['id' => $player->id], ['id'])
        ->assertJson([
            'data' => [
                'player' => [
                    'id' => $player->id,
                ],
            ],
        ]);
    }

    public function test_query_player_if_object_not_found()
    {
        $this->withHeaders([])->query('player', ['id' => 0], ['id'])
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_query_players_if_filter_not_found()
    {
        $player = Player::factory()->create();

        $this->withHeaders([])->query('players', ['query' => "00000"], ['total'])
        ->assertJson([
            'data' => [
                'players' => [
                    'total' => 0,
                ],
            ],
        ]);
    }


    public function test_query_players_with_filter()
    {
        $player = Player::factory()->create();

        $this->withHeaders([])->query('players', ['query' => "$player->id"], ['total'])
        ->assertJson([
            'data' => [
                'players' => [
                    'total' => 1,
                ],
            ],
        ]);
    }

    public function test_create_with_failed_validation()
    {
        $this->withHeaders([])->mutation(
            'createPlayer',
            [
                'email' => 'teste',
                'name' => 'teste',
                'nick' => 'teste'
            ],
            ['id']
        )
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_create()
    {
        $player = Player::factory()->make();
        $this->withHeaders([])->mutation(
            'createPlayer',
            [
                'email' => $player->email,
                'name' => $player->name,
                'nick' => $player->nick
            ],
            ['nick']
        )
        ->assertJsonFragment(
            ['nick' => $player->nick]
        );
    }

    public function test_update_if_object_not_found()
    {
        $this->withHeaders([])->mutation(
            'updatePlayer',
            [
                'id' => 0
            ],
            ['id']
        )
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_update_with_failed_validation()
    {
        $player = Player::factory()->create();
        $this->withHeaders([])->mutation(
            'updatePlayer',
            [
                'id' => $player->id,
                'nick' => null
            ],
            ['id']
        )
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_update()
    {
        $player = player::factory()->create();
        $this->withHeaders([])->mutation(
            'updatePlayer',
            [
                'id' => $player->id,
                'nick' => 'teste'
            ],
            ['nick']
        )
        ->assertJsonFragment(
            ['nick' => 'teste']
        );
    }

    public function test_destroy_if_object_not_found()
    {
        $this->withHeaders([])->mutation(
            'deletePlayer',
            [
                'id' => 0
            ],
            []
        )
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_destroy()
    {
        $player = Player::factory()->create();
        $this->withHeaders([])->mutation(
            'deletePlayer',
            [
                'id' => $player->id
            ],
            []
        )
        ->assertJsonFragment(
            ['deletePlayer' => true]
        );
    }
}

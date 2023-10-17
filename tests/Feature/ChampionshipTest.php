<?php

namespace Tests\Feature;

use App\Models\Championship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChampionshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_query_championships()
    {
        $championship = Championship::factory()->create();

        $this->withHeaders([])->query('championships', ['data' => ['id']])
        ->assertJson([
            'data' => [
                'championships' => [
                    'data' => [
                        ['id' => $championship->id]
                    ],
                ],
            ],
        ]);
    }

    public function test_query_championship()
    {
        $championship = Championship::factory()->create();

        $this->withHeaders([])->query('championship', ['id' => $championship->id], ['id'])
        ->assertJson([
            'data' => [
                'championship' => [
                    'id' => $championship->id,
                ],
            ],
        ]);
    }

    public function test_query_championship_if_object_not_found()
    {
        $this->withHeaders([])->query('championship', ['id' => 0], ['id'])
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_query_championships_if_filter_not_found()
    {
        $championship = Championship::factory()->create();

        $this->withHeaders([])->query('championships', ['query' => "00000"], ['total'])
        ->assertJson([
            'data' => [
                'championships' => [
                    'total' => 0,
                ],
            ],
        ]);
    }


    public function test_query_championships_with_filter()
    {
        $championship = Championship::factory()->create();

        $this->withHeaders([])->query('championships', ['query' => "$championship->id"], ['total'])
        ->assertJson([
            'data' => [
                'championships' => [
                    'total' => 1,
                ],
            ],
        ]);
    }

    public function test_create_with_failed_validation()
    {
        $this->withHeaders([])->mutation(
            'createChampionship',
            [
                'name' => "teste",
                'date' => "2023",
                'game_id' => 25,
                'total_teams' => 10,
            ],
            ['name']
        )
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_create()
    {
        $championship = Championship::factory()->make();
        $this->withHeaders([])->mutation(
            'createChampionship',
            [
                'name' => $championship->name,
                'date' => "2023-10-17",
                'game_id' => $championship->game_id,
                'total_players_team' => $championship->total_players_team,
                'total_teams' => $championship->total_teams,
            ],
            ['name']
        )
        ->assertJsonFragment(
            ['name' => $championship->name]
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
        $championship = Championship::factory()->create();
        $this->withHeaders([])->mutation(
            'updateChampionship',
            [
                'id' => $championship->id,
                'name' => null
            ],
            ['id']
        )
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_update()
    {
        $championship = Championship::factory()->create();
        $this->withHeaders([])->mutation(
            'updateChampionship',
            [
                'id' => $championship->id,
                'name' => 'teste'
            ],
            ['name']
        )
        ->assertJsonFragment(
            ['name' => 'teste']
        );
    }

    public function test_destroy_if_object_not_found()
    {
        $this->withHeaders([])->mutation(
            'deleteChampionship',
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
        $championship = Championship::factory()->create();
        $this->withHeaders([])->mutation(
            'deleteChampionship',
            [
                'id' => $championship->id
            ],
            []
        )
        ->assertJsonFragment(
            ['deleteChampionship' => true]
        );
    }
}

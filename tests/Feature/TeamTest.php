<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_query_teams()
    {
        $player = Team::factory()->create();

        $this->withHeaders([])->query('teams', ['data' => ['id']])
        ->assertJson([
            'data' => [
                'teams' => [
                    'data' => [
                        ['id' => $player->id]
                    ],
                ],
            ],
        ]);
    }

    public function test_query_team()
    {
        $team = Team::factory()->create();

        $this->withHeaders([])->query('team', ['id' => $team->id], ['id'])
        ->assertJson([
            'data' => [
                'team' => [
                    'id' => $team->id,
                ],
            ],
        ]);
    }

    public function test_query_team_if_object_not_found()
    {
        $this->withHeaders([])->query('team', ['id' => 0], ['id'])
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_query_teams_if_filter_not_found()
    {
        $team = Team::factory()->create();

        $this->withHeaders([])->query('teams', ['query' => "00000"], ['total'])
        ->assertJson([
            'data' => [
                'teams' => [
                    'total' => 0,
                ],
            ],
        ]);
    }


    public function test_query_teams_with_filter()
    {
        $team = Team::factory()->create();

        $this->withHeaders([])->query('teams', ['query' => "$team->id"], ['total'])
        ->assertJson([
            'data' => [
                'teams' => [
                    'total' => 1,
                ],
            ],
        ]);
    }

    public function test_create_with_failed_validation()
    {
        $this->withHeaders([])->mutation(
            'createTeam',
            [
                'name' => 'teste',
                'championship_id' => 0,
            ],
            ['id']
        )
        ->assertJsonFragment(
            ['message' => 'validation']
        );
    }

    public function test_create()
    {
        $team = Team::factory()->make();
        $this->withHeaders([])->mutation(
            'createTeam',
            [
                'name' => $team->name,
                'championship_id' => $team->championship_id
            ],
            ['name']
        )
        ->assertJsonFragment(
            ['name' => $team->name]
        );
    }

    public function test_update_if_object_not_found()
    {
        $this->withHeaders([])->mutation(
            'updateTeam',
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
        $team = Team::factory()->create();
        $this->withHeaders([])->mutation(
            'updateTeam',
            [
                'id' => $team->id,
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
        $team = Team::factory()->create();
        $this->withHeaders([])->mutation(
            'updateTeam',
            [
                'id' => $team->id,
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
            'deleteTeam',
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
        $team = Team::factory()->create();
        $this->withHeaders([])->mutation(
            'deleteTeam',
            [
                'id' => $team->id
            ],
            []
        )
        ->assertJsonFragment(
            ['deleteTeam' => true]
        );
    }
}

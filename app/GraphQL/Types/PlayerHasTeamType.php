<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PlayerHasTeamType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PlayerHasTeam',
        'description' => 'Jogador tem time',
        'model' => PlayerHasTeam::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do relacionamento',
                'rules' => ['required', 'integer', 'exists:players_has_team,id']
            ],
            'player_id' => [
                'type' => Type::nonNull(GraphQL::type('Player')),
                'description' => 'Relacionamento com o jogador',
                'rules' => ['required', 'integer', 'exists:players,id'],
                'resolve' => function ($playerHasTeam) {
                    return $playerHasTeam->player;
                },
            ],
            'team_id' => [
                'type' => Type::nonNull(GraphQL::type('Team')),
                'description' => 'Relacionamento com o time',
                'rules' => ['required', 'integer', 'exists:teams,id'],
                'resolve' => function ($playerHasTeam) {
                    return $playerHasTeam->team;
                },
            ],
        ];
    }
}

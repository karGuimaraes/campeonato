<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Championship;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;


class ChampionshipType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Championship',
        'description' => 'Campenatos',
        'model' => Championship::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do campeonato',
                'rules' => ['required', 'integer', 'exists:championships,id']
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nome do campeonato',
                'rules' => ['required', 'string', 'max:50']
            ],
            'date' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Data do campeonato',
                'rules' => ['required', 'date_format:Y-m-d']
            ],
            'game_id' => [
                'type' => Type::nonNull(GraphQL::type('Game')),
                'description' => 'Identificador do jogo',
                'resolve' => function ($championship) {
                    return $championship->game;
                },
            ],
            'total_players_team' => [
                'type' => Type::int(),
                'description' => 'Total de jogadores por time',
                'rules' => ['somentime', 'integer', 'min:1', 'max:10']
            ],
            'total_teams' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Total de times',
                'rules' => ['required', 'integer', 'min:1', 'max:30']
            ],
        ];
    }
}

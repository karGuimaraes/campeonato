<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Championship;

use App\GraphQL\Types\ChampionshipType;
use App\Models\Championship;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateChampionshipMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createChampionship',
        'description' => 'Cria um novo campeonato'
    ];

    public function type(): Type
    {
        return GraphQL::Type('Championship');
    }

    public function args(): array
    {
        $args = [
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
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do jogo',
                'rules' => ['required', 'integer', 'exists:games,id'],
                'defaultValue' => '1'
            ],
            'total_players_team' => [
                'type' => Type::int(),
                'description' => 'Total de jogadores por time',
                'rules' => ['nullable', 'integer', 'min:1', 'max:10'],
                'defaultValue' => '5'
            ],
            'total_teams' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Total de times',
                'rules' => ['required', 'integer', 'min:1', 'max:30'],
                'defaultValue' => '10'
            ]
        ];

        return $args;
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Championship::create($args);
    }
}

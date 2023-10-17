<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Championship;

use App\Models\Championship;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class UpdateChampionshipMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateChampionship',
        'description' => 'Editar um campeonato'
    ];

    public function type(): Type
    {
        return GraphQL::Type('Championship');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required', 'integer', 'exists:championships,id']
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                'rules' => ['string', 'max:50']
            ],
            'date' => [
                'name' => 'date',
                'type' => Type::string(),
                'rules' => ['date_format:Y-m-d']
            ],
            'game_id' => [
                'name' => 'game_id',
                'type' => Type::int(),
                'rules' => ['integer', 'exists:games,id']
            ],
            'total_players_team' => [
                'name' => 'total_players_team',
                'type' => Type::int(),
                'rules' => ['somentime', 'integer', 'min:1', 'max:10']
            ],
            'total_teams' => [
                'name' => 'total_teams',
                'type' => Type::int(),
                'rules' => ['integer', 'min:1', 'max:30']
            ],
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'id.exists' => 'Campeonato não encontrada',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $championship = Championship::findOrFail($args['id']);
        $championship->update($args);

        return $championship;
    }
}

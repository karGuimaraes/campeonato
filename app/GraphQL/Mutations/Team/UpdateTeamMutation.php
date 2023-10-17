<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Team;

use App\Models\Team;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class UpdateTeamMutation extends Mutation
{
    protected $attributes = [
        'name' => 'team/UpdateTeam',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Team');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required', 'exists:teams,id,deleted_at,NULL']
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nome do time',
                'rules' => ['string', 'max:50']
            ],
            'championship_id' => [
                'type' => Type::int(),
                'description' => 'Identificador do campeonato',
                'rules' => ['integer', 'exists:championships,id']
            ]
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'id.exists' => 'Time não encontrada',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $team = Team::findOrFail($args['id']);
        $team->update($args);

        return $team;
    }
}

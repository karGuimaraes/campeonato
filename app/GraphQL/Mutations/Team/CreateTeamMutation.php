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

class CreateTeamMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createTeam',
        'description' => 'Criar um time'
    ];

    public function type(): Type
    {
        return GraphQL::Type('Team');
    }

    public function args(): array
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nome do time',
                'rules' => ['required', 'string', 'max:50']
            ],
            'championship_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do campeonato',
                'rules' => ['required', 'integer', 'exists:championships,id']
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Team::create($args);
    }
}

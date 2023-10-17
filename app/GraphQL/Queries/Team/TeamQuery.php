<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Team;

use App\Models\Team;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class TeamQuery extends Query
{
    protected $attributes = [
        'name' => 'team',
        'description' => 'Lista de um time'
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
            ]
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'id.exists' => 'Time não encontrado.',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $team = Team::findOrFail($args['id']);
        return $team;
    }
}

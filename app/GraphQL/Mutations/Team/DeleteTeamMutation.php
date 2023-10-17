<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Team;

use App\Models\Team;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DeleteTeamMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteTeam',
        'description' => 'Excluir um time'
    ];

    public function type(): Type
    {
        return Type::boolean();
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
            'id.exists' => 'Time não encontrada',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $team = Team::find($args['id']);
        $team->delete();

        return true;
    }
}

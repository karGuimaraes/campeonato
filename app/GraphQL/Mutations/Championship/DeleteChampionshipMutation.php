<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Championship;

use App\Models\Championship;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DeleteChampionshipMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteChampionship',
        'description' => 'Excluir um campenato'
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
                'rules' => ['required', 'exists:championships,id,deleted_at,NULL']
            ]
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
        $championship = Championship::find($args['id']);
        $championship->delete();

        return true;
    }
}

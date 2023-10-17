<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Championship;

use App\Models\Championship;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class ChampionshipQuery extends Query
{
    protected $attributes = [
        'name' => 'championship',
        'description' => 'Listagem de um campeonato'
    ];

    public function type(): Type
    {
        return GraphQL::type('Championship');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' =>
                [
                    'required',
                    'exists:championships,id,deleted_at,NULL'
                ]
            ],
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'id.exists' => 'Campeonato não encontrado.',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $championship = Championship::findOrFail($args['id']);

        return $championship;
    }
}

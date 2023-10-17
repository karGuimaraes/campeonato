<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Team;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as FacadesGraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TeamType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Team',
        'description' => 'Times',
        'model' => Team::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do time',
                'rules' => ['required', 'integer', 'exists:teams,id']
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nome do time',
                'rules' => ['required', 'string', 'max:50']
            ],
            'championship_id' => [
                'type' => Type::nonNull(FacadesGraphQL::type('Championship')),
                'description' => 'Relacionamento com o campeonato',
                'rules' => ['required', 'integer', 'exists:championships,id'],
                'resolve' => function ($team) {
                    return $team->championship;
                },
            ],
        ];
    }
}

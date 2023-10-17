<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Player;

use App\Models\Player;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class PlayerQuery extends Query
{
    protected $attributes = [
        'name' => 'player',
        'description' => 'Listagem de um jogador'
    ];

    public function type(): Type
    {
        return GraphQL::type('Player');
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
                    'exists:players,id,deleted_at,NULL'
                ]
            ],
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'id.exists' => 'Jogador não encontrado.',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $player = Player::findOrFail($args['id']);
        return $player;
    }
}

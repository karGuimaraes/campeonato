<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Player;

use App\Models\Player;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DeletePlayerMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deletePlayer',
        'description' => 'Excluir um jogador'
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
                'rules' => ['required', 'exists:players,id,deleted_at,NULL']
            ]
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'id.exists' => 'Jogador não encontrada',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $player = Player::find($args['id']);
        $player->delete();

        return true;
    }
}

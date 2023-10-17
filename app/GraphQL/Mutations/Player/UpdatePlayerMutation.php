<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Player;

use App\Models\Player;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class UpdatePlayerMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updatePlayer',
        'description' => 'Editar um jogador'
    ];

    public function type(): Type
    {
        return GraphQL::type('Player');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do jogador',
                'rules' => ['required', 'integer', 'exists:players,id,deleted_at,NULL']
            ],
            'nick' => [
                'type' => Type::string(),
                'description' => 'Apelido do jogador',
                'rules' => ['string', 'max:20', 'unique:players,nick']
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Nome do jogador',
                'rules' => ['string', 'max:50']
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'E-mail do jogador',
                'rules' => ['string', 'max:50', 'email', 'unique:players,email']
            ],
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
        $player = Player::findOrFail($args['id']);
        $player->update($args);

        return $player;
    }
}

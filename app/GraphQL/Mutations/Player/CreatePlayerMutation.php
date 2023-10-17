<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Player;

use App\GraphQL\Types\PlayerType;
use App\Models\Player;
use Closure;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreatePlayerMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createPlayer',
        'description' => 'Cria um novo jogador'
    ];

    public function type(): Type
    {
        return GraphQL::type('Player');
    }

    public function args(): array
    {
        $player_has_team = new InputObjectType([
            'name' => 'playerHasTeamInput',
            'fields' => [
                'team_id' => [
                    'type' => Type::int(),
                    'description' => 'Identificador do time',
                    'rules' => ['integer', 'exists:teams,id']
                ],
            ],
        ]);
        $args = [
            'nick' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Apelido do jogador',
                'rules' => ['required', 'string', 'max:20', 'unique:players,nick']
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nome do jogador',
                'rules' => ['required', 'string', 'max:50']
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'E-mail do jogador',
                'rules' => ['required', 'string', 'max:50', 'email', 'unique:players,email']
            ],
            'player_has_team' => [
                'type' => $player_has_team,
                'description' => 'Time do jogador',
                'rules' => ['array']
            ],
        ];

        return $args;
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Player::create($args);
    }
}

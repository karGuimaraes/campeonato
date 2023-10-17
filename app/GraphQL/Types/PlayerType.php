<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Player;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PlayerType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Player',
        'description' => 'Jogadores',
        'model' => Player::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do jogador',
                'rules' => ['required', 'integer', 'exists:players,id']
            ],
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
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Game;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class GameType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Game',
        'description' => 'Jogos',
        'model' => Game::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identificador do jogo',
                'rules' => ['required', 'integer', 'exists:games,id']
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nome do jogo',
                'rules' => ['required', 'string', 'max:50', 'unique:games,name']
            ],
            'type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Tipo do jogo',
                'rules' => ['required', 'string', 'max:50']
            ],
        ];
    }
}

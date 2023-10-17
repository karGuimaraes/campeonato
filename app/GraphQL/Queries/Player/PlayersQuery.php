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

class PlayersQuery extends Query
{
    protected $attributes = [
        'name' => 'players',
        'description' => 'Listagem de jogadores'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Player');
    }

    public function args(): array
    {
        return [
            'page' => [
                'type' => Type::int(),
                'defaultValue' => 1
            ],
            'limit' => [
                'type' => Type::int(),
                'defaultValue' => 10
            ],
            'query' => [
                'name' => 'query',
                'description' => 'Pesquisar em todas as colunas do modelo',
                'type' => Type::string(),
                'defaultValue' => '',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $with = $fields->getRelations();

        $query = Player::with($with);

        // Verifique se o argumento 'query' está presente e aplique a pesquisa genérica
        if (!empty($args['query'])) {
            $searchTerm = $args['query'];

            $query->where(function ($q) use ($searchTerm) {
                $fillableColumns = array_keys(Player::first()->getAttributes());

                foreach ($fillableColumns as $column) {
                    $q->orWhere($column, 'like', "%$searchTerm%");
                }
            });
        }

        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}

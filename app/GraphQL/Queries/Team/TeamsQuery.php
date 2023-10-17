<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Team;

use App\Models\Team;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class TeamsQuery extends Query
{
    protected $attributes = [
        'name' => 'teams',
        'description' => 'Listagem de times'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Team');
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

        $query = Team::with($with);

        // Verifique se o argumento 'query' está presente e aplique a pesquisa genérica
        if (!empty($args['query'])) {
            $searchTerm = $args['query'];

            $query->where(function ($q) use ($searchTerm) {
                $fillableColumns = array_keys(Team::first()->getAttributes());

                foreach ($fillableColumns as $column) {
                    $q->orWhere($column, 'like', "%$searchTerm%");
                }
            });
        }

        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}

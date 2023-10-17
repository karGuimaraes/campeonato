<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Championship extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'championships';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        'name',
        'date',
        'game_id',
        'total_players_team',
        'total_teams',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = [
        'game'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}

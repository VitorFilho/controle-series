<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];
    //protected $with = ['season'];

    public function temporadas()
    {
        return $this->hasMany(Season::class, 'series_id'); //Relacionamento 1 para muitos (um seriado tem var
    }

    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder){
            $queryBuilder->orderBy('nome');
        });
    }

    // public function scopeActive(Builder $query)
    // {
    //     return $query->where('active', true);
    // }
}

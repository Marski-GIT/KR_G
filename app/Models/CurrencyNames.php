<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurrencyNames extends Model
{
    use HasFactory;

    protected $table = 'currencies';
    protected $primaryKey = 'id';

    public function amounts(): HasMany
    {
        return $this->hasMany(CurrencyAmount::class, 'currency_id', 'id');
    }

}

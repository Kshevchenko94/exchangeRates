<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Selection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'selection_date',
        'exchange_rates_id',
    ];

    protected $with = ['exchangeRates', 'description'];


    /**
     * @return BelongsTo
     */
    public function exchangeRates(): BelongsTo
    {
        return $this->belongsTo(ExchangeRates::class);
    }

    /**
     * @return BelongsTo
     */
    public function description(): BelongsTo
    {
        return $this->belongsTo(Description::class);
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}

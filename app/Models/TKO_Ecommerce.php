<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TKO_Ecommerce extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'tko_ecommerce';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'client_id',
        'channel_id',
        'channel_name',
        'dataset',
        'hash',
        'severity',
        'keyword',
        'url',
        'title',
        'lastUpdated',
        'price',
        'image',
        'seller',
        'brand',
        'type',
        'categories',
        'sid_1',
        'sid_2',
        'sid_3',
        'sid_4',
        'sid_5',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TKO_SearchEngine extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'tko_searchengine';

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
        'title',
        'url',
        'result_type',
        'result_type_title',
        'result_type_url',
        'result_type_displayurl',
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

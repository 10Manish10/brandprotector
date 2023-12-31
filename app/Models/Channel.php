<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'channels';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'channel_name',
        'variables',
        'copyright',
        'infringement',
        'dmca',
        'created_at',
        'updated_at',
        'deleted_at',
        'variables',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function subscription_plans()
    {
        return $this->belongsToMany(Subscription::class);
    }

    public function channelsEmailTemplates()
    {
        return $this->belongsToMany(EmailTemplate::class);
    }
}

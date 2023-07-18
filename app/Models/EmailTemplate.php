<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EmailTemplate extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'email_templates';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const PRIORITY_RADIO = [
        'low'      => 'Low',
        'moderate' => 'Moderate',
        'high'     => 'High',
        'direct'   => 'Direct',
    ];

    protected $fillable = [
        'subject',
        'email_body',
        'priority',
        'from_email',
        'to_email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}

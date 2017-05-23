<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public $primaryKey = 'id';

    protected $table = 'songs';

    protected $fillable = [
        'url',
        'songname',
        'artistid',
        'artistname',
        'albumid',
        'albumname'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function getCreatedAtAttribute($date, $fromFormat = 'Y-m-d H:i:s', $toFormat = \DateTime::ATOM)
    {
        return date_format(date_create_from_format($fromFormat, $date), $toFormat);
    }

    public function getUpdatedAtAttribute($date, $fromFormat = 'Y-m-d H:i:s', $toFormat = \DateTime::ATOM)
    {
        return date_format(date_create_from_format($fromFormat, $date), $toFormat);
    }
}

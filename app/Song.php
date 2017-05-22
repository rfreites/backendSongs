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
}

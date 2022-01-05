<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipientAnnouncement extends Model
{
    protected $fillable = [
        'announcement_id',
        'recipient_id',
    ];

    public function Announcement()
    {
        return $this->belongsTo('App\Announcement', 'id', 'announcement_id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'id', 'recipient_id');
    }
}

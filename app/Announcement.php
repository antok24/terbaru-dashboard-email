<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'subject',
        'content',
        'file',
        'sender_id',
        'recipient_role',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'sender_id');
    }

    public function RecipientAnnouncement()
    {
        return $this->hasMany('App\RecipientAnnouncement', 'announcement_id', 'id');
    }
}

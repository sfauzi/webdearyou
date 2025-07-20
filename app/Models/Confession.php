<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confession extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'recipient_name',
        'message',
        'sender_name',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_1_id', 'id');
    }

    public function participant1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_2_id', 'id');
    }

    public function participant2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_3_id', 'id');
    }

    public function participant3(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_4_id', 'id');
    }
}

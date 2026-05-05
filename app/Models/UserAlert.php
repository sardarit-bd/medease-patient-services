<?php

namespace App\Modules\Dashboard\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAlert extends Model
{
    use HasUuids;

    protected $table = 'user_alerts';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'priority',
        'is_read',
        'action_url',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

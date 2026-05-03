<?php

namespace App\Modules\Dashboard\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardWidget extends Model
{
    use HasUuids;

    protected $table = 'dashboard_widgets';

    protected $fillable = [
        'user_id',
        'widget_type',
        'is_active',
        'position',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'position'  => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'color',
        'link',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function createOrderNotification(int $userId, string $title, string $message, ?string $link = null, ?string $icon = null, ?string $color = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'order',
            'title' => $title,
            'message' => $message,
            'icon' => $icon ?? 'fa-shopping-bag',
            'color' => $color ?? 'blue',
            'link' => $link,
        ]);
    }

    // Alias for backward compatibility
    public static function createBookingNotification(int $userId, string $title, string $message, ?string $link = null, ?string $icon = null, ?string $color = null)
    {
        return self::createOrderNotification($userId, $title, $message, $link, $icon, $color);
    }

    public static function createProductNotification(int $userId, string $title, string $message, ?string $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'product',
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-box',
            'color' => 'purple',
            'link' => $link,
        ]);
    }

    // Alias for backward compatibility
    public static function createServiceNotification(int $userId, string $title, string $message, ?string $link = null)
    {
        return self::createProductNotification($userId, $title, $message, $link);
    }

    public static function createSystemNotification(int $userId, string $title, string $message, ?string $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-bell',
            'color' => 'blue',
            'link' => $link,
        ]);
    }

    public static function createMessageNotification(int $userId, string $title, string $message, ?string $link = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => 'message',
            'title' => $title,
            'message' => $message,
            'icon' => 'fa-envelope',
            'color' => 'pink',
            'link' => $link,
        ]);
    }
}

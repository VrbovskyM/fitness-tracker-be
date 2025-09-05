<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'level',
        'timestamp',
        'stack',
        'source',
        'user_id',
        'url',
        'user_agent',
        'session_id',
        'additional_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'timestamp' => 'datetime',
        'additional_data' => 'array',
    ];

    /**
     * Log levels enum
     */
    const LEVEL_DEBUG = 'debug';
    const LEVEL_INFO = 'info';
    const LEVEL_WARN = 'warn';
    const LEVEL_ERROR = 'error';

    /**
     * Get all available log levels
     *
     * @return array<string>
     */
    public static function getLogLevels(): array
    {
        return [
            self::LEVEL_DEBUG,
            self::LEVEL_INFO,
            self::LEVEL_WARN,
            self::LEVEL_ERROR,
        ];
    }

    /**
     * Scope a query to only include logs of a given level.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $level
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope a query to only include logs for a given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include logs from a date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $from
     * @param  string  $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateRange($query, string $from, string $to)
    {
        return $query->whereBetween('timestamp', [$from, $to]);
    }

    /**
     * Get the user that owns the log entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

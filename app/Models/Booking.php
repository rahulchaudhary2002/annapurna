<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'booking_number',
        'bookable_type',
        'bookable_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guests',
        'check_in',
        'check_out',
        'rooms',
        'travel_date',
        'special_requests',
        'status',
        'total_price',
        'admin_notes',
        'ip_address',
    ];

    protected $casts = [
        'check_in'     => 'date',
        'check_out'    => 'date',
        'travel_date'  => 'date',
        'total_price'  => 'decimal:2',
        'guests'       => 'integer',
        'rooms'        => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = static::generateNumber();
            }
        });
    }

    private static function generateNumber(): string
    {
        do {
            $number = 'BK-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        } while (static::where('booking_number', $number)->exists());

        return $number;
    }

    // ── Relationships ──────────────────────────────────────

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    // ── Helpers ───────────────────────────────────────────

    public function isHotelBooking(): bool
    {
        return $this->bookable_type === Business::class;
    }

    public function isPackageBooking(): bool
    {
        return $this->bookable_type === Package::class;
    }

    public function getTypeLabel(): string
    {
        return $this->isHotelBooking() ? 'Hotel' : 'Package';
    }

    public function getBookableName(): string
    {
        return $this->bookable?->name ?? '—';
    }

    public function getNights(): ?int
    {
        if ($this->check_in && $this->check_out) {
            return $this->check_in->diffInDays($this->check_out);
        }
        return null;
    }

    public static function statusColor(string $status): string
    {
        return match ($status) {
            'pending'   => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
            default     => 'gray',
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'zipcode',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        $parts = [$this->address, $this->number];
        if ($this->complement) {
            $parts[] = $this->complement;
        }
        $parts[] = $this->neighborhood;
        $parts[] = "{$this->city}/{$this->state}";
        $parts[] = $this->zipcode;

        return implode(', ', $parts);
    }
}

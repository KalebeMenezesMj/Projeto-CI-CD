<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'status',
        'subtotal',
        'shipping',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'notes',
        'shipping_name',
        'shipping_phone',
        'shipping_zipcode',
        'shipping_address',
        'shipping_number',
        'shipping_complement',
        'shipping_neighborhood',
        'shipping_city',
        'shipping_state',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_CREDIT_CARD = 'credit_card';
    const PAYMENT_PIX = 'pix';
    const PAYMENT_BOLETO = 'boleto';

    public static function statusLabels()
    {
        return [
            self::STATUS_PENDING => 'Pendente',
            self::STATUS_PROCESSING => 'Em processamento',
            self::STATUS_SHIPPED => 'Enviado',
            self::STATUS_DELIVERED => 'Entregue',
            self::STATUS_CANCELLED => 'Cancelado',
        ];
    }

    public static function paymentLabels()
    {
        return [
            self::PAYMENT_CREDIT_CARD => 'Cartão de Crédito',
            self::PAYMENT_PIX => 'PIX',
            self::PAYMENT_BOLETO => 'Boleto Bancário',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function getPaymentLabelAttribute()
    {
        return self::paymentLabels()[$this->payment_method] ?? $this->payment_method;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_SHIPPED => 'primary',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_CANCELLED => 'danger',
            default => 'secondary',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateCode()
    {
        return 'FL' . strtoupper(substr(uniqid(), -8));
    }
}

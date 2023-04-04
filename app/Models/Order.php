<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $primaryKey = 'order_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['date_transform','status','bg_status', 'payment_gross', 'payment_net'];

    protected function paymentGross(): Attribute
    {
        $gross_price = 0;
        $payment = Payment::where('order_id',$this->order_id)->first();
        if ($payment != null) {
            $gross_price = $payment->gross_price;
        }
        
        return Attribute::make(
            get: fn () => $gross_price,
        );
    }

    protected function paymentNet(): Attribute
    {
        $net_price = 0;
        $payment = Payment::where('order_id',$this->order_id)->first();
        if ($payment != null) {
            $net_price = $payment->net_price;
        }
        
        return Attribute::make(
            get: fn () => $net_price,
        );
    }

    protected function dateTransform(): Attribute
    {
        Carbon::setlocale(config('app.locale'));
        $date = Carbon::parse($this->deadline);

        return Attribute::make(
            get: fn () => $date->translatedFormat('l jS \o\f F Y'),
        );
    }

    protected function status(): Attribute
    {
        $status = null;

        if ($this->order_status == 'PENDANT') {
            $status = 'PENDIENTE';
        }

        if ($this->order_status == 'CANCEL') {
            $status = 'CANCELADA';
        }

        if ($this->order_status == 'APPROVED') {
            $status = 'APROBADA';
        }

        if ($this->order_status == 'REVIEWING') {
            $status = 'REVISION';
        }

        return Attribute::make(
            get: fn () => $status,
        );
    }

    protected function bgStatus(): Attribute
    {
        $status = null;

        if ($this->order_status == 'PENDANT') {
            $status = 'bg-light-warning';
        }

        if ($this->order_status == 'CANCEL') {
            $status = 'bg-light-danger';
        }

        if ($this->order_status == 'APPROVED') {
            $status = 'bg-light-success';
        }

        if ($this->order_status == 'REVIEWING') {
            $status = 'bg-light-warning';
        }

        return Attribute::make(
            get: fn () => $status,
        );
    }

}

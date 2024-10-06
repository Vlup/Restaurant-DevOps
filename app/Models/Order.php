<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'order_details', 'order_id', 'menu_id')->withTimestamps()->withPivot(['qty'])->as('detail');
    }
}

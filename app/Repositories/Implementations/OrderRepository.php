<?php

namespace App\Repositories\Implementations;

use App\Models\Order;
use App\Repositories\IOrderRepository;


class OrderRepository extends Repository implements IOrderRepository
{
    public function __construct(Order $order)
    {
        $this->setModel($order);
    }

}

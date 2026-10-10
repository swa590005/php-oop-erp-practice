<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Shipped = 'shipped';
    case Cancelled= 'cancelled';
}
<?php

function describeOrder(int $id, string $status, ?string $note = null):string{
    $status =match($status){
        'pending' => 'Order is pending',
        'shipped' => 'Order is shipped',
        'cancelled' => 'Order is cancelled',
        default => 'Order is not found'
    };
    $note ??= 'No note';
    return "$id $status $note";
}
//echo describeOrder(id: 101, status: 'shipped');

class Address {
    public function __construct(public string $city) {}
}

class User {
    public function __construct(public ?Address $address = null) {}
}

function getCity(?User $user):string{
    return $user?->address?->city ?? 'Unknown';
}

$netPrices = [10.0, 25.5, 99.99];
$netPrices = array_map(fn($price) => round( $price * 1.19,2), $netPrices);
//var_dump($netPrices);

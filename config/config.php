<?php

declare(strict_types=1);

return [

    /**
     * Set the namespace of the Events.
     */
    'namespace' => [
        'event' => 'App\Events',
    ],

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Addresses Database Tables
    'tables' => [
        'addresses' => 'addresses',
    ],

    // Addresses Models
    'models' => [
        'address' => \Rinvex\Addresses\Models\Address::class,
    ],

    // Addresses Geocoding Options
    'geocoding' => false,

];

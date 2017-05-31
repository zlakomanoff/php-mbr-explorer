<?php

return [
    'loaderCode' => [
        'address' => 0x0000,
        'length' => 446,
    ],
    'partition1' => [
        'address' => 0x01BE,
        'length' => 16,
    ],
    'partition2' => [
        'address' => 0x01CE,
        'length' => 16,
    ],
    'partition3' => [
        'address' => 0x01DE,
        'length' => 16,
    ],
    'partition4' => [
        'address' => 0x01EE,
        'length' => 16,
    ],
    'signature' => [
        'address' => 0x01FE,
        'length' => 2,
        'mystBe' => 0x55AA,
        'afterParse' => function ($o) {
            $o->signature = hexdec(bin2hex($o->signature));
        }
    ]
];

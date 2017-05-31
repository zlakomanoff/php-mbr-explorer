<?php

/*
    00h 	1 	Признак активности раздела
    01h 	1 	Начало раздела — головка
    02h 	1 	Начало раздела — сектор (биты 0—5), цилиндр (биты 6, 7)
    03h 	1 	Начало раздела — цилиндр (старшие биты 8, 9 хранятся в байте номера сектора)
    04h 	1 	Код типа раздела
    05h 	1 	Конец раздела — головка
    06h 	1 	Конец раздела — сектор (биты 0—5), цилиндр (биты 6, 7)
    07h 	1 	Конец раздела — цилиндр (старшие биты 8, 9 хранятся в байте номера сектора)
    08h 	4 	Смещение первого сектора
    0Ch 	4 	Количество секторов раздела
*/

return [
    'activity' => [
        'address' => 0x00,
        'length' => 1,
        'afterParse' => function ($o) {
            $activities = include 'partitionActivities.php';
            $o->activity = $activities[hexdec(bin2hex($o->activity))];
        }
    ],
    'partitionStartHead' => [
        'address' => 0x01,
        'length' => 1,
        'afterParse' => function ($o) {
            $o->partitionStartHead = hexdec(bin2hex($o->partitionStartHead));
        }
    ],
    'partitionStartSector' => [
        'address' => 0x02,
        'length' => 1,
        'afterParse' => function ($o) {
            $o->partitionStartSector = hexdec(bin2hex($o->partitionStartSector));
        }
    ],
    'partitionStartCylinder' => [
        'address' => 0x03,
        'length' => 1,
        'afterParse' => function ($o) {
            $o->partitionStartCylinder = hexdec(bin2hex($o->partitionStartCylinder));
        }
    ],
    'partitionTypeCode' => [
        'address' => 0x04,
        'length' => 1,
        'afterParse' => function ($o) {
            $types = include 'partitionTypes.php';
            $o->partitionType = $types[hexdec(bin2hex($o->partitionTypeCode))];
            unset($o->partitionTypeCode);
        }
    ],
    'partitionEndHead' => [
        'address' => 0x05,
        'length' => 1,
        'afterParse' => function ($o) {
            $o->partitionEndHead = hexdec(bin2hex($o->partitionEndHead));
        }
    ],
    'partitionEndSector' => [
        'address' => 0x06,
        'length' => 1,
        'afterParse' => function ($o) {
            $o->partitionEndSector = hexdec(bin2hex($o->partitionEndSector));
        }
    ],
    'partitionEndCylinder' => [
        'address' => 0x07,
        'length' => 1,
        'afterParse' => function ($o) {
            $o->partitionEndCylinder = hexdec(bin2hex($o->partitionEndCylinder));
        }
    ],
    'firstSectorBias' => [
        'address' => 0x08,
        'length' => 4,
        'afterParse' => function ($o) {
            $o->firstSectorBias = unpack('L', $o->firstSectorBias)[1];
        }
    ],
    'sectorsCount' => [
        'address' => 0x0C,
        'length' => 4,
        'afterParse' => function ($o) {
            $o->sectorsCount = unpack('L', $o->sectorsCount)[1];
        }
    ],
];
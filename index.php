#!/bin/php
<?php
/**
 * its just small how to example
 */

require_once 'chunkFactory.php';

$fileHandler = fopen('mbr.bin', 'rb');
$chunkFactory = new chunkFactory($fileHandler);
$printablePartitions = [];

try {

    $baseTemplate = include('templates/base.php');
    $baseData = $chunkFactory->create($baseTemplate);

    $partitionTemplate = include('templates/partition.php');
    $partitions = [];

    foreach (range(1, 4) as $i) {
        $partitions[] = $chunkFactory->create($partitionTemplate, $baseTemplate['partition' . $i]['address']);
    }

    unset($i);

    foreach ($partitions as $partition) {
        $printablePartitions[] = [
            'activity' => $partition->activity,
            'type' => $partition->partitionType,
            'start' => $partition->firstSectorBias,
            'length' => $partition->sectorsCount
        ];
    }

    //file_put_contents('bootstrap_code.bin', $baseData->loaderCode);

} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
} finally {
    fclose($fileHandler);
    print_r($printablePartitions);
}

<?php

namespace Rts;

use League\Csv\Reader;
use League\Csv\Writer;

class GuidDb
{
    private $csvFile;

    private $processedGuids = [];

    /**
     * GuidDb constructor.
     * @param $csvFile
     */
    public function __construct($csvFile)
    {
        $this->csvFile = $csvFile;
    }

    public function load()
    {
        if (!file_exists($this->csvFile)) {
            touch($this->csvFile);
        } else {
            $ids = Reader::createFromPath($this->csvFile)->fetchAll(function ($i) {
                return $i[0];
            });
            $this->processedGuids = array_combine($ids, $ids);
        }
    }

    public function has($guid)
    {
        return isset($this->processedGuids[$guid]);
    }

    public function add($guid)
    {
        $this->processedGuids[$guid] = $guid;
    }

    public function save()
    {
        Writer::createFromPath($this->csvFile)->insertAll($this->processedGuids);
    }
}

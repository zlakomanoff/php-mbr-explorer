<?php

class chunkFactory
{
    private $fileHandler;

    public function __construct($fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    public function create(Array $template, $offset = 0x00)
    {
        $chunkObject = new stdClass();
        foreach ($template as $field => $data) {
            fseek($this->fileHandler, $offset + $data['address']);

            if (!empty($data['beforeParse']) and is_callable($data['beforeParse'])) {
                $data['beforeParse']($chunkObject);
            }
            $chunkObject->$field = fread($this->fileHandler, $data['length']);
            if (!empty($data['afterParse']) and is_callable($data['afterParse'])) {
                $data['afterParse']($chunkObject);
            }

            if (!empty($data['beforeValidate']) and is_callable($data['beforeValidate'])) {
                $data['beforeValidate']($chunkObject);
            }
            if (!empty($data['mystBe']) and $chunkObject->$field !== $data['mystBe']) {
                throw new Exception("Field \"${field}\" myst be \"${data['mystBe']}\"");
            }
            if (!empty($data['afterValidate']) and is_callable($data['afterValidate'])) {
                $data['afterValidate']($chunkObject);
            }

        }
        return $chunkObject;
    }

    public function batchCreate(Array $template, $offset = 0x00)
    {
        $columns = [];
        do {
            $currentOffset = $offset + (count($columns) * 32);
            $columns[] = $this->create($template, $currentOffset);
            $nextByte = fread($this->fileHandler, 1);
        } while ($nextByte !== chr(13));
        return $columns;
    }

}
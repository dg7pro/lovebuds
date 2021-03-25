<?php


namespace App;

/**
 * Queue class
 *
 * PHP version 7.0
 */
class Queue
{

    /**
     * Path to the saved files
     *
     * @var string
     */
    protected $path;

    /**
     * Class constructor
     *
     * @param string $path Path to the saved files
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Send an item to the queue
     *
     * @param mixed $content The content to be sent
     *
     * @return mixed  The number of bytes written to the queue, or false on failure
     */
    public function push($content)
    {
        $file = $this->path . uniqid('', true);
        $data = serialize($content);

        return file_put_contents($file, $data);
    }
}

<?php

class WhatsAppMessage
{
    protected $lines = [];
    protected $from;
    protected $to;

    public function __construct($lines = [])
    {
        $this->lines = $lines;

        return $this;
    }

    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    public function line($line = '')
    {
        $this->lines[] = $line;

        return $this;
    }

    public function send() {
        // TODO: Implement logic to send the message.
    }



}

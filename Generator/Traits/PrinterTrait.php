<?php

namespace Apiato\Core\Generator\Traits;

trait PrinterTrait
{

    public function printStartedMessage($packageName, $fileName)
    {
        $this->printInfoMessage('> Generating (' . $fileName . ') in (' . $packageName . ') Package.');
    }

    /**
     * @param $type
     *
     * @return void
     */
    public function printFinishedMessage($type)
    {
        $this->printInfoMessage($type . ' generated successfully.');
    }

    /**
     * @param $message
     */
    public function printErrorMessage($message)
    {
        $this->error($message);
    }

    /**
     * @param $message
     */
    public function printInfoMessage($message)
    {
        $this->info($message);
    }

}

<?php

namespace leruge\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Publish extends Command
{
    protected function configure()
    {
        $this->setName('auth:publish')->setDescription('Publish auth');
    }

    protected function execute(Input $input, Output $output)
    {
        $destination = $this->app->getRootPath() . '/database/migrations/';
        if(!is_dir($destination)){
            mkdir($destination, 0755, true);
        }
        $source = __DIR__.'/../database/migrations/';
        $handle = dir($source);

        while($entry=$handle->read()) {
            if(($entry!=".")&&($entry!="..")){
                if(is_file($source.$entry)){
                    copy($source.$entry, $destination.$entry);
                }
            }
        }

        $handle->close();

        $modelDestination = $this->app->getRootPath() . '/app/model/';
        if (!is_dir($modelDestination)) {
            mkdir($modelDestination, 0755, true);
        }
        $modelSource = __DIR__ . '/../' . 'model/';
        $modelHandle = dir($modelSource);

        while($modelEntry=$modelHandle->read()) {
            if(($modelEntry != ".") && ( $modelEntry != "..")){
                if(is_file($modelSource . $modelEntry)){
                    copy($modelSource . $modelEntry, $modelDestination . $modelEntry);
                }
            }
        }
        $modelHandle->close();
    }
}
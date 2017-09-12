<?php

/**
 * @file
 * Contains \AmazeeLabs\composer\ScriptHandler.
 */

namespace AmazeeLabs\composer;

use Composer\Script\Event;

class ScriptHandler {

  public static function init(Event $event) {
    static::configure($event);
  }

  public static function configure(Event $event) {
    $root = getcwd();
    $handle = fopen ("php://stdin","r");

    $event->getIO()->write('*****************************************
***** d8-starter-composer Config *****
*****************************************');

    $default = 'AmazeeLabs/awesome-new-project_com';
    $event->getIO()->write('What is the github project [' . $default . ']?');
    $project = trim(fgets($handle)) ?: $default;

    static::replaceInFile('AmazeeLabs/d8-starter-composer', $project, $root . '/composer.json');

    exec('git remote set-url origin ' . escapeshellarg('git@github.com:' . $project . '.git'));
  }

  public static function replaceInFile($needle, $haystack, $file) {
    $content = file_get_contents($file);
    $replaced = str_replace($needle, $haystack, $content);
    file_put_contents($file, $replaced);
  }

}
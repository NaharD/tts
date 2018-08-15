<?php

include_once 'Voice.php';

$voice = $_GET['voice'] ?: null;
$text = $_GET['text'] ?: null;
$name = $_GET['name'] ?: null;

$voice = (new Voice($text, $voice, $name))->createVoice()->streamVoice();

/*
 * Після кожного запиту видаляємо озвучений файл
 */
register_shutdown_function('unlink', $voice->getOutFileName());
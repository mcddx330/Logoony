<?php
require_once("logoony.php");

$text = "ここにテキストを入力"

$logoony = new Logoony();
$logoony->setText($text);
$result = $logoony->run();

var_dump($result);

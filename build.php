<?php
$phar = new Phar('frame.phar');

$phar->buildFromDirectory('./');
$phar->compressFiles(Phar::GZ);
$phar->stopBuffering();
$phar->setStub($phar->createDefaultStub('./index.php'));
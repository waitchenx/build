<?php
$phar = new Phar('frame.phar');

$phar->buildFromDirectory('./');
$phar->compressFiles(Phar::GZ);
$phar->stopBuffering();
$stub = $phar->createDefaultStub('./index.php');
$stub = str_replace('Phar::interceptFileFuncs();', '', $stub);
$phar->setStub("#!/usr/bin/env php\n" . $stub);
<?php
umask(0000); // This will let the permissions be 0777

// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it, or make something more sophisticated.
if (!in_array(@$_SERVER['REMOTE_ADDR'], array(
    '217.133.22.154', //AVANZI
    '212.31.242.18', //AVANZI COLT
    '93.34.48.99', //BARD
    '151.66.86.120', //CASA LORENZO
    '93.62.205.10', //SETT ENIGMISTICA
    '151.3.89.234', //SETT ENIGMISTICA
    '109.54.251.145', //TELEFONINO
    '::1',
))) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$kernel->handle(Request::createFromGlobals())->send();
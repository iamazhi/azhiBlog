#!/usr/bin/env php
<?php
include '../../../tests/init.php';    // Include the init file of testing framework.
include '../../router.class.php';     // Include router class.
include '../../helper.class.php';     // Include helper class.

title("testing the logic for site code.");

$router = router::createApp('test', '../../../');    
run(helper::getSiteCode('www.xirang.com')) && expect('xirang');
run(helper::getSiteCode('xirang.com')) && expect('xirang');
run(helper::getSiteCode('xirang.com.cn')) && expect('xirang');
run(helper::getSiteCode('www.xirang.cn')) && expect('xirang');
run(helper::getSiteCode('xirang')) && expect('xirang');
run(helper::getSiteCode('192.168.1.1')) && expect('192.168.1.1');
run(helper::getSiteCode('www.xirang.com.cn')) && expect('xirang');

run(appendChanzhiDomain());
run(helper::getSiteCode('xirang.n1.chanzhi.net')) && expect('xirang');

function appendChanzhiDomain()
{
    global $router;
    $router->config->domainPostfix .= '|n1.chanzhi.net|';
}

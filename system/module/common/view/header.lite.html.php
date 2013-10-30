<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
?>
<!DOCTYPE html>
<?php if($this->config->oauth->sina):?>
<html xmlns:wb=“http://open.weibo.com/wb”>
<?php else:?>
<html>
<?php endif;?>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
  if(!isset($title))    $title    = '';
  if(!empty($title))    $title   .= $lang->minus;
  if(!isset($keywords)) $keywords = $config->site->keywords;
  if(!isset($desc))     $desc     = $config->site->desc;

  echo html::title($title . $config->site->name);
  echo html::meta('keywords',    strip_tags($keywords));
  echo html::meta('description', strip_tags($desc));

  js::exportConfigVars();
  if($config->debug)
  {
      js::import($jsRoot . 'jquery/min.js');
      js::import($jsRoot . 'bootstrap/min.js');
      js::import($jsRoot . 'chanzhi.js');
      js::import($jsRoot . 'my.js');
      css::import($themeRoot . 'bootstrap/css/core.min.css');
      css::import($themeRoot . 'default/style.css');
  }
  else
  {
      css::import($themeRoot . 'default/all.css', $config->version);
      js::import($jsRoot     . 'all.js', $config->version);
  }

  if(RUN_MODE == 'admin') css::import($themeRoot . 'default/admin.css', $config->version);
  if(RUN_MODE == 'front' and $config->site->theme) css::import($themeRoot . $config->site->theme . '/style.css', $config->version);
  if(isset($pageCSS)) css::internal($pageCSS);

  echo html::icon($webRoot . 'favicon.ico');
  echo html::rss($config->webRoot .'rss.xml', $config->site->name);
?>
<!--[if lt IE 9]>
<?php
js::import($jsRoot . 'html5shiv/min.js');
js::import($jsRoot . 'respond/min.js');
?>
<![endif]-->
<?php js::set('lang', $lang->js);?>
<?php
$sina = json_decode($this->config->oauth->sina);
$qq   = json_decode($this->config->oauth->qq);
if($sina->widget) js::import('http://tjs.sjs.sinajs.cn/open/api/js/wb.js');
if($sina->verification) echo $sina->verification; 
if($qq->verification)   echo $qq->verification;
?>
</head>
<body>

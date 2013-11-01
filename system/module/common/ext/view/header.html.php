<?php 
include '../../view/header.lite.html.php';
js::set('lang', $lang->js);
?>
<style>
html {overflow:hidden}
.container { margin:0px; padding:0px;}
html, body, .container, #header > .row, #nameBox, 
#sloganBox, #sloganBox .row, #sloganBox .row div,
#middleBox, #leftBox, #rightBox
{height:100%}

#header {height:15%; margin:0px;}
#middleBox {height:85%}
#nameBox,#leftBox   {background:black}
#sloganBox {background:white; }
#name {color:white; font-size:36px; position:absolute}
#header #slogan {color:black; font-size:36px; position:absolute; margin:0px;}

#sloganBox .col-md-10 {border-bottom:1px solid #cecece; padding-right:0px;}
#leftBox {padding-left:0px; padding-right:0px; position:relative}
#leftBox .nav li   {border-bottom:1px solid #333}
#leftBox .nav li a {padding-left:50px; font-size:18px; color:#f1f1f1;}
#leftBox .nav li span {position:absolute;color:#f1f1f1; right:30px; top:11px;}
#leftBox .nav li a:hover {color:black; font-weight:bold; padding-left:60px; opacity:0.7}
</style>
<div class='container'>
  <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ) exit($lang->IE6Alert); ?>
  <div id='header'>
    <div class='row'>
      <div class='col-md-2' id='nameBox'>
        <div id='name'><?php echo $config->site->name;?></div>
      </div>
      <div class='col-md-10' id='sloganBox'>
        <div id='slogan'><?php echo $this->config->site->slogan;?></div>
        <div class='row'>
          <div class='col-md-2'></div>
          <div class='col-md-10'></div>
        </div>
      </div>
    </div>
  </div>

  <div class='row' id='middleBox'>
    <div class='col-md-2' id='leftBox'>
      <?php $topNavs = $this->loadModel('nav')->getNavs('top');?>
      <ul class='nav' >
        <?php foreach($topNavs as $nav1):?>
        <li class="<?php echo $nav1->class?>"> 
          <?php echo html::a($nav1->url, $nav1->title, isset($nav1->target) ? $nav1->target : '');?>
          <span><?php echo $lang->raquo;?></span>
        </li>
        <?php endforeach;?>
      </ul>
    </div>
    <div class='col-md-10' id='rightBox'>

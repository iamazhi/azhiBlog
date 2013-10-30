<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
  <?php if($this->moduleName == 'index' && isset($this->config->partner->index)):?>
  <ul id="friends" class="nav nav-pills">
    <?php echo html::a(helper::createLink('partner', 'index'), $lang->friendLink) . $lang->colon;?>
    <?php echo $this->config->partner->index; ?>
  </ul>
  <?php endif;?>
  <hr/>
  <footer>
    <?php 
    echo "&copy; {$config->company->name} {$config->site->copyright}-" . date('Y') . '&nbsp;&nbsp;';
    echo $config->site->icp;
    printf($lang->poweredBy, $config->version, $config->version);
    ?>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);

/* Load hook files for current page. */
$extPath      = dirname(dirname(dirname(__FILE__))) . '/common/ext/view/';
$extHookRule  = $extPath . 'footer.front.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
/* Load hook file for site.*/
$siteExtPath  = dirname(dirname(dirname(__FILE__))) . "/common/ext/_{$config->siteCode}/view/";
$extHookRule  = $siteExtPath . 'footer.front.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
?>
</div>
</body>
</html>

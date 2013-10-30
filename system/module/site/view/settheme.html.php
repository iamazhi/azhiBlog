<?php
/**
 * The settheme view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<table class='table'>
  <caption><?php echo $lang->site->setTheme?></caption>
  <tr>
  <?php $i = 0;?>
  <?php foreach($lang->site->themes as $theme => $name):?>
    <?php
    if($i%2 == 0) echo '</tr><tr>';
    $i++;
    $current = $theme == $config->site->theme ? 'current' : '';
    ?>
    <td class='a-center <?php echo $current; ?>'>
      <p><?php echo html::a(inlink('settheme', "theme={$theme}"), html::image($themeRoot . $theme . DS . 'preview.png', "class='thumbnail preview {$current}'"), '', "class='ajax'");?></p>
      <div class='info'> <?php echo $name;?> </div>
    </td>
  <?php endforeach;?>
  </tr>
</table>
<?php include '../../common/view/footer.admin.html.php';?>

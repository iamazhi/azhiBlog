<?php
/**
 * The browse view file of tree category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<?php 
js::set('root', $root);
js::set('book', $book);
js::set('type', $type);
?>


<?php if(strpos($treeMenu, '<li>') !== false):?>
<?php if(strpos($type, 'book_') !== false):?>
<div class='col-md-3'>
<?php else:?>
<div class='row'>
  <div class='col-md-4'>
<?php endif;?>
    <table class='table'>
      <caption><?php echo $title;?></caption>
      <tr>
        <td><div id='treeMenuBox'><?php echo $treeMenu . $backButton;?></div></td>
      </tr>
    </table>
  </div>
  <?php if(strpos($type, 'book_') !== false):?>
  <div class='col-md-9' id='categoryBox'></div>
  <?php else:?>
  <div class='col-md-8' id='categoryBox'></div>
</div>
  <?php endif;?>
  <?php else:?>
  <div class='col-md-12' id='categoryBox'></div>
</div>
  <?php endif;?>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/footer.admin.html.php';?>

<?php
/**
 * The setLink view file of partner module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     partner
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form action='' method='post' id='ajaxForm'>
  <table class='table table-form'>
    <caption><?php echo $lang->partner->common;?></caption> 
    <tr>
      <th><?php echo $lang->partner->index;?></th> 
      <td><?php echo html::textarea('index', $this->config->partner->index, "class='area-1' rows='10'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->partner->content;?></th> 
      <td><?php echo html::textarea('content', $this->config->partner->content, "class='area-1' rows='10'");?></td> 
    </tr>
    <tr>
      <th></th>
      <td>
        <?php echo html::submitButton($lang->submit);?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>

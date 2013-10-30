<?php
/**
 * The admin browse view file of help module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingtin Dai<daitingting@xirangit.com>
 * @package     help
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class="col-md-12">
  <table class='table table-hover table-bordered table-striped'>
    <caption>
      <div class='f-left'><?php echo $lang->help->books;?></div>
      <div class='f-right'><?php echo html::a($this->inlink('createBook'), $lang->book->create);?></div>
    </caption>
    <thead>
      <tr class='a-center'>
        <th class='w-p20'><?php echo $lang->book->name;?></th>
        <th><?php echo $lang->book->summary;?></th>
        <th class='w-200px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($books as $key => $book):?>
      <tr class='a-left v-middle'>
        <td><?php echo $book->name;?></td>
        <td><?php echo $book->summary;?></td>
        <td class='a-center'>
          <?php
          echo html::a($this->createLink('article', 'admin', "type=book_$book->key"), $lang->book->articleList);
          echo html::a($this->createLink('tree', 'browse', "type=book_$book->key"), $lang->book->directory);
          echo html::a($this->createLink('help', 'deletebook', "id=$book->id"), $lang->delete, '', "class='deleter'");
          echo html::a($this->createLink('help', 'editbook', "id=$book->id"), $lang->edit, '');
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>

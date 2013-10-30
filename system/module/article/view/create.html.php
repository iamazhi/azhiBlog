<?php
/**
 * The create view file of article category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('type',$type);?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>

<?php if(strpos($type, 'book') !== false):?>
<?php echo $categoryBox;?>
<div class='col-md-10'>
<?php endif;?>

<form method='post' class='form-inline' id='ajaxForm'> 
  <table class='table table-form'>
    <?php if($type == 'blog'):?>
    <caption><?php echo $lang->blog->create;?></caption>
    <?php else:?>
    <caption><?php echo $lang->article->create;?></caption>
    <?php endif;?>
    <tr>
      <th class='w-100px'><?php echo $lang->article->category;?></th>
      <?php if(strpos($type, 'book') !== false):?>
      <td><?php echo html::select("categories[]", $categories, $currentCategory, "class='select-3 form-control'");?></td>
      <?php else:?>
      <td><?php echo html::select("categories[]", $categories, $currentCategory, "multiple='multiple' class='select-3 form-control chosen'");?></td>
      <?php endif;?>
    </tr>
    <tr>
      <th><?php echo $lang->article->author;?></th>
      <td><?php echo html::input('author', $app->user->realname, "class='text-3 form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->original;?></th>
      <td>
        <?php echo html::select('original', $lang->article->originalList, 1, "class='select-3 form-control'");?>
        <span id='copyBox'>
          <?php
          echo html::input('copySite', '', "class='text-2 form-control' placeholder='{$lang->article->copySite}'");
          echo html::input('copyURL',  '', "class='text-4 form-control' placeholder='{$lang->article->copyURL}'");
          ?>
        </span>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->article->title;?></th>
      <td><?php echo html::input('title', '', "class='text-1 form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->alias;?></th>
      <td>
        <div class="input-group text-1">
        <span class="input-group-addon">http://<?php echo $this->server->http_host . $config->webRoot?>article/id@</span>
        <?php echo html::input('alias', '', "class='text-1 form-control'");?>
        <span class="input-group-addon">.html</span>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->article->keywords;?></th>
      <td><?php echo html::input('keywords', '', "class='text-1 form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->summary;?></th>
      <td><?php echo html::textarea('summary', '', "rows='2' class='area-1 form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->content;?></th>
      <td valign='middle'><?php echo html::textarea('content', '', "rows='10' class='area-1 form-control'");?></td>
    </tr>
    <tr>
      <td></td>
      <td><?php echo html::submitButton() . html::hidden('type', $type);?></td>
    </tr>
  </table>
</form>
<?php if(strpos($type, 'book') !== false):?>
</div>
<?php endif;?>

<?php include '../../common/view/footer.admin.html.php';?>

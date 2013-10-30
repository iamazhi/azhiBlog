<?php
/**
 * The error view file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     error
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>

<?php include '../../common/view/header.html.php';?>
<div class='alert alert-danger'>
    <h3><?php echo $lang->error->pageNotFound;?></h3>
    <p><?php echo $this->config->company->desc;?></p>
</div>
<div class='container'>
  <?php if(strpos($articleTree, '<li>') !== false):?>
  <div class='row'> 
    <h4><?php echo $lang->error->productCategory?></h4>
    <?php echo $productTree?>
  </div>
  <?php endif;?>
  <?php if(strpos($articleTree, '<li>') !== false):?>
  <div class='row'> 
    <h4><?php echo $lang->error->articleCategory?></h4>
    <?php echo $articleTree?>
  </div>
  <?php endif;?>
  <?php if(strpos($blogTree, '<li>') !== false):?>
  <div class='row'> 
    <h4><?php echo $lang->error->blogCategory?></h4>
    <?php echo $blogTree?>
  </div>
  <?php endif;?>
</div>
<?php include '../../common/view/footer.html.php';?>

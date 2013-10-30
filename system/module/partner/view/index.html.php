<?php 
include '../../common/view/header.html.php';
?>
<?php $common->printPositionBar($this->app->getModuleName());?>
<div class='box radius'>
  <h4 class='title'><?php echo $lang->partner->common;?></h4>
  <div class='content'>
    <p><?php echo $partner->content;?></p>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>

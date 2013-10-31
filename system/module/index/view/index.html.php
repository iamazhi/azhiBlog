<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php if($slides):?>
<div id='slide' class='carousel slide'>
  <div class='carousel-inner'>
    <?php foreach($slides as $slide):?>
    <div class='item'>
      <?php 
      if($slide->url != '' and $slide->label == '')
      {
          echo html::a($slide->url, html::image($slide->image));
      }
      else
      {
          echo html::image($slide->image);
      }
      ?>
      <div class='container'>
        <div class='carousel-caption'>
          <h2><?php echo $slide->title;?></h2>
          <div class='lead'><?php echo $slide->summary;?></div>
          <?php if(trim($slide->label) != '') echo html::a($slide->url, $slide->label, '', "class='btn btn-lg btn-primary'");?>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <?php echo html::a('#slide', $lang->prev, '', "class='left carousel-control' data-slide='prev'")?>
  <?php echo html::a('#slide', $lang->next, '', "class='right carousel-control' data-slide='next'")?>
</div>
<?php endif;?>

<?php if(count($products) >= 3):?>
<div class='row'>
  <?php foreach($products as $product):?>
  <?php 
  $category = array_shift($product->categories);
  $url = helper::createLink('product', 'view', "id={$product->id}", "category={$category->alias}&name={$product->alias}");
  ?>
  <div class="col-md-4">
    <div class='panel product-box'>
      <?php echo html::a($url, html::image($product->image->primary->smallURL), '', "class='thumbnail'");?>
      <div class="caption">
        <h3><?php echo html::a($url, $product->name);?></h3>
        <p><?php echo $product->summary;?></p>
      </div>
      <div class="widget-footer">
        <p>
          <?php echo html::a($url, $lang->more . $lang->raquo, '', "class=''");?>
        </p>
      </div>
    </div>
  </div>
  <?php endforeach;?>
</div>
<?php endif;?>
<div class='row'>
  <div class='col-md-4'>
    <div class="panel panel-default">
      <div class="panel-heading"><h3><?php echo $lang->index->aboutus;?></h3></div>
      <div class="panel-body"><p><?php echo $this->config->company->desc;?><?php echo html::a($this->createLink('company', 'index'), $lang->more . $lang->raquo);?></p></div>
    </div>
  </div>

  <div class='col-md-4'>
    <div class="panel panel-default">
      <div class="panel-heading"><h3><?php echo $lang->index->news;?></h3></div>
      <div class="panel-body"><ul class='mg-zero pd-zero'>
        <?php foreach($latestArticles as $article): ?>
        <?php 
        $category = array_shift($article->categories);
        $url = helper::createLink('article', 'view', "id={$article->id}", "category={$category->alias}&name={$article->alias}");
        ?>
        <li>
            <i class='icon-chevron-right'></i>
            <?php echo html::a($url, $article->title, '', "class='latest-news' title='{$article->title}'");?>
        </li>
        <?php endforeach;?>
      </ul></div>
    </div>
  </div>

  <div class='col-md-4'>
    <div id='contact' class="panel panel-default">
      <div class="panel-heading"><h3><?php echo $lang->index->contact;?></h3></div>
      <div class="panel-body">
        <?php foreach($contact as $item => $value):?>
        <dl>
          <dt><?php echo $this->lang->company->$item . $lang->colon;?></dt>
          <dd><?php echo $value;?></dd>
        </dl>
        <?php endforeach;?>
      </div>
    </div>
  </div>

</div>
<?php include '../../common/view/footer.html.php';?>

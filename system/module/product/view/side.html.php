<?php 
$topCategories = $this->loadModel('tree')->getChildren(0, 'product');
$hotProducts   = $this->loadModel('product')->getHot(0, 4);
?>
<div class='col-md-3'>
  <div id='contact' class="panel panel-default">
    <div class="panel-heading">
      <h4 class='title'><i class="icon-rocket"></i> <?php echo $lang->product->hot?></h4>
    </div>
    <div class="panel-body">
      <ul class="media-list">
        <?php foreach($hotProducts as $product):?>
        <li class='media'>
          <?php 
          $productCategory = array_shift($product->categories);
          $url = inlink('view', "id=$product->id", "category={$productCategory->alias}&name=$product->alias");
          $title = $product->image->primary->title ? $product->image->primary->title : $product->name;
          if(empty($product->image)) 
          {
              echo html::a($url, html::image($themeRoot . 'default/images/main/noimage.gif', "title='{$title}' class='adaptive'"), '', "class='media-image'");
          }
          else
          {
              echo html::a($url, html::image($product->image->primary->smallURL, "title='{$title}' class='adaptive'"), '', "class='media-image'");
          }
          ?>
          <div class='media-body'>
            <h5 class='media-heading'><?php echo html::a($url, $product->name);?></h5>
            <?php if($product->promotion != 0 && $product->price != 0):?>
            <p>
              <del><?php echo $lang->RMB . $product->price;?></del>
              <em><?php echo $lang->RMB . $product->promotion;?></em>
            </p>
            <?php elseif($product->promotion == 0 && $product->price != 0):?>
            <p><em><?php echo $lang->product->price . $lang->RMB . $product->price;?></em></p>
            <?php elseif($product->promotion != 0 && $product->price == 0):?>
            <p><em><?php echo $lang->product->promotion . $lang->RMB . $product->promotion;?></em></p>
            <?php endif;?>
          </div>
        </li>
        <?php endforeach;?>
      </ul>      
    </div>
  </div>
  <div class='list-group'> 
    <strong class='list-group-item list-group-title'><?php echo $lang->categoryMenu;?></strong>
    <?php
    foreach($topCategories as $topCategory){
        $browseLink = $this->createLink('product', 'browse', "categoryID={$topCategory->id}", "category={$topCategory->alias}");
        if($category->name==$topCategory->name)
        {
            echo html::a($browseLink, "<i class='icon-folder-open-alt '></i>" . $topCategory->name, '', "id='category{$topCategory->id}' class='list-group-item active'");
        }
        else
        {
            echo html::a($browseLink, "<i class='icon-folder-close-alt '></i>" . $topCategory->name, '', "id='category{$topCategory->id}' class='list-group-item'");
        }
    }
    ?>
  </div>
  <div id='contact' class="panel panel-default">
    <div class="panel-heading">
      <h4><?php echo $lang->company->contactUs;?></h4>
    </div>
    <div class="panel-body">
      <?php foreach($contact as $item => $value):?>
      <dl>
        <dt><?php echo $this->lang->company->$item . $lang->colon;?></dt>
        <dd><?php echo $value;?></dd>
        <div class='c-both'></div>
      </dl>
      <?php endforeach;?>      
    </div>
  </div>
</div>

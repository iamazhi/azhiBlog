<?php include '../../../common/view/header.html.php'; ?>
<div class='row'>
  <div class='col-md-9'>

    <?php
    if($category->parent)
    {
        $currentName  = $category->name;
        $id           = $category->parent;
        $category     = $topNavs[$category->parent];
        $category->id = $id;
    }
    $parentName = $category->name ? $category->name : $category->title;
    ?>
    <div class='row' id='childNavBox'>
      <div class='col-md-2' id='currentPos'>
        <span id='parentName'><?php echo $parentName;?></span>
        <span id='currentName'><?php echo $currentName;?></span>
      </div>
      <div class='col-md-10'>
       <ul id='childNav'>
          <?php foreach($topNavs[$category->id]->children as $child):?>
          <li class="cat-item <?php echo $child->class?>">
            <?php echo html::a($child->url, $child->title, isset($child->target) ? $child->target : '');?>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>

    <div class="row"  id='listBox'>
    <?php foreach($articles as $article):?>
    <?php $url = inlink('view', "id=$article->id", "category={$category->alias}&name=$article->alias");?>
        <div class='col-md-4'>
          <div class='content-box'>
            <h3 class='media-heading'><?php echo html::a($url, $article->title);?></h3>
            <p>
              <?php 
              if(!empty($article->image))
              {
                  $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
                  echo html::a($url, html::image($article->image->primary->smallURL, "title='{$title}' class='thumbnail'"));
              }
              ?>
              <?php echo $article->summary;?>
            </p>
            <p><span class='muted'><?php echo date('Y/m/d', strtotime($article->addedDate));?></span></p>
          </div>
        </div>
    <?php endforeach;?>
    </div>

    <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
    <div class='c-both'></div>

    </div>
  </div>
  <div class='col-md-3'>
  </div>
</div>

</div> <!-- rightBox-->
</div> <!-- middleBox-->

<?php include '../../../common/view/footer.html.php';?>

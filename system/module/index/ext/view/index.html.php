<?php include '../../../common/view/header.html.php';?>
<div class='row'>
  <div class='col-md-12'>
    <div class="row"  id='listBox'>
      <?php foreach($latestArticles as $article):?>
      <?php $url = $this->createLink('article', 'view', "id=$article->id", "category={$category->alias}&name=$article->alias");?>
      <div class='col-md-3'>
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
  </div>
</div>

</div> <!-- rightBox-->
</div> <!-- middleBox-->
<?php include '../../../common/view/footer.html.php';?>

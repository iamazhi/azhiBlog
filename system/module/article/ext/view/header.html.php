<style>
#childNavBox {height:46px; border-bottom:1px solid #cecece}

#currentPos {font-size:30px; color:#aaa; position:relative; float:left;}
#currentPos span{float:left;}
#currentName {font-size:15px;}

#childNav    {margin-bottom:0px; padding}
#childNav li {list-style:none; float:left; line-height:46px; padding:0px 15px;}
#childNav li a{color:#707070}

#listBox {margin-top:20px;}
#listBox .content-box 
{ 
    background: none repeat scroll 0 0 #FFFFCC; 
    box-shadow: 2px 2px 2px rgba(33, 33, 33, 0.7); 
    padding:5px 5px 0px 5px;
}
#listBox .content-box:hover 
{
    -moz-transition:-moz-transform .15s linear;
    -o-transition:-o-transform .15s linear;
    -webkit-transition:-webkit-transform .15s linear;
    -webkit-transform: scale(1.25);
    -moz-transform: scale(1.25);
    -o-transform: scale(1.25);
    position:relative;
    z-index:5;
}

</style>

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
<div class='row'>
  <div class='col-md-10' id='childNavBox'>
    <div class='col-md-2' id='currentPos'>
      <span id='parentName'><?php echo $parentName;?></span>
      <span id='currentName'><?php echo $currentName;?></span>
    </div>
    <div class='col-md-8'>
     <ul id='childNav'>
        <?php foreach($topNavs[$category->id]->children as $child):?>
        <li class="cat-item <?php echo $child->class?>">
          <?php echo html::a($child->url, $child->title, isset($child->target) ? $child->target : '');?>
        </li>
        <?php endforeach;?>
      </ul>
    </div>
  </div>
</div>



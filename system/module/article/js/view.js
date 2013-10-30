$(document).ready(function()
{
    $('#commentBox').load( createLink('comment', 'show', 'objectType=article&objectID=' + v.articleID) );  
    $('.article-file img').resizeImage(350, 200);
});

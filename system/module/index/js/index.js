$(document).ready(function()
{          
    // auto ajust panel height.
    var fitPanelHeight = 0;
    $('.row').each(function()
    {
      fitPanelHeight = 0;
      $(this).find('.panel').each(function(){fitPanelHeight=Math.max($(this).height(),fitPanelHeight);}).height(fitPanelHeight);
    });

    // add "index" class to the body element.
    $('body').addClass('index');

    // slide pictures start.     
    $('#slide').carousel();
    $('#slide .item').first().addClass('active');
    $('.nav-system-home').addClass('active');
})                     

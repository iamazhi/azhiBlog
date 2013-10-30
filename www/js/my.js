$(document).ready(function() 
{
    setRequiredFields();
    setAdminLeftMenu();

    $('img.adaptive').each(function()
    {
      $(this).resizeImage()
    });
    $.setAjaxModal();
    $.setAjaxForm('#ajaxForm');
    $.setAjaxDeleter('.deleter');

    $("#topNav li").hover(function () 
    {
        $(this).toggleClass('hover');
    });
});

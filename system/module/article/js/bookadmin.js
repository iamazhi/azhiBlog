$(document).ready(function()
{
    $('.leftmenu li.active').removeClass('active');
    $('.leftmenu a[href*=' + v.type + ']').parent().addClass('active');
});

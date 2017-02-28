$(document).ready(function(){
  $('.switch label').bind('click', function(){
    if(!$(this).hasClass('selected')) {
      $(this).addClass('selected').siblings('label').removeClass('selected');
    }
  });
});
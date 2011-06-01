$(document).ready(function(){
  $('.switch label').live('click', function(){
    if(!$(this).hasClass('selected')) {
      $(this).addClass('selected').siblings('label').removeClass('selected');
    }
  });
});
$('#dropdown-menu-lang a').click(function(){
  $('#selected-dropdown-menu').text($(this).text());
});

$('#selected-dropdown-menu').text($('.dropdown-menu a.active').text());
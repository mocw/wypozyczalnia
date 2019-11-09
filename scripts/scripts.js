function openPage(url) {
    var win = window.open(url, '_self');
    win.focus();
  }

  
  
  window.setTimeout(function() {
    $("div.disappear").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);




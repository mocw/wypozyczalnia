function openPage(url) {
    var win = window.open(url, '_self');
    win.focus();
  }


 
  if (document.createElement('details')) {
    $('body').on('click', 'div.geo details', function () {
      var _geo = $(this);
      var _has = _geo.attr('open');
      if (_has != null) {
        _geo.attr('open', null);
      } else {
        _geo.attr('open', '');
      }
    });
  }

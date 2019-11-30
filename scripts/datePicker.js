$(function() {
    var holidays = [
      '1.1.2020',
      '2.1.2020',
      '20.2.2020',
      '19.1.2020',
      '1.8.2020',
      '15.8.2020',
      '1.11.2020',
      '8.12.2019',
      '25.12.2019',
      '26.12.2019'
    ];
    function noSundaysOrHolidays(date) {
      var day = date.getDay();
      if (day != 0) {
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        for (i = 0; i < holidays.length; i++) {
          if($.inArray((d) + '.' + (m+1) + '.' + y, holidays) != -1) {
            return [false];
          }
        }
        return [true];
      } else {
        return [day != 0, ''];
      }
    }
  
    $('#dataOdbioru').datepicker({
      onClose: function(dateText, inst) { 
          $(this).attr("disabled", false);
      },
      beforeShow: function(input, inst) {
        $(this).attr("disabled", true);
      },
      beforeShowDay: noSundaysOrHolidays,
      minDate: 0,
      dateFormat: 'dd.mm.yy',
    });

    $('#dataZwrotu').datepicker({
        onClose: function(dateText, inst) { 
            $(this).attr("disabled", false);
        },
        beforeShow: function(input, inst) {
          $(this).attr("disabled", true);
        },
        beforeShowDay: noSundaysOrHolidays,
        minDate: 0,
        dateFormat: 'dd.mm.yy',
      });

  });

// $(function() {
//   var x;
//     var holidays = [
//       '1.1.2020',
//       '2.1.2020',
//       '20.2.2020',
//       '19.1.2020',
//       '1.8.2020',
//       '15.8.2020',
//       '1.11.2020',
//       '8.12.2019',
//       '25.12.2019',
//       '26.12.2019'
//     ];
//     function noSundaysOrHolidays(date) {
//       var day = date.getDay();
//       console.log(day);
//       if (day != 0) {
//         var d = date.getDate();
//         var m = date.getMonth();
//         var y = date.getFullYear();
//         for (i = 0; i < holidays.length; i++) {
//           if($.inArray((d) + '.' + (m+1) + '.' + y, holidays) != -1) {
//             return [false];
//           }
//         }
//         return [true];
//       } else {
//         return [day != 0, ''];
//       }
//     }
  
//     $('#dataOdbioru').datepicker({
//       onClose: function(dateText, inst) { 
//           $(this).attr("disabled", false);
//           x = document.getElementById('dataOdbioru').value;
//           if(x!=""){
//             document.getElementById("dataZwrotu").disabled = false;
//           }                    
//       },
//       beforeShow: function(input, inst) {
//         $(this).attr("disabled", true);
//       },
//       beforeShowDay: noSundaysOrHolidays,
//       minDate: 0,
//       dateFormat: 'dd.mm.yy',
//     });

//     $('#dataZwrotu').datepicker({
//         onClose: function(dateText, inst) { 
//             $(this).attr("disabled", false);
//         },
//         beforeShow: function(input, inst) {
//           $(this).attr("disabled", true);
//         },
//         beforeShowDay: noSundaysOrHolidays,
//         minDate: 0,
//         dateFormat: 'dd.mm.yy',
//       });

//   });

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
    console.log(i);
    return [true];
  } else {
    return [day != 0, ''];
  }
}



var dateToday = new Date();
var dates = $("#dataOdbioru, #dataZwrotu").datepicker({
  onClose: function(dateText, inst) { 
    x = document.getElementById('dataOdbioru').value;
    if(x!=""){
      var date=new Date(x);
      var dd=date.getDate();
      var mm=date.getMonth()+1;
      var yyyy=date.getFullYear();
      var fullDate=dd+'.'+mm+'.'+yyyy;
      fullDate=fullDate.toString();
      holidays.push(fullDate);
    }
},
beforeShowDay: noSundaysOrHolidays,
defaultDate: "+1w",
changeMonth: true,
minDate: dateToday,
onSelect: function(selectedDate) {
    var option = this.id == "dataOdbioru" ? "minDate" : "maxDate",
        instance = $(this).data("datepicker"),
        date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
    dates.not(this).datepicker("option", option, date);
}
});
var modalConfirm = function(callback){
  
    $("#btn-confirm").on("click", function(){
      $("#mi-modal").modal('show');
    });
  
    $("#modal-btn-si").on("click", function(){
      callback(true);
      $("#mi-modal").modal('hide');
    });
    
    $("#modal-btn-no").on("click", function(){
      callback(false);
      $("#mi-modal").modal('hide');
    });
  };
  
  modalConfirm(function(confirm){
    if(confirm){
      //TAK
      $("#result").html
    }else{
      //NIE
      $("#result").html("<h2>SRAKA</h2>");
    }
  });
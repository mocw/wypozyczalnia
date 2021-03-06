var rowsPDF = document.getElementById("dtOrderExample").getElementsByTagName("tr").length;
rowsPDF-=2;

for(let l=1;l<=rowsPDF;l++) {
    $('#cmd' + l).click( function(){
        var specialElementHandlers = {
            '#editor': function (element,renderer) {
                return true;
            }
        };
            var doc = new jsPDF();
            doc.fromHTML($('#target'+l).html(), 15, 15, {
                'width': 190,'elementHandlers': specialElementHandlers
            });
            doc.setFontSize(15);
            doc.text(doc.internal.pageSize.getWidth()/2-30, 13, "Umowa wynajmu samochodu"); 
            doc.setFontSize(13);      
            doc.text(doc.internal.pageSize.getWidth()/2, 105, "§1");  
            doc.text(10, doc.internal.pageSize.getHeight()-30, "Podpis wynajmujacego");
            doc.text(10, doc.internal.pageSize.getHeight()-10, "......................................");  
            doc.text(doc.internal.pageSize.getWidth()-50, doc.internal.pageSize.getHeight()-30, "Podpis najemcy");
            doc.text(doc.internal.pageSize.getWidth()-58, doc.internal.pageSize.getHeight()-10, "......................................");
            doc.setProperties({
                title: 'Umowa',
                subject: 'Umowa'
            });
            
            //window.open(doc.output('bloburl'), '_blank');             
            window.open(doc.output('bloburl'),'_self');
            //doc.save("Umowa");
    });
  }


//https://blog.jayway.com/2017/07/13/open-pdf-downloaded-api-javascript/
function convert_HTML_To_PDF(){
    var doc = new jsPDF();
    var elementHTML = $('#content').html();
    var specialElementHandlers = {
        '#elementH': function(element, renderer){
            return true;
        }
    };

    doc.fromHTML(elementHTML, 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
    });

    doc.save('participants.pdf');
}

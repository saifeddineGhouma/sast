<script type="text/javascript">
$(".touchspin_1").TouchSpin({
    min: 0,
    max: 20000,
    step: 0.01,
    decimals: 2,
    boostat: 5,
    maxboostedstep: 10,
    postfix: '$'
}); 

$(".touchspin_2").TouchSpin({
    min: 0,
    max: 1000,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: ''
});  

$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});


function addVariation(type){
    var id =  1;
    var lastRow = $('#variations_'+type+' > tbody');
    var trLast = $('#variations_'+type+' tbody>tr:last');
    if(trLast.data("id")){
        id = parseInt(trLast.data("id"))+1;
    }
    var htmltmp = '<tr id="variation_'+type+'-row'+id+'" data-id="'+id+'">'+
        ' <td>'+
            '<input type="text" id="qte'+id+'" onchange="montant('+id+')" name="qte[]" class="form-control touchspin_2" />'+
        '</td>';

    htmltmp += '<td>'+
            '<input  type="text"  name="desc[]" class="form-control" >'+
        '</td>'+
        ' <td>'+
            '<input  type="text" id="price'+id+'" onchange="montant('+id+')" name="price[]" class="form-control touchspin_1" >'+
        '</td>'+
        ' <td >'+
            '<div id="montant'+id+'"></div>'+
        '</td>'+
        '<td class="text-left"><button type="button" onclick="$(\'#variation_'+type+'-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ';
    lastRow.append(htmltmp);
    var currentRow = $('#variation_'+type+'-row'+id);
    currentRow.find(".touchspin_1").TouchSpin({
        min: 0,
        max: 20000,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '$'
    });
    currentRow.find(".touchspin_2").TouchSpin({
        min: 0,
        max: 1000,
        step: 1,
        decimals: 0,
        boostat: 5,
        maxboostedstep: 10,
        postfix: ''
    });
    var currentRow = $('#variation_'+type+'-row'+id);
    
}

function montant(id){
	var qte = document.getElementById("qte"+id).value;
	var price = document.getElementById("price"+id).value;
	 
	var tot = qte * price;
	tot = tot.toFixed(2);
	
	document.getElementById("montant"+id).innerHTML = "$" + tot;
}
$(".printOrder").click(printdiv);

function printdiv() {
	var id = $("#id").val();
    var iFrame = document.createElement('iframe');
    iFrame.style.position = 'absolute';
    iFrame.style.left = '-99999px';
    iFrame.src = "{{url('admin/invoice/pdf/')}}"+"/"+id;
    iFrame.onload = function() {
      function removeIFrame(){
        document.body.removeChild(iFrame);
        document.removeEventListener('click', removeIFrame);
      }
      document.addEventListener('click', removeIFrame, false);
    };

    document.body.appendChild(iFrame);
 
};

</script>
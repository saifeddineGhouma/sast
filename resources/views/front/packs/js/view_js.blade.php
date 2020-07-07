<script>
	$(".select_form").change(function(){
        var quantity = $("select[name='quantity']").val();
		var price = $("input[name='prix_id']").val();
		if(price==undefined)
			price = 0;
		var vat = '{{App('setting')->vat}}';

		price = quantity*price;
        vat = parseFloat(vat)*price/100;

        $("#quantity_span").html(quantity);
		$("#ttlprc").html(price+vat+"$");
    });
</script>
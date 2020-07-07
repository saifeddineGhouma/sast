
<script type="text/javascript">


$(".select2").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});
$(".printOrder").click(printdiv);

function printdiv() {
	var id = $("#id").val();
    var iFrame = document.createElement('iframe');
    iFrame.style.position = 'absolute';
    iFrame.style.left = '-99999px';
    iFrame.src = "{{url('admin/book-orders/report/')}}"+"/"+id;
    iFrame.onload = function() {
      function removeIFrame(){
        document.body.removeChild(iFrame);
        document.removeEventListener('click', removeIFrame);
      }
      document.addEventListener('click', removeIFrame, false);
    };

    document.body.appendChild(iFrame);
 
};

 $("#orders-form").bootstrapValidator({
	excluded: [':disabled'],
    fields: {

    }
}).on('success.form.bv', function(e) {
});



</script>
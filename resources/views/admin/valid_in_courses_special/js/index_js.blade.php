
<script type="text/javascript">
$(".remove").click(function(){
   alert('test')
     
    });

    $(document).ready(function(){
         
    var options = { 
    buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'copy', className: 'btn red btn-outline'},
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'excel', className: 'btn yellow btn-outline '},
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'colvis', className: 'btn dark btn-outline'}
            ],
       "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
       "drawCallback": function() {
            $(".livicon").addLivicon();
        },
    "order": [ 0, "desc" ],
};
formFilter()


});
function confirmDelete(id)
{
              var csrf_token=$('meta[name="csrf_token"]').attr('content');

            swal({
               title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            })
            .then((willDelete) => {
                if (typeof willDelete.dismiss == "undefined" ||willDelete.dismiss == null) {
                    
                    $.ajax({
                        url : "{{ url('admin/courses_special-delete')}}" + '/' + id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token': '{{csrf_token()}}'},
                        success: function(data){
                            
                           swal({
                                title: "It was deleted!",
                                type: "success",
                                confirmButtonText: "Ok!",
                                });
                           formFilter();
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your imaginary file is safe!");
                }
            });
}
function formFilter(/*e*/){


 var options = { 
    buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'copy', className: 'btn red btn-outline'},
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'excel', className: 'btn yellow btn-outline '},
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'colvis', className: 'btn dark btn-outline'}
            ],
       "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
       "drawCallback": function() {
            $(".livicon").addLivicon();
        },
    "order": [ 0, "desc" ],
};




   // e.preventDefault();
    var data = $('#search_form').serializeArray();
    var trashed = $("input[name='trashed']").is(":checked");
    data.push({trashed: trashed});

    $.ajax({
        url: "{{ url('admin/courses_special/listing/') }}" ,
        type: "GET",
        data: data,
        beforeSend: function(){

            $('#filterBtn').button('loading');
        },
        success: function(result){

          
            $("#childList").html(result);
            $('#table1').DataTable(options);
           
        },
        error: function(error){

        },
        complete: function(){
            $('#filterBtn').button('reset');
        }
    });
};
//$("#search_form").onClick("submit",formFilter());
$("#filterBtn").click(function(){
    formFilter()
})
//$("#search_form").submit();
</script>

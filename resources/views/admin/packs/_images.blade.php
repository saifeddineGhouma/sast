<script type="text/javascript">
$(document).ready(function(){
	$('a.delete').click(function(){
		var thisimg = $(this);
		 bootbox.confirm("هل أنت متأكد من أنك تريد حذف الصورة", function(result) {
                	
					if (result == true) {
						var img = thisimg.parent().attr('id');
						var id = thisimg.parent().parent().attr('id');
						var mydata = new Array();
						mydata[0]=id;
						mydata[1]=img;						
						var _token = '<?php echo csrf_token(); ?>';	
						var jsonString = JSON.stringify(mydata);
						var parent = thisimg.parent();
						$.ajax({
							type: "POST",
							url: '{{url("/admin/packs/deleteimaeajax")}}',
							data: {_token:  _token,data : jsonString},
							success: function(){
								parent.fadeOut('slow', function() {thisimg.remove();});
								
							}
						});
					}
			});
		
	});
});
</script>

<div class="row">
	<?php 
	if(isset($packs->image) && !empty($packs->image)){
		echo '<div id="'.$packs->id.'" >';
		echo '<div id="'.$packs->image.'">
				<a  href="javascript:void(0);" class="delete" >
				<img src="'.asset("uploads/kcfinder/upload/image/packs/".$packs->image).'" alt="'.$packs->titre.'" style="width:100px;"/>'
				.'</td>
				</a></div>';
		echo '</div>';
	}
	?> 
</div>
 <script type="text/javascript">
    $(document).ready(function() {    	
        var d = window.location.href;
        var menucoun = 1;
        $('ul.page-sidebar-menu li').each(function() {
            var t = $(this);
            var x = t.find('a').attr('href'); 
          	
          	if(d.indexOf("create/dream") > -1 || d.indexOf("edit/dream") > -1){
          		$("#dream_articles").addClass('active');;
          		$("#dream_articles").closest("ul").addClass("in");
          		$("#dream_articles").parent().closest('li').addClass('active');
          		return false;
          	}
          	
            if (x==d || x!="" && (d.indexOf(x+"/edit") > -1 || d.indexOf(x+"/create") > -1)|| d.indexOf(x+"/view/") > -1) {            	 
        		 $(this).addClass('active');
        		  $(this).closest("ul").addClass("in");
        		 
        		 
        		 $(this).parent().closest('li').addClass('active');
        		 
        		 // $(this).parent().closest('li').parent().closest('li').addClass('active');
        		
        		
        		 return false;
            }
        });
    });
    
   
</script>
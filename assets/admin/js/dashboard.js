    
        // top menu

     var useOnComplete = false,
         useEasing = false,
         useGrouping = false,
         options = {
             useEasing : useEasing, // toggle easing
             useGrouping : useGrouping, // 1,000,000 vs 1000000
             separator : ',', // character to use as a separator
             decimal : '.' // character to use as a decimal
         };

     
        var my_posts = $("[rel=tooltip]");

            var size = $(window).width();
            for (i = 0; i < my_posts.length; i++) {
                the_post = $(my_posts[i]);

                if (the_post.hasClass('invert') && size >= 767) {
                    the_post.tooltip({
                        placement: 'left'
                    });
                    the_post.css("cursor", "pointer");
                } else {
                    the_post.tooltip({
                        placement: 'right'
                    });
                    the_post.css("cursor", "pointer");
                }
            }
    //Percentage Monitor
              $(document).ready(function()

        {

            /** BEGIN WIDGET PIE FUNCTION **/
            if ($('.widget-easy-pie-1').length > 0)
            {
                $('.widget-easy-pie-1').easyPieChart({
                    easing: 'easeOutBounce',
                    barColor : '#F9AE43',
                    lineWidth: 5
                });
            }
            if ($('.widget-easy-pie-2').length > 0)
            {
                $('.widget-easy-pie-2').easyPieChart({
                    easing: 'easeOutBounce',
                    barColor : '#F9AE43',
                    lineWidth: 5,
                    onStep: function(from, to, percent) {
                        $(this.el).find('.percent').text(Math.round(percent));
                    }
                });
            }

            if ($('.widget-easy-pie-3').length > 0)
            {
                $('.widget-easy-pie-3').easyPieChart({
                    easing: 'easeOutBounce',
                    barColor : '#EF6F6C',
                    lineWidth: 5
                });
            }
            /** END WIDGET PIE FUNCTION **/



        });

    //world map
   
     $(document).ready(function() {
         var composeHeight = $('#calendar').height() + 21 - $('.adds').height();
         $('.list_of_items').slimScroll({
             color: '#A9B6BC',
             height: composeHeight + 'px',
             size: '5px'
         });
     });

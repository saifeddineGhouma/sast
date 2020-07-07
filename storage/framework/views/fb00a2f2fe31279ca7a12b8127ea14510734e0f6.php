<script>
    $(document).ready(function() {
        var d = window.location.href;
        var menucoun = 1;
        $('.m-menu li').each(function() {
            var t = $(this);
            var x = t.find('a').attr('href');


            if (x==d) {
                $(this).find('a').addClass('link-actived');
                return false;
            }
        });
    });
</script>
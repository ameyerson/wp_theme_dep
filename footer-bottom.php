

    <?php wp_footer(); ?>

    <!--[if lte IE 8]>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/libraries/jquery.backstretch.min.js"></script>
    <![endif]-->

    <script>
    	if (($('html')).hasClass('no-backgroundsize')) {
    		$('.backstretch').each(function() {
    			img = $(this).attr('data-fullscreenBackground');
            //    alert($(this).attr('data-fullscreenBackground'));
				$(this).backstretch(img);
    		});
    	}
	</script>

</body>
</html>
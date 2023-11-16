
<?php 
get_header();


do_action('smart_coder_before_book_page');

do_shortcode( "[render_book_page]" );

do_action('smart_coder_after_book_page');

get_footer();
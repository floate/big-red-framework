<?php
global $soup;
get_header();

while (have_posts()) : the_post();
echo '<p>';
post_class();
echo '</p>';
endwhile;


get_sidebar();
get_footer();
?>
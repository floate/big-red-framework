<?php
/*
Template Name: Full Width Template
*/

get_header();
?>

<div id="content">
	<?php 
		get_template_part( 'template-parts/loop', 'page' ); 
	?>
</div><!-- //#content -->
<?php 
get_footer();
?>
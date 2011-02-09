<?php
global $soup;
get_header();
?>

<div id="content">
	<?php 
		get_template_part( 'template-parts/loop', 'single' ); 
		get_sidebar('a'); 
	?>
</div><!-- //#content -->
<?php 
get_sidebar('b'); 
get_footer();
?>
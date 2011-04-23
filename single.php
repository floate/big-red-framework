<?php
global $soup;
get_header();
?>

<div id="content">
	<?php 
		if (is_attachment() {
			$templateSubPart = 'attachment';
		}
		else {
			$templateSubPart = 'single';
		}
	
		get_template_part( 'template-parts/loop', $templateSubPart ); 
		get_sidebar('a'); 
	?>
</div><!-- //#content -->
<?php 
get_sidebar('b'); 
get_footer();
?>
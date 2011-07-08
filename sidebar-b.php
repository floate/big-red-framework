<?php if (bigRed_option('widget-sidebar-b')) :?>
<div id="contentC" class="sidebar" role="complementary">
	<?php
	
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bigredwidget_sidebar-b') ) {
			//insert static sidebar
		}
	
	?>
</div>
<!-- //#contentC .sidebar -->
<?php endif; //bigRed_option('widget-sidebar-b')
?>
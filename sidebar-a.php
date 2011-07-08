<?php if (bigRed_option('widget-sidebar-a')) :?>
<div id="contentB" class="sidebar" role="complementary">
	<?php
	
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bigredwidget_sidebar-a') ) {
			//insert static sidebar
		}
	
	?>
</div>
<!-- //#contentB .sidebar -->
<?php endif; //bigRed_option('widget-sidebar-a')
?>
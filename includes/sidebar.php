<ul class="sidebar-menu" data-widget="tree" style="font-size:12px;">
	<li class="header" style="text-align: center; color:#fff;">MENU</li>
	<?php if($_SESSION['users'] != Null) { ?>
		<li class="<?php if($_GET['menu_id'] == 7) { ?> active <?php } ?>">
			<a href="?menu_id=7"><i class="fa fa-user"></i> <span>USERS</span></a>
		</li>
	<?php } ?>
</ul>
<div id="menu-<?php echo $menu['Menu']['id']; ?>" class="menu">
<?php
	$defaults = array(
		'mainClass' => 'nav nav-pills',
		'mainRole' => 'menulist',
		'subClass' => 'dropdown-menu',
		'subRole' => 'menu'
	);
	$options = Hash::merge($defaults, $options);
	echo $this->BootstrapNav->nestedLinks($menu['threaded'], $options);
?>
</div>
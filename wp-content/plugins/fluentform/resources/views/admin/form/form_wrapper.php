<div class="wrap ff_form_wrap ff_screen_<?php echo $route; ?>">
	<?php do_action('fluentform_before_form_screen_wrapper', $form_id, $route); ?>
	
	<div class="form_internal_menu">

        <div title="<?php echo $form->title; ?>" class="ff_form_name" id="js-ff-nav-title">
			<span><?php echo $form->title; ?></span>
		</div>

		<ul class="ff_setting_menu">
			<?php foreach ($menu_items as $menu_index => $menu_item): ?>
				<li class="<?php if ($route == $menu_item['slug']) echo "active"; ?>">
                    <a href="<?php echo $menu_item['url']; ?><?php if (isset($menu_item['hash'])) echo "#{$menu_item['hash']}"; ?>">
                        <?php echo $menu_item['title']; ?>
                    </a>
                </li>
			<?php endforeach; ?>
		</ul>
		
		<div class="ff-navigation-right">
			<?php do_action('fluentform_after_form_navigation', $form_id, $route); ?>
			<?php do_action('fluentform_after_form_navigation_' . $route, $form_id); ?>
		</div>
	</div>

	<div class="ff_form_application_container">
		<?php do_action('ff_fluentform_form_application_view_' . $route, $form_id); ?>
	</div>
	
	<?php do_action('fluentform_after_form_screen_wrapper', $form_id, $route); ?>
</div>

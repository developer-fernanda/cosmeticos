<div class="ff_settings_wrapper">
	<div class="ff_settings_sidebar">
		<ul class="ff_settings_list">
			<?php
				$settings_base_url = admin_url('admin.php?page=fluent_forms&form_id='.$form_id.'&route=settings&sub_route=form_settings');
			?>
			<?php foreach ($settings_menus as $settings_menu): ?>

				<li class="<?php if($settings_menu['slug'] == $current_sub_route) { echo "activex"; } ?>">
                    <?php if(isset($settings_menu['route'])): ?>
                        <?php
                            $route = $settings_menu['route'];
                        ?>
                        <a data-route_key="<?php echo sanitize_key($route); ?>" href="<?php echo $settings_base_url; ?>#<?php echo $route; ?>">
                            <?php echo $settings_menu['title']; ?>
                        </a>
                    <?php else: ?>
                    <a <?php if(isset($settings_menu['class'])) { echo 'class="'.$settings_menu['class'].'"'; } ?> data-settings_key="<?php echo (isset($settings_menu['settings_key'])) ? $settings_menu['settings_key'] : '';?>" data-component="<?php echo (isset($settings_menu['component'])) ? $settings_menu['component'] : '';?>" data-hash="<?php echo (isset($settings_menu['hash'])) ? $settings_menu['hash'] : '';?>" href="<?php echo $settings_base_url.'&sub_route='.$settings_menu['slug']; ?><?php if(isset($settings_menu['hash'])) { echo '#'.$settings_menu['hash']; } ?>">
						<?php echo $settings_menu['title']; ?>
					</a>
                    <?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="ff_settings_container">
		<?php do_action('fluentform_form_settings_container_'.$current_sub_route, $form_id); ?>
	</div>
</div>
<?php do_action('fluentform_global_menu'); ?>
<div class="ff_form_wrap">
    <div class="ff_form_wrap_area">
        <div class="ff_add_on_navigation">
            <ul>
                <li class="ff_add_on_item <?php echo ($current_menu_item == 'fluentform_add_ons') ? 'ff_menu_item_active' : ''; ?>">
                    <a href="<?php echo $base_url; ?>">
                        Modules
                    </a>
                </li>
                <?php foreach ($menus as $menu_index => $menu_title): ?>
                    <li class="ff_add_on_item ff_add_on_item_<?php echo $menu_index; ?> <?php echo ($current_menu_item == $menu_index) ? 'ff_menu_item_active' : ''; ?>">
                        <a href="<?php echo $base_url; ?>&sub_page=<?php echo $menu_index; ?>">
                            <?php echo $menu_title; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="ff_add_on_body ff_add_on_body_<?php echo $current_menu_item; ?>">
            <?php
            do_action('fluentform_addons_page_render_' . $current_menu_item);
            ?>
        </div>
    </div>
</div>
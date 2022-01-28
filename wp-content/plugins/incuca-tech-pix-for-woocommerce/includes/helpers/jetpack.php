<?php
add_filter( 'jetpack_lazy_images_blocked_classes', 'exclude_custom_logo_class_from_lazy_load', 999, 1 );
function exclude_custom_logo_class_from_lazy_load( $classes ) {
   $classes[] = 'wcpix-img-copy-code';
   return $classes;
}

<?php

namespace FluentForm\App\Modules\Acl;

class RoleManager
{
    public function getRoles() {
        if(!current_user_can('manage_options')) {
            wp_send_json_success(array(
                'capability' => array(),
                'roles'      => array()
            ), 200);
        }

        $roles = \get_editable_roles();
        $formatted = array();
        foreach ($roles as $key => $role) {
            if($key == 'administrator') {
                continue;
            }
            if($key != 'subscriber') {
                $formatted[] = array(
                    'name' => $role['name'],
                    'key'  => $key
                );
            }
        }

        $capability = get_option('_fluentform_form_permission');

        if (is_string($capability)) {
            $capability = [];
        }

        wp_send_json_success(array(
            'capability' => $capability,
            'roles'      => $formatted
        ), 200);
    }

    public function setRoles() {
        if(current_user_can('manage_options')) {
            $capability = isset($_REQUEST['capability']) ? wp_unslash($_REQUEST['capability']) : [];

            foreach ($capability as $item) {
            	if (strtolower($item) == 'subscriber') {
		            wp_send_json_error(array(
			            'message' => __('Sorry, you can not give access to the Subscriber role.', 'fluentform')
		            ), 423);
	            }
            }

            update_option('_fluentform_form_permission', $capability, 'no');
            wp_send_json_success( array(
                'message' => __('Successfully saved the role(s).', 'fluentform')
            ), 200 );
        } else {
            wp_send_json_error(array(
                'message' => __('Sorry, You can not update permissions. Only administrators can update permissions', 'fluentform')
            ), 423);
        }
    }

    public function verifyPermissionSet()
    {
        $availablePermissions = Acl::getPermissionSet();
        $currentCapability = $this->currentUserFormFormCapability();
        if(!$currentCapability) {
            return;
        }

        // Give permission to internal issues
        foreach ($availablePermissions as $permission) {
            add_filter('fluentform_verify_user_permission_'.$permission, function ($allowed) {
                return true;
            });
        }

        // Give permission to menu items
        add_filter('fluentform_dashboard_capability', function ($capability) use ($currentCapability) {
            return $currentCapability;
        });

        add_filter('fluentform_settings_capability', function ($capability) use ($currentCapability) {
            return $currentCapability;
        });
    }

    public function currentUserFormFormCapability() {

        if(current_user_can('manage_options')) {
            return 'manage_options';
        }
        if(!is_user_logged_in()) {
            return false;
        }

        $capabilities = get_option('_fluentform_form_permission');
        if (is_string($capabilities)) {
            $capabilities = [];
        }
        if(!$capabilities) {
            return;
        }
        foreach ($capabilities as $capability) {
            if(current_user_can($capability)) {
                return $capability;
            }
        }
        return false;
    }

}

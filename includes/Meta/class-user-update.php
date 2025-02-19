<?php

class UAB_User_Update {
    public function __construct() {
        add_action('personal_options_update', [$this, 'uab_save_custom_user_profile_fields']);
        add_action('edit_user_profile_update', [$this, 'uab_save_custom_user_profile_fields']);
    }

    public function uab_save_custom_user_profile_fields($user_id) {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        update_user_meta($user_id, 'uab_author_image', esc_url($_POST['uab_author_image']));
    }
}
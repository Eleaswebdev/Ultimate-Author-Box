<?php

class UAB_Loader {
    public static function init() {
        // Load core functionality
        require_once UAB_PLUGIN_DIR . 'includes/class-activator.php';
        require_once UAB_PLUGIN_DIR . 'includes/class-deactivator.php';

        require_once UAB_PLUGIN_DIR . 'includes/Assets/class-assets.php';

        // Load Admin classes
        require_once UAB_PLUGIN_DIR . 'includes/Admin/class-admin-menu.php';
        require_once UAB_PLUGIN_DIR . 'includes/Admin/class-admin-settings.php';

        // Load User Meta
        require_once UAB_PLUGIN_DIR . 'includes/Meta/class-user-meta.php';
        require_once UAB_PLUGIN_DIR . 'includes/Meta/class-user-update.php';

        // Load Frontend classes
        require_once UAB_PLUGIN_DIR . 'includes/Frontend/class-author-box.php';

        // Load Database classes
        require_once UAB_PLUGIN_DIR . 'includes/Database/class-database-handler.php';

        // Initialize components
        new UAB_Admin_Menu();
        new UAB_Admin_Settings();
        new UAB_Author_Box();
        new UAB_Assets();
        new UAB_User_Meta();
        new UAB_User_Update();
    }
}

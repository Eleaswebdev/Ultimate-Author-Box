<?php

class UAB_Deactivator {
    public static function deactivate() {
        // Optionally, clean up settings
        delete_option('uab_settings');
    }
}

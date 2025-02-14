<?php

class UAB_Admin_Settings {
    public function __construct() {
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings() {
        register_setting('uab_settings_group', 'uab_settings');

        add_settings_section(
            'uab_main_settings',
            'Main Settings',
            null,
            'ultimate-author-box'
        );

        add_settings_field(
            'enable_author_box',
            'Enable Author Box',
            [$this, 'enable_author_box_callback'],
            'ultimate-author-box',
            'uab_main_settings'
        );

        add_settings_field(
            'border_color',
            'Box Border Color',
            [$this, 'border_color_callback'],
            'ultimate-author-box',
            'uab_main_settings'
        );

        add_settings_field(
            'background_color',
            'Box Background Color',
            [$this, 'background_color_callback'],
            'ultimate-author-box',
            'uab_main_settings'
        );

        // Author Name & Bio Position
        add_settings_field(
            'author_position',
            'Author Avatar Position',
            [$this, 'author_position_callback'],
            'ultimate-author-box',
            'uab_main_settings'
        );

        add_settings_field(
            'box_position',
            'Bio Box Position',
            [$this, 'box_position_callback'],
            'ultimate-author-box',
            'uab_main_settings'
        );

        add_settings_field(
            'paragraph_number',
            'Insert After Paragraph (Only for Inside Content)',
            [$this, 'paragraph_number_callback'],
            'ultimate-author-box',
            'uab_main_settings'
        );
    }

    public function enable_author_box_callback() {
        $options = get_option('uab_settings', []); // Ensure $options is an array
        $enabled = isset($options['enable_author_box']) ? $options['enable_author_box'] : 0; // Check if key exists
    
        echo '<input type="checkbox" name="uab_settings[enable_author_box]" value="1" ' . checked(1, $enabled, false) . '>';
    }
    

    public function border_color_callback() {
        $options = get_option('uab_settings');
        $border_color = isset($options['border_color']) ? $options['border_color'] : '';
        echo '<input type="text" id="uab_author_box_border_color" name="uab_settings[border_color]" value="' . esc_attr($border_color) . '" class="uab-color-picker">';
    }
    public function background_color_callback() {
        $options = get_option('uab_settings');
        echo '<input type="text" id="uab_author_box_bg_color" name="uab_settings[background_color]" value="' . esc_attr($options['background_color']) . '" class="uab-color-picker">';
    }

    public function author_position_callback() {
        $options = get_option('uab_settings');
        $selected = isset($options['author_position']) ? esc_attr($options['author_position']) : 'inline';

        $positions = [
            'inline' => 'Inline',
            'top'    => 'Top',
            'bottom' => 'Bottom',
            'left'   => 'Left',
            'right'  => 'Right'
        ];

        echo '<select name="uab_settings[author_position]">';
        foreach ($positions as $value => $label) {
            echo '<option value="' . esc_attr($value) . '" ' . selected($selected, $value, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }

    public function box_position_callback() {
        $options = get_option('uab_settings');
        $positions = ['before', 'inside', 'after'];

        echo '<select name="uab_settings[box_position]">';
        foreach ($positions as $position) {
            echo '<option value="' . esc_attr($position) . '" ' . selected($options['box_position'], $position, false) . '>' . ucfirst($position) . '</option>';
        }
        echo '</select>';
    }

    public function paragraph_number_callback() {
        $options = get_option('uab_settings', []);
        $paragraph = isset($options['paragraph_number']) ? intval($options['paragraph_number']) : 2;

        echo '<input type="number" name="uab_settings[paragraph_number]" value="' . esc_attr($paragraph) . '" min="1">';
        echo '<p class="description">Enter the paragraph number after which the author box should appear.</p>';
    }

  
}

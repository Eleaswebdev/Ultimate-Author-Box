<?php

class UAB_Admin_Settings {
    public function __construct() {
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_init', [$this, 'register_style_settings']);
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

        // add_settings_field(
        //     'border_color',
        //     'Box Border Color',
        //     [$this, 'border_color_callback'],
        //     'ultimate-author-box',
        //     'uab_main_settings'
        // );

        // add_settings_field(
        //     'background_color',
        //     'Box Background Color',
        //     [$this, 'background_color_callback'],
        //     'ultimate-author-box',
        //     'uab_main_settings'
        // );

        add_settings_field(
            'social_links',
            'Author Social Links',
            [$this, 'social_links_callback'],
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

    public function register_style_settings() {
        register_setting('uab_style_settings_group', 'uab_style_settings');

        add_settings_section(
            'uab_style_settings',
            'Elements Style',
            null,
            'uab-elements-style'
        );

        add_settings_field(
            'border_color',
            'Box Border Color',
            [$this, 'border_color_callback'],
            'uab-elements-style',
            'uab_style_settings'
        );

        add_settings_field(
            'background_color',
            'Box Background Color',
            [$this, 'background_color_callback'],
            'uab-elements-style',
            'uab_style_settings'
        );

        add_settings_field(
            'author_image_width',
            'Author Image Width',
            [$this, 'author_image_width_callback'],
            'uab-elements-style',
            'uab_style_settings'
        );

        add_settings_field(
            'padding',
            'Box Padding',
            [$this, 'padding_callback'],
            'uab-elements-style',
            'uab_style_settings'
        );

        add_settings_field(
            'margin',
            'Box Margin',
            [$this, 'margin_callback'],
            'uab-elements-style',
            'uab_style_settings'
        );

        add_settings_field(
            'typography',
            'Typography (Font Size, Family)',
            [$this, 'typography_callback'],
            'uab-elements-style',
            'uab_style_settings'
        );

        add_settings_field(
            'text_color',
            'Text Color',
            [$this, 'text_color_callback'],
            'uab-elements-style',
            'uab_style_settings'
        );
    }

    public function enable_author_box_callback() {
        $options = get_option('uab_settings', []); // Ensure $options is an array
        $enabled = isset($options['enable_author_box']) ? $options['enable_author_box'] : 0; // Check if key exists
    
        echo '<input type="checkbox" name="uab_settings[enable_author_box]" value="1" ' . checked(1, $enabled, false) . '>';
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

    public function social_links_callback() {
        $options = get_option('uab_settings', []);
        $social_links = isset($options['social_links']) ? $options['social_links'] : [];
        
        echo '<div id="uab-social-links-container">';
        
        if (!empty($social_links)) {
            foreach ($social_links as $index => $social) {
                $url = esc_url($social['url']);
                $icon = esc_attr($social['icon']);
                echo '<div class="uab-social-link">';
                echo '<input type="text" name="uab_settings[social_links][' . $index . '][icon]" placeholder="(e.g., fa-facebook)" value="' . $icon . '">';
                echo '<input type="text" name="uab_settings[social_links][' . $index . '][url]" placeholder="Social Link URL" value="' . $url . '">';
                echo '<button type="button" class="remove-social-link">Remove</button>';
                echo '</div>';
            }
        }

        echo '</div>';
        echo '<button type="button" id="add-social-link">Add Social Link</button>';

        ?>
        <?php
    }

    public function border_color_callback() {
        $options = get_option('uab_style_settings');
        $border_color = isset($options['border_color']) ? $options['border_color'] : '';
        echo '<input type="text" name="uab_style_settings[border_color]" value="' . esc_attr($border_color) . '" class="uab-color-picker">';
    }

    public function background_color_callback() {
        $options = get_option('uab_style_settings');
        $bg_color = isset($options['background_color']) ? $options['background_color'] : '';
        echo '<input type="text" name="uab_style_settings[background_color]" value="' . esc_attr($bg_color) . '" class="uab-color-picker">';
    }

    public function author_image_width_callback() {
        $options = get_option('uab_style_settings');
        $width = isset($options['author_image_width']) ? $options['author_image_width'] : 100; // Default width 100px
        ?>
        <input type="range" id="author_image_width" name="uab_style_settings[author_image_width]" min="50" max="200" value="<?php echo esc_attr($width); ?>" oninput="document.getElementById('author_image_width_value').innerText = this.value + 'px'">
        <span id="author_image_width_value"><?php echo esc_attr($width); ?>px</span>
        <?php
    }
    

    public function padding_callback() {
        $options = get_option('uab_style_settings', []);
        $padding = isset($options['padding']) ? esc_attr($options['padding']) : '10px';
        echo '<input type="text" name="uab_style_settings[padding]" value="' . esc_attr($padding) . '" placeholder="e.g. 10px 15px">';
    }

    public function margin_callback() {
        $options = get_option('uab_style_settings', []);
        $margin = isset($options['margin']) ? esc_attr($options['margin']) : '10px';
        echo '<input type="text" name="uab_style_settings[margin]" value="' . esc_attr($margin) . '" placeholder="e.g. 10px 15px">';
    }

    public function typography_callback() {
        $options = get_option('uab_style_settings', []);
        $typography = isset($options['typography']) ? esc_attr($options['typography']) : '16px Arial, sans-serif';
        echo '<input type="text" name="uab_style_settings[typography]" value="' . esc_attr($typography) . '" placeholder="e.g. 16px Arial">';
    }

    public function text_color_callback() {
        $options = get_option('uab_style_settings');
        $text_color = isset($options['text_color']) ? $options['text_color'] : '';
        echo '<input type="text" name="uab_style_settings[text_color]" value="' . esc_attr($text_color) . '" class="uab-color-picker">';
    }

  
}

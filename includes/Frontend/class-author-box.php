<?php

class UAB_Author_Box {
    public function __construct() {
        add_filter('the_content', [$this, 'display_author_box']);
    }

    // Main function to display the author box
    public function display_author_box($content) {
        if (!$this->should_display_author_box()) {
            return $content;
        }

        $author_box = $this->get_author_box_html();
        $box_position = $this->get_author_box_position();

        // Insert the author box based on position
        if ($box_position === 'before') {
            return $author_box . $content;
        } elseif ($box_position === 'inside') {
            return $this->insert_after_paragraph($author_box, $this->get_paragraph_number(), $content);
        } else {
            return $content . $author_box;
        }
    }

    // Helper function to check if author box should be displayed
    private function should_display_author_box() {
        $settings = get_option('uab_settings');
        return is_single() && !empty($settings['enable_author_box']);
    }

    // Helper function to get the author box HTML
    private function get_author_box_html() {
        $settings = get_option('uab_settings');
        global $post;
        $author_id = $post->post_author;
        $author_name = get_the_author_meta('display_name', $author_id);
        $author_bio = get_the_author_meta('description', $author_id);
        // Get custom uploaded image or fallback to default avatar
        $custom_author_image = get_the_author_meta('uab_author_image', $author_id);
        if ($custom_author_image) {
            $author_avatar = '<img src="' . esc_url($custom_author_image) . '" alt="' . esc_attr($author_name) . '" class="uab-custom-avatar">';
        } else {
            $author_avatar = get_avatar($author_id, 100);
        }
        $social_links = isset($settings['social_links']) ? $settings['social_links'] : [];
        $position = isset($settings['author_position']) ? esc_attr($settings['author_position']) : 'inline';

        ob_start(); // Start output buffering
        ?>
        <div class="uab-author-box uab-position-<?php echo esc_attr($position); ?>">
            <?php $this->build_author_box_content($author_name, $author_bio, $author_avatar, $social_links, $position); ?>
        </div>
        <?php
        return ob_get_clean(); // Get buffered output
    }

    // Helper function to build the author box content based on position
    private function build_author_box_content($author_name, $author_bio, $author_avatar, $social_links, $position) {
        if ($position === 'inline') {
            echo '<div class="uab-avatar">' . $author_avatar . '</div>';
            echo '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3>';
            if (!empty($social_links)) {
                echo '<div class="uab-social-links">';
                foreach ($social_links as $link) {
                    echo '<a href="' . esc_url($link['url']) . '" target="_blank"><i class="fab ' . esc_attr($link['icon']) . '"></i></a>';
                }
                echo '</div>';
            }
            echo '<p>' . esc_html($author_bio) . '</p></div>';
        } elseif ($position === 'top') {
            echo '<div class="uab-avatar">' . $author_avatar . '</div>';
            echo '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3>';
            echo '<p>' . esc_html($author_bio) . '</p></div>';
        } elseif ($position === 'bottom') {
            echo '<p>' . esc_html($author_bio) . '</p>';
            echo '<div class="uab-avatar">' . $author_avatar . '</div>';
            echo '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3></div>';
        } elseif ($position === 'left') {
            echo '<div class="uab-flex">';
            echo '<div class="uab-avatar">' . $author_avatar . '</div>';
            echo '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3>';
            echo '<p>' . esc_html($author_bio) . '</p></div>';
            echo '</div>';
        } elseif ($position === 'right') {
            echo '<div class="uab-flex">';
            echo '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3>';
            echo '<p>' . esc_html($author_bio) . '</p></div>';
            echo '<div class="uab-avatar">' . $author_avatar . '</div>';
            echo '</div>';
        }
    }

    // Helper function to get the position of the author box (before, inside, or after content)
    private function get_author_box_position() {
        $settings = get_option('uab_settings');
        return isset($settings['box_position']) ? esc_attr($settings['box_position']) : 'after';
    }

    // Helper function to get the paragraph number where the box should be inserted (for "inside" position)
    private function get_paragraph_number() {
        $settings = get_option('uab_settings');
        return isset($settings['paragraph_number']) ? intval($settings['paragraph_number']) : 2;
    }

    

    private function insert_after_paragraph($insert, $paragraph_id, $content) {
        $paragraphs = explode('</p>', $content);
        $total_paragraphs = count($paragraphs);

        if ($total_paragraphs < $paragraph_id) {
            // If the selected paragraph number is greater, place it after the last paragraph
            $paragraph_id = $total_paragraphs;
        }

        foreach ($paragraphs as $index => $paragraph) {
            if (trim($paragraph)) {
                $paragraphs[$index] .= '</p>';
            }
            if ($index + 1 == $paragraph_id) {
                $paragraphs[$index] .= $insert;
            }
        }

        return implode('', $paragraphs);
    }
}

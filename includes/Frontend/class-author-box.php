<?php

class UAB_Author_Box {
    public function __construct() {
        add_filter('the_content', [$this, 'display_author_box']);
    }

    public function display_author_box($content) {

        $settings = get_option('uab_settings');
        if (!is_single() || empty($settings['enable_author_box'])) {
            return $content;
        }
        global $post;
        $author_id = $post->post_author;
        $author_name = get_the_author_meta('display_name', $author_id);
        $author_bio = get_the_author_meta('description', $author_id);
        $author_avatar = get_avatar($author_id, 100);
        $settings = get_option('uab_settings');
        $border_color = isset($settings['border_color']) ? esc_attr($settings['border_color']) : '#ffffff';
        $bg_color = isset($settings['background_color']) ? esc_attr($settings['background_color']) : '#ffffff';
        $position = isset($settings['author_position']) ? esc_attr($settings['author_position']) : 'inline';
        $box_position = isset($settings['box_position']) ? esc_attr($settings['box_position']) : 'after';
        $paragraph_number = isset($settings['paragraph_number']) ? intval($settings['paragraph_number']) : 2;

        // Start author box
        $author_box = '<div class="uab-author-box uab-position-' . esc_attr($position) . '">';

        // Adjust position layout
        if ($position === 'inline') {
            $author_box .= '<div class="uab-avatar">' . $author_avatar . '</div>';
            $author_box .= '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3>';
            $author_box .= '<p>' . esc_html($author_bio) . '</p></div>';
        } elseif ($position === 'top') {
            
            $author_box .= '<div class="uab-avatar">' . $author_avatar . '</div>';
            $author_box .= '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3></div>';
            $author_box .= '<p>' . esc_html($author_bio) . '</p>';
        } elseif ($position === 'bottom') {
            $author_box .= '<p>' . esc_html($author_bio) . '</p>';
            $author_box .= '<div class="uab-avatar">' . $author_avatar . '</div>';
            $author_box .= '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3></div>';
        } elseif ($position === 'left') {
            $author_box .= '<div class="uab-flex">';
            $author_box .= '<div class="uab-avatar">' . $author_avatar . '</div>';
            $author_box .= '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3>';
            $author_box .= '<p>' . esc_html($author_bio) . '</p></div>';
            $author_box .= '</div>';
        } elseif ($position === 'right') {
            $author_box .= '<div class="uab-flex">';
            $author_box .= '<div class="uab-info"><h3>' . esc_html($author_name) . '</h3>';
            $author_box .= '<p>' . esc_html($author_bio) . '</p></div>';
            $author_box .= '<div class="uab-avatar">' . $author_avatar . '</div>';
            $author_box .= '</div>';
        }

        $author_box .= '</div>';

            // Place the author box according to the selected position
        if ($box_position === 'before') {
            return $author_box . $content;
        } elseif ($box_position === 'inside') {
            return $this->insert_after_paragraph($author_box, $paragraph_number, $content);
        } else {
            return $content . $author_box;
        }
       
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

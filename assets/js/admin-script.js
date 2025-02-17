jQuery(document).ready(function ($) {
    //alert('Hello World');
    $('.uab-color-picker').wpColorPicker();

    let $container = $('#uab-social-links-container');
    let $addButton = $('#add-social-link');

    $addButton.on('click', function() {
        let index = $container.children().length;
        let $newField = $('<div class="uab-social-link"></div>');
        $newField.html(`
            <input type="text" name="uab_settings[social_links][${index}][icon]" placeholder="e.g., fa-facebook">
            <input type="text" name="uab_settings[social_links][${index}][url]" placeholder="Social Link URL">
            <button type="button" class="remove-social-link">Remove</button>
        `);
        $container.append($newField);
    });

    $container.on('click', '.remove-social-link', function() {
        $(this).parent().remove();
    });
});

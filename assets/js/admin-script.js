jQuery( document ).ready(
	function ($) {
		// alert('Hello World');
		$( '.uab-color-picker' ).wpColorPicker();

		let $container = $( '#uab-social-links-container' );
		let $addButton = $( '#add-social-link' );

		$addButton.on(
			'click',
			function () {
				let index         = $container.children().length;
				let $newField     = $( '<div class="uab-social-link"></div>' );
				$newField.html(
					`
					< input type  = "text" name = "uab_settings[social_links][${index}][icon]" placeholder = "e.g., fa-facebook" >
					< input type  = "text" name = "uab_settings[social_links][${index}][url]" placeholder = "Social Link URL" >
					< button type = "button" class = "remove-social-link" > Remove < / button >
					`
				);
				$container.append( $newField );
			}
		);

		$container.on(
			'click',
			'.remove-social-link',
			function () {
				$( this ).parent().remove();
			}
		);

		// User Profile image upload js
		var mediaUploader;

		$( '#uab-upload-button' ).click(
			function (e) {
				e.preventDefault();
				if (mediaUploader) {
					mediaUploader.open();
					return;
				}
				mediaUploader = wp.media(
					{
						title: 'Choose Profile Image',
						button: {
							text: 'Select Image'
						},
						multiple: false
					}
				);

				mediaUploader.on(
					'select',
					function () {
						var attachment = mediaUploader.state().get( 'selection' ).first().toJSON();
						$( '#uab_author_image' ).val( attachment.url );
						$( '#uab-image-preview' ).html( '<img src="' + attachment.url + '" style="max-width: 150px; display: block;" />' );
						$( '#uab-remove-button' ).show();
					}
				);

				mediaUploader.open();
			}
		);

		$( '#uab-remove-button' ).click(
			function () {
				$( '#uab_author_image' ).val( '' );
				$( '#uab-image-preview' ).html( '' );
				$( this ).hide();
			}
		);
	}
);

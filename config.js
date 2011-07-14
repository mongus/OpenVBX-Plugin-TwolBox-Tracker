$(function() {
	$('#submit-button').click(function() {
		var $message = $('#ajax-response').empty().removeClass().html('Saving Settings <img src="'+base_url+'assets/i/ajax-loader.gif" alt="">').show();

		$('input.invalid').removeClass('invalid');

		var data = $(this).closest('form').serialize();

		$.post('', data, function(data) {
			if (typeof data === 'string')
				data = $.parseJSON(data);

			$message.empty();

			if (data.message)
				$message.html(data.message);

			if (data.errors) {
				$message.addClass('error');

				for (var i = 0; i < data.errors.length; i++) {
					var error = data.errors[i];
					$message.append('<div class="'+(i == 0 ? ' first' : '')+'">'+error.message+'</div>');
					$(':input[name='+error.field+']').addClass('invalid');
				}

				$(':input.invalid').first().focus();
			}
			else {
				setTimeout(function() {
					$message.slideUp();
				}, 5000);
			}

			$message.show();
		}, 'text');

		return false;
	});
});

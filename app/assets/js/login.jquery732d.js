jQuery(function() {
	Doc.on('submit', 'form[name="login_form"]', function() {
		var tthis = jQuery(this)
		  , action = tthis.attr('action')
		  , username = jQuery('> input[name="username"]', tthis).val()
		  , password = jQuery('> input[name="password"]', tthis).val();

		Global.mask('show');

		jQuery.post(action, { username : username , password : password }, function(data) {
			Global.mask('hide');
			
			if (data.error) {
				Err.new(data.message);
			} else {
				Err.new(data.message, 'success');
				Global.reload();
			}
		}, 'json');

		return false;
	});
});
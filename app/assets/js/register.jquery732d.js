jQuery(function() {
	// Puissance du mdp
	var PDMDP = {
		check: function(string) {
			var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g")
			  , mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g")
			  , okRegex = new RegExp("(?=.{6,}).*", "g");

			if (string == '') {
				PDMDP.set_level(0);
			} else if (okRegex.test(string) === false) {
				PDMDP.set_level(1);
			} else if (strongRegex.test(string)) {
				PDMDP.set_level(3);
			} else if (mediumRegex.test(string)) {
				PDMDP.set_level(2);
			} else {
				PDMDP.set_level(1);
			} 
		},
		set_level: function(level) {
			jQuery('.line.PDMDP > .level').removeClass('green');

			if (level == 1) {
				jQuery('.line.PDMDP > .level.nul').addClass('green');
			} else if (level == 2) {
				jQuery('.line.PDMDP > .level.nul').addClass('green');
				jQuery('.line.PDMDP > .level.moyen').addClass('green');
			} else if (level == 3) {
				jQuery('.line.PDMDP > .level.nul').addClass('green');
				jQuery('.line.PDMDP > .level.moyen').addClass('green');
				jQuery('.line.PDMDP > .level.badass').addClass('green');
			}
		}
	}

	// On lance le check du MDP quand on tape dans l'input prévu à cet effet
	jQuery(document).on('keyup', '#PDMDP_input', function() {
		var val = jQuery(this).val();

		PDMDP.check(val);
	});

	// Valider formulaire
	Doc.on('submit', 'form[name="register"]', function() {
		var tthis = jQuery(this)
		  , action = tthis.attr('action')
		  , username = jQuery('input[name="username"]').val()
		  , password = jQuery('input[name="password"]').val()
		  , password_v = jQuery('input[name="password_v"]').val()
		  , mail = jQuery('input[name="mail"]').val()
		  , gender;

		if (jQuery('input[type="radio"][value="M"').is(':checked')) {
			gender = 'M';
		} else if (jQuery('input[type="radio"][value="F"').is(':checked')) {
			gender = 'F';
		} else {
			gender = null;
		}

		Global.mask('show');

		jQuery.post(action, { username : username , password : password , password_v : password_v , mail : mail , gender : gender }, function(data) {
			Global.mask('hide');

			if (data.error) {
				Err.new(data.message);
			} else {
				Err.new(data.message, 'success');
				Global.redirect('/home');
			}
		}, 'json');

		return false;
	});
});
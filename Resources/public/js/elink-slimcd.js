var eLinkSlimCD = {
	data: {
		"ver": "1.0",
		"transtype": "LOAD"
	},

	successCallback: function(token) {},
	defaultCallback: function() {},
	errorCallback: function() {},

	setCallbacks: function(successCallback, defaultCallback, errorCallback) {
		this.successCallback = successCallback;
		this.defaultCallback = defaultCallback;
		this.errorCallback = errorCallback;
		return this;
	},

	tokenizeCard: function(data) {
		this.data = jQuery.extend(this.data, {
			"username": data.username,
			"password": data.password,
			"amount": data.amount
		});

		if (data.method == 'echeck') {
			// Tokenization not yet supported

			/*this.data = jQuery.extend(this.data, {
			 "accountno": '',
			 "routno": ''
			 });*/
			return this.defaultCallback();
		} else if (data.method == 'check') {
			return this.defaultCallback();
		} else {
			this.data = jQuery.extend(this.data, {
				"cardnumber": data.cardnumber,
				"expmonth": data.expmonth,
				"expyear": data.expyear,
				"cvv": data.cvv || ''
			});
		}

		jQuery.support.cors = true;
		jQuery.ajax({
			type: 'POST',
			url: 'https://trans.slimcd.com/soft/json/jsonpayment.asp',
			crossDomain: true,
			timeout: 60000,
			contentType: "application/json",
			dataType: 'jsonp',
			data: this.data,
			success: function (responseData, textStatus) {
				if (responseData.reply.response == 'Success') {
					// gateid = token to pass to SALE transtype on the server
					eLinkSlimCD.successCallback(responseData.reply.datablock.gateid);
				} else {
					eLinkSlimCD.errorCallback(responseData, textStatus);
				}
			},
			error: this.errorCallback
		});
	},

	translateErrorMessages: function(description) {
		// Example: *--NEED_EXPMONTH--NEED_EXPYEAR--NEED_CARDNUMBER.
		var translated = '';

		if (description.indexOf('NEED_CARDNUMBER') >= 0) {
			translated += 'Please enter your card number.';
		}

		if (description.indexOf('NEED_EXPMONTH') >= 0 || description.indexOf('NEED_EXPYEAR') >= 0) {
			translated += "Please check your card expiration month and year.\n";
		} else if (description.indexOf('MOD10_FAILED_OR_CARDEXPIRED') >= 0) {
			translated += "Please check your card number and expiration date.\n";
		}

		if (description.indexOf('CVV') >= 0) {
			translated += 'Please verify that you have entered the correct CVV code.';
		}

		if (translated.length == 0) {
			translated = 'Please check that you have entered your payment information correctly, then try again.';
		}

		return translated;
	}
};
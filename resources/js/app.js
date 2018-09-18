require('./bootstrap');

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function () {

	Echo.channel('parkingSpots')
	    .listen('ParkingSpotReserved', (e) => {
	    	$('#parking-spot-' + e.parkingSpot).addClass('taken');
	    })
	    .listen('ParkingSpotAvailable', (e) => {
	    	$('#parking-spot-' + e.parkingSpot).removeClass('taken');
	    });

	$(document).on('click', '[data-toggle="section"]', function () {
		showSection($(this).attr('data-section'));
	});

	$(document).on('click', '.parking-spot', function () {
		if($(this).hasClass('taken')) {
			return;
		}

		if($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			$('button#parking-selected').hide();
			return;
		}

		$('.parking-spot').removeClass('selected');
		$(this).addClass('selected');
		$('button#parking-selected').show();
	});

	$(document).on('click', 'button#parking-selected', function () {
		$.ajax({
			method: 'POST',
			url: ticketSubmitUrl, // defined from AppController
			dataType: 'json',
			data: {
				code: $('.parking-spot.selected').find('.spot-number').first().text()
			}
		})
		.done(function (response) {
			var ticket = $('section#ticket');
			ticket.find('#ticket-parking-spot').text(response.parking_spot_code);
			ticket.find('#ticket-barcode-text').text(response.ticket_code);
			ticket.find('img#ticket-barcode').attr('src', response.barcode_url);
			showSection('ticket');
		})
		.fail(function (response) {
			showError(response);
		});
	});

	$(document).on('click', '.refresh-app', function () {
		location.reload();
	});

	$(document).on('keyup change', '#ticket-code-input', function () {
		if(!$(this).val()) {
			$('#scan-ticket-button').hide();
		}
		else {
			$('#scan-ticket-button').show();
		}
	});

	var ticketCode;
	$(document).on('click', 'button#scan-ticket-button', function () {
		ticketCode = $('#ticket-code-input').val();
		$.ajax({
			method: 'GET',
			url: ticketGetUrl + '/' + ticketCode, // defined from AppController
			dataType: 'json'
		})
		.done(function (response) {
			$('#stay-duration').text(new Date(response.stay_duration * 1000).toISOString().substr(11, 8));
			$('#balance-owed').text('$' + response.amount_due.toFixed(2));
			showSection('pay-ticket');
		})
		.fail(function (response) {
			showError(response);
		});
	});

	$(document).on('click', 'button#pay-ticket-button', function () {
		$.ajax({
			method: 'POST',
			url: ticketPayUrl + '/' + ticketCode, // defined from AppController
			dataType: 'json',
			data: {} // TODO: should probably accept actual payment info at some point
		})
		.done(function (response) {
			location.reload();
		})
		.fail(function (response) {
			showError(response);
		});
	});
});

function showSection(sectionID) {
	$('section:not(#' + sectionID + ')').hide();
	$('section#' + sectionID).fadeIn(500);
}

function showError(error) {
	if(error.hasOwnProperty('responseJSON')) {
		if(error.responseJSON.hasOwnProperty('message')) {
			showErrorPopup(error.responseJSON.message);
			return;
		}
	}

	showErrorPopup('An error occurred.');
}

function showErrorPopup(error) {
	$('.error-popup span').text(error);
	$('.error-popup').fadeIn('slow', function () {
		setTimeout(function () {
			$('.error-popup').fadeOut('slow');
		}, 1200);
	});
}
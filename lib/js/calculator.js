jQuery(document).ready(function ($) {

	if ($('.page-template-calculator-template').length > 0) {

		var calculate_posts = function (runs, length, usage, corners, fixing, fixingDig ) {

			var new_posts = 0;

			if (length === '') {
				length = 0;
			}

			if (corners === '') {
				corners = 0;
			}

			if (runs === '') {
// 				runs = 0;
			}
			
			new_posts = Math.ceil(length / usage) + (Number(runs) + parseInt(corners));
			$( '.results #posts' ).val( new_posts );
			$('.wpcf7-form input[name=posts]').val(new_posts);

			return new_posts;
		};

		var calculate_beams = function(length,usage,beams) {

		  var new_beams = 0;

		  if( length === "") {
			length = 0;
		  }

		  if (beams === "Single") {
			new_beams = Math.ceil( ((length / 3.2)) * 1 );
		  } else {
			new_beams = Math.ceil( ((length / 3.2)) * 2 );
		  }

		  $('.results #beams').val(new_beams);
		  $('.results #lap-bolts').val(new_beams);

		  $('.wpcf7-form input[name=beams]').val(new_beams);

		  var  str2="Handrail Ext";
		  if (fixing.indexOf(str2) > -1 || fixingDig.indexOf(str2) > -1) {
			if (beams === "Single") {
				$('.results #handrails').val(new_beams);
				$('.wpcf7-form input[name=post-handrails]').val(new_beams);
			} else {

				$('.results #handrails').val(Math.ceil( ((new_beams / 2))));
				$('.wpcf7-form input[name=post-handrails]').val(Math.ceil( ((new_beams / 2))));
			}

		  } else {
			$('.results #handrails').val(0);
			$('.wpcf7-form input[name=post-handrails]').val("0");
		  }

		  return new_beams;
		};

		var calculate_posts_reverse = function (runs, length, usage, beams, corners, end_type, fixing, fixingDig, postType, newPosts) {

			if (corners === '') {
				corners = 0;
			}

			length = Math.ceil(((newPosts - (1 + parseInt(corners))) * usage) - 1);

			$('.product-calculator #length').val(length);

			calculate_post_type();
			calculate_beam_type();
			calculate_post_fixing(fixingDig, fixing);

			calculate_posts(runs, length, usage, corners, fixingDig, fixing );
			calculate_beams(length, usage, beams);

			calculate_post_bolts(runs, length, usage, corners, beams);
			calculate_lap_bolts(length, usage, beams, corners, fixing, fixingDig, end_type, endProtection);
			calculate_floor_anchors(length, usage, corners, fixing, fixingDig);
			calculate_ancillary_items(corners, beams, end_type);
		};

		var calculate_beams_reverse = function (runs, length, usage, beams, corners, end_type, fixing, fixingDig, postType, newPosts, newBeams) {

			if (beams === "Single" || beams === "Double") {
				length = Math.ceil(((newBeams / 1) * 3.2) - 1);
			} else {
				length = Math.ceil(((newBeams / 2) * 3.2) - 1);
			}

			$('.product-calculator #length').val(length);

			calculate_post_type();
			calculate_beam_type();
			calculate_post_fixing(fixingDig, fixing);

			calculate_posts(runs, length, usage, corners, fixingDig, fixing );
			calculate_beams(length, usage, beams);

			calculate_post_bolts(runs, length, usage, corners, beams);
			calculate_lap_bolts(length, usage, beams, corners, fixing, fixingDig, end_type, endProtection);
			calculate_floor_anchors(length, usage, corners, fixing, fixingDig);
			calculate_ancillary_items(corners, beams, end_type);
		};

		var calculate_ancillary_items = function (corners, beams, end_type) {

			var beams_no = 0;
			if (beams === "Single" || beams === "Double") {
				beams_no = 1;
			} else {
				beams_no = 2;
			}

			if (corners === '') {
				corners = 0;
			}

			if ((corners * beams_no) === 1) {
				if (end_type === 'No End') {
					$('#barrier-corners').val('1 Corner');
				} else {
					$('#barrier-corners').val('1 Corner');
					$('#end-protection').val('' + end_type + ' Ends');
					$('.results #old-end-protection').val(1);
				}
			} else if ((corners * beams_no) >= 2) {

				if (end_type === 'No End') {
					$('#barrier-corners').val('' + (corners * beams_no) + ' Corners');
					$('.wpcf7-form input[name=angle-pieces]').val((corners * beams_no));
				} else {
					$('#barrier-corners').val('' + (corners * beams_no) + ' Corners');
					$('#end-protection').val('' + (2 * beams_no) + ' ' + end_type + ' Ends');
					$('.results #old-end-protection').val(2 * beams_no);
					$('.wpcf7-form input[name=angle-pieces]').val((corners * beams_no));

					switch (end_type) {
						case 'Fish Tail':
							// $('.wpcf7-form input[name=fish-ends]').val((2 * beams_no));
							// $('.wpcf7-form input[name=ped-ends]').val(0);
							// $('.wpcf7-form input[name=cap-ends]').val(0);
							// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
							$('.results #old-end-protection').val(2 * beams_no);
							break;
						case 'Pedestrian':
							// $('.wpcf7-form input[name=ped-ends]').val((2 * beams_no));
							// $('.wpcf7-form input[name=fish-ends]').val(0);
							// $('.wpcf7-form input[name=cap-ends]').val(0);
							// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
							$('.results #old-end-protection').val(2 * beams_no);
							break;
						case 'End cap':
							// $('.wpcf7-form input[name=cap-ends]').val((2 * beams_no));
							// $('.wpcf7-form input[name=ped-ends]').val(0);
							// $('.wpcf7-form input[name=fish-ends]').val(0);
							// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
							$('.results #old-end-protection').val(2 * beams_no);
							break;
						case 'Beam Sleeve':
							// $('.wpcf7-form input[name=beam-sleeve-ends]').val((2 * beams_no));
							// $('.wpcf7-form input[name=cap-ends]').val(0);
							// $('.wpcf7-form input[name=ped-ends]').val(0);
							// $('.wpcf7-form input[name=fish-ends]').val(0);
							$('.results #old-end-protection').val(2 * beams_no);
							break;
					}
				}
			} else if (end_type === 'Fish Tail') {

				$('#end-protection').val(' ' + (2 * beams_no) + ' Fish-Tail Ends');
				// $('.wpcf7-form input[name=fish-ends]').val((2 * beams_no));
				// $('.wpcf7-form input[name=ped-ends]').val(0);
				// $('.wpcf7-form input[name=cap-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
				$('.results #old-end-protection').val(2 * beams_no);

			} else if (end_type === 'Pedestrian') {

				$('#end-protection').val(' ' + (2 * beams_no) + ' Pedestrian Ends');
				$('.results #old-end-protection').val(2 * beams_no);
				// $('.wpcf7-form input[name=ped-ends]').val((2 * beams_no));
				// $('.wpcf7-form input[name=fish-ends]').val(0);
				// $('.wpcf7-form input[name=cap-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);

			} else if (end_type === 'End cap') {

				$('#end-protection').val(' ' + (2 * beams_no) + ' End cap Ends');
				$('.results #old-end-protection').val(2 * beams_no);
				// $('.wpcf7-form input[name=cap-ends]').val((2 * beams_no));
				// $('.wpcf7-form input[name=ped-ends]').val(0);
				// $('.wpcf7-form input[name=fish-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);

			} else if (end_type === 'Beams Sleeve') {

				$('#end-protection').val(' ' + (2 * beams_no) + ' Beams Sleeve Ends');
				$('.results #old-end-protection').val(2 * beams_no);
				// $('.wpcf7-form input[name=cap-ends]').val(0);
				// $('.wpcf7-form input[name=ped-ends]').val(0);
				// $('.wpcf7-form input[name=fish-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val((2 * beams_no));

			} else if (end_type === 'No End') {

				$('#end-protection').val('No End Protection');
				$('.results #old-end-protection').val(0);
				// $('.wpcf7-form input[name=cap-ends]').val(0);
				// $('.wpcf7-form input[name=ped-ends]').val(0);
				// $('.wpcf7-form input[name=fish-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
			}
		};

		var calculate_post_bolts = function(runs, length,usage,corners,beams) {

		  var beams_no = 0;
		  var new_post_bolts = 0;

		  if( length === "") {
			length = 0;
		  }

		  if(corners === "") {
			corners = 0;
		  }

		  if(runs === "") {
// 			runs = 0;
		  }

		  if (beams === "Single") {
			beams_no = 1;
		  } else {
			beams_no = 2;
		  }

		  if (parseInt(length) > 0) {
			new_post_bolts = ( Math.ceil(length / usage) + (Number(runs) + parseInt(corners)) ) * parseInt(beams_no);
		  } 

		  if (new_post_bolts === $('.results #post-bolts').val()) {
			$('.results #post-bolts').removeClass('changed');
		  } else {
			$('.results #post-bolts').addClass('changed');
			$('.results #post-bolts').val(new_post_bolts);
		  }
		  $('.wpcf7-form input[name=post-bolts]').val(new_post_bolts);
		  return new_post_bolts;
		};

		var calculate_lap_bolts = function (length, usage, beams, corners, fixing, end_type, endProtection) {
			var beams_no = 0;

			if (beams === "Single") {
				beams_no = 1;
			} else {
				beams_no = 2;
			}

			if (corners === '') {
				corners = 0;
			}

			if (length === '') {
				length = 0;
			}

			var no_of_beams = Math.ceil((length / 3.2) * beams_no);
			var new_lap_bolts = ((no_of_beams * 8) + ((corners * beams_no) * 8));
			if ((endProtection === 'Fish Tail') || (endProtection === 'Pedestrian')) {
				new_lap_bolts += (16 * beams_no);
			}
			// if (new_lap_bolts === $('.results #lap-bolts').val()) {
			// 	$('.results #lap-bolts').removeClass('changed');
			// } else {
			// 	$('.results #lap-bolts').addClass('changed');
			// 	$('.results #lap-bolts').val(new_lap_bolts);
			// }
			$('.wpcf7-form input[name=lap-bolts]').val(new_lap_bolts);
			return new_lap_bolts;
		};

		var calculate_floor_anchors = function (length, usage, corners) {

			var anchor_bolts = 0;
			var no_of_posts = 0;
			var fixingType = $('.results #post-fixing').val();
			var boltDown = "Bolt Down";

			if (length === '') {
				length = 0;
			}

			if (corners === '') {
				corners = 0;
			}

			if (fixingType.indexOf(boltDown) > -1) {

				if (parseInt(length) > 0) {
					no_of_posts = (Math.ceil(length / usage) + (1 + parseInt(corners)));
				}
				anchor_bolts += (4 * no_of_posts);
			}

			// if (anchor_bolts === $('.results #floor-anchors').val()) {

			// 	$('.results #floor-anchors').removeClass('changed');
			// } else {
			// 	$('.results #floor-anchors').val(anchor_bolts);
			// }

			if (fixingType.indexOf(boltDown) > -1) {

				$('.wpcf7-form input[name=anchor-bolts]').val(anchor_bolts);
			} else {
				$('.wpcf7-form input[name=anchor-bolts]').val(0);
			}

			return anchor_bolts;
		};

		var calculate_post_type = function () {
			$('.wpcf7-form input[name=post-type]').val(postType);
			$('.results #post-type').val(postType);
			return postType;
		};

		var calculate_post_fixing = function (fixingDig, fixing) {

			$('#digin-radio').click(function () {
				$('.fixings-dig').css('display', 'block');
				$('.fixings-bolt').css('display', 'none');
				$('#fixings-bolt').val('Bolt Down (760mm)');

				if ($('#digin-radio').is(':checked')) {
					$('.wpcf7-form input[name=post-fixing]').val(fixingDig);
					$('.results #post-fixing').val(fixingDig);
				} else if ($('#boltdown-radio').is(':checked')) {
					$('.wpcf7-form input[name=post-fixing]').val(fixing);
					$('.results #post-fixing').val(fixing);
				}
			});

			$('#boltdown-radio').click(function () {
				$('.fixings-bolt').css('display', 'block');
				$('.fixings-dig').css('display', 'none');
				$('#fixings-dig').val('Dig In (1200mm)');

				if ($('#boltdown-radio').is(':checked')) {
					$('.wpcf7-form input[name=post-fixing]').val(fixing);
					$('.results #post-fixing').val(fixing);
				} else if ($('#digin-radio').is(':checked')) {
					$('.wpcf7-form input[name=post-fixing]').val(fixingDig);
					$('.results #post-fixing').val(fixingDig);
				}
			});

			if ($('#digin-radio').is(':checked')) {
				$('.wpcf7-form input[name=post-fixing]').val(fixingDig);
				$('.results #post-fixing').val(fixingDig);
			} else if ($('#boltdown-radio').is(':checked')) {
				$('.wpcf7-form input[name=post-fixing]').val(fixing);
				$('.results #post-fixing').val(fixing);
			}
		};

		var calculate_beam_type = function () {
			$('.wpcf7-form input[name=beam-type]').val(beams);
			$('.results #beam-type').val(beams);
			return beams;
		};

		var calculate_product_coating = function () { //new
			var beamCoated = "";
			var postCoated = "";
			var accessoriesCoated = "";
			var allCoated = "";
			var outputCoatings = "";

			if ($('.product-calculator #Beams-Finishing').is(':checked') === true) {
				beamCoated = "Powder Coated Beams";
			} else {
				beamCoated = "Galvanised Beams";
			}

			if ($('.product-calculator #Posts-Finishing').is(':checked') === true) {
				postCoated = "Powder Coated Posts";
			} else {
				postCoated = "Galvanised Posts";
			}

			if ($('.product-calculator #Accessories-Finishing').is(':checked') === true) {
				accessoriesCoated = "Powder Coated End Protection";
			} else {
				accessoriesCoated = "Galvanised End Protection";
			}

			if ($('.product-calculator #All-Finishing').is(':checked') === true) {
				allCoated = 'All Powder Coated';
				beamCoated = '';
				postCoated = '';
				accessoriesCoated = '';
			}

			if (allCoated === 'All Powder Coated') {
				outputCoatings = allCoated;
				$('.wpcf7-form input[name=finishing]').val(outputCoatings);
				$('.results #barrier-finish').val(outputCoatings);
			} else {
				outputCoatings = beamCoated + ", " + postCoated + " and " + accessoriesCoated + ".";
				$('.wpcf7-form input[name=finishing]').val(outputCoatings);
				$('.results #barrier-finish').val(outputCoatings);
			}
			return outputCoatings;
		};

		var calculate_end_type = function (corners, beams, end_type, endProtection) {
			switch (end_type) {
				case 'Fish Tail':
					// $('.wpcf7-form input[name=fish-ends]').val('Manually Altered: ' + endProtection);
					// $('.wpcf7-form input[name=ped-ends]').val(0);
					// $('.wpcf7-form input[name=cap-ends]').val(0);
					// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
					break;
				case 'Pedestrian':
					// $('.wpcf7-form input[name=ped-ends]').val('Manually Altered: ' + endProtection);
					// $('.wpcf7-form input[name=fish-ends]').val(0);
					// $('.wpcf7-form input[name=cap-ends]').val(0);
					// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
					break;
				case 'End cap':
					// $('.wpcf7-form input[name=cap-ends]').val('Manually Altered: ' + endProtection);
					// $('.wpcf7-form input[name=ped-ends]').val(0);
					// $('.wpcf7-form input[name=fish-ends]').val(0);
					// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
					break;
				case 'Beam Sleeve':
					// $('.wpcf7-form input[name=beam-sleeve-ends]').val('Manually Altered: ' + endProtection);
					// $('.wpcf7-form input[name=cap-ends]').val(0);
					// $('.wpcf7-form input[name=ped-ends]').val(0);
					// $('.wpcf7-form input[name=fish-ends]').val(0);
					break;
			}
		};

		var set_old_end_protection = function (endProtection) {
			endProtection = endProtection.replace(/\D/g, '');
			$('.results #old-end-protection').val(endProtection);
		};

		var calculate_lap_bolts_reverse = function ( lapBolts, endProtection, end_type ) {
			var oldEndType = $('.results #old-end-protection').val();
			endProtection = endProtection.replace(/\D/g, '');

			var lapMath1 = oldEndType - endProtection;
			var lapMath2 = lapMath1 * 8;
			var lapMath3 = lapMath2 * -1;
			lapBolts = Math.ceil((parseInt(lapBolts)) + (parseInt(lapMath3)));

			//$('.results #lap-bolts').val(lapBolts);
			$('.wpcf7-form input[name=lap-bolts]').val(lapBolts);
			$('.results #old-end-protection').val(endProtection);

			if (end_type === 'Fish Tail') {
				// $('.wpcf7-form input[name=fish-ends]').val(endProtection + " Fish Tail Ends");
				// $('.wpcf7-form input[name=ped-ends]').val(0);
				// $('.wpcf7-form input[name=cap-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);				
			} else if (end_type === 'Pedestrian') {
				// $('.wpcf7-form input[name=ped-ends]').val(endProtection + " Pedestrian Ends");
				// $('.wpcf7-form input[name=fish-ends]').val(0);
				// $('.wpcf7-form input[name=cap-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
			} else if (end_type === 'End cap') {
				// $('.wpcf7-form input[name=cap-ends]').val(endProtection + " End cap Ends");
				// $('.wpcf7-form input[name=ped-ends]').val(0);
				// $('.wpcf7-form input[name=fish-ends]').val(0);
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(0);
			} else if (end_type === 'Beam Sleeve') {
				// $('.wpcf7-form input[name=beam-sleeve-ends]').val(endProtection + " Beam Sleeve");
				// $('.wpcf7-form input[name=ped-ends]').val(0);
				// $('.wpcf7-form input[name=fish-ends]').val(0);
				// $('.wpcf7-form input[name=cap-ends]').val(0);
			}
			return lapBolts;
		};

		// INITIALISE
		var runs          = $( '.product-calculator #runs' ).val();
		var length        = $( '.product-calculator #length' ).val();
		var usage         = $( '.product-calculator #usage' ).val();
		var beams         = $( '.product-calculator .field-beams input[name="beams"]:checked' ).val();
		var corners       = $( '.results #total-corners' ).val();
		var end_type      = $( '.product-calculator .field-end-type input[name="end-type"]:checked' ).val();
		var fixing        = $( '.product-calculator #fixings-bolt' ).val();
		var fixingDig     = $( '.product-calculator #fixings-dig' ).val();
		var postType      = $( '.product-calculator .field-post-type input[name="post-type"]:checked' ).val();
		var newPosts      = $( '.results #posts' ).val();
		var newBeams      = $( '.results #beams' ).val();
		var endProtection = $( '.results #end-protection' ).val();
		var lapBolts      = $( '.wpcf7-form input[name=lap-bolts]' ).val();
		var flag = false;

		calculate_post_fixing( fixingDig, fixing );
		calculate_posts(runs, length, usage, corners, fixingDig, fixing );
		calculate_beams(length, usage, beams );
		calculate_ancillary_items( corners, beams, end_type );
		calculate_post_bolts(runs, length, usage, corners, beams );
		calculate_lap_bolts( length, usage, beams, corners, fixing, fixingDig, end_type, endProtection );
		calculate_floor_anchors( length, usage, corners, fixing, fixingDig );
		calculate_post_type();
		calculate_beam_type();
		calculate_product_coating(); //new
		calculate_end_type( corners, beams, end_type, endProtection );

		set_old_end_protection(endProtection);

		$('input[name="Beams-Finishing"]').click(function () { calculate_product_coating(); });
		$('input[name="Posts-Finishing"]').click(function () { calculate_product_coating(); });
		$('input[name="Bolts-Finishing"]').click(function () { calculate_product_coating(); });
		$('input[name="Accessories-Finishing"]').click(function () { calculate_product_coating(); });
		$('input[name="All-Finishing"]').click(function () { calculate_product_coating(); });
		$('input[name="fixing-type"]').click(function () { calculate_post_fixing(fixingDig, fixing); });


		$( '.product-calculator .field-end-type .dropdown-input input[type="number"]' ).each( function () {
			$( this ).attr({
			"min" : 2
			});
			$( this ).change( function () {
				var self_val = $( this ).val();
				if ( self_val !== '' && self_val < 2 ) {
					flag = false;
					$( '<span class="error-message">The minimum number of barrier ends required is 2.</span>' ).insertAfter( $( this ) );
				} else {
					flag = true;
					$( this ).parent().find( '.error-message' ).remove();
				}
			});
		});


		$('.product-calculator input, .product-calculator select').each(function () {
			$( this ).change(function () {
				runs = $( '.product-calculator #runs' ).val();
				length = $('.product-calculator #length').val();
				usage = $('.product-calculator #usage').val();
				beams = $( '.product-calculator .field-beams input[name="beams"]:checked' ).val();
				end_type = $( '.product-calculator .field-end-type input[name="end-type"]:checked' ).val();
				fixing = $('.product-calculator #fixings-bolt').val();
				fixingDig = $('.product-calculator #fixings-dig').val();
				postType = $( '.product-calculator .field-post-type input[name="post-type"]:checked' ).val();

				var corner_90 = $( '.product-calculator #90-Degrees' ).val();
				var corner_135 = $( '.product-calculator #135-Degrees' ).val();
				var corner_flex = $( '.product-calculator #flexible' ).val();
				var steel_ends_pedestrian = $( '.product-calculator .field-end-type input[name="steel-ends-pedestrian"]' ).val();
				var steel_ends_fish_tail = $( '.product-calculator .field-end-type input[name="steel-ends-fish-tail"]' ).val();
				var pvc_pedestrian = $( '.product-calculator .field-end-type input[name="pvc-pedestrian"]' ).val();
				var pvc_end_cap = $( '.product-calculator .field-end-type input[name="pvc-end-cap"]' ).val();
				var pvc_beam_sleeve = $( '.product-calculator .field-end-type input[name="pvc-beam-sleeve"]' ).val();

				if ( steel_ends_pedestrian == '' || steel_ends_pedestrian < 2 ) {
					steel_ends_pedestrian = 0;
				}
				if ( steel_ends_fish_tail == '' || steel_ends_fish_tail < 2 ) {
					steel_ends_fish_tail = 0;
				}
				if ( pvc_pedestrian == '' || pvc_pedestrian < 2 ) {
					pvc_pedestrian = 0;
				}
				if ( pvc_end_cap == '' || pvc_end_cap < 2 ) {
					pvc_end_cap = 0;
				}
				if ( pvc_beam_sleeve == '' || pvc_beam_sleeve < 2 ) {
					pvc_beam_sleeve = 0;
				}

				var no_of_ends = Number(steel_ends_pedestrian) + Number(steel_ends_fish_tail) + Number(pvc_pedestrian) + Number(pvc_end_cap) + Number(pvc_beam_sleeve);

				var ped_ends = Number(steel_ends_pedestrian) + Number(pvc_pedestrian);

				$( '.results #no-of-ends' ).val( no_of_ends == 0 ? 2 : no_of_ends );

				$( '.results #90-barrier-corners, .wpcf7-form input[name=barrier-90-corners]' ).val( corner_90 == '' ? 0 : corner_90 );				
				$( '.results #135-barrier-corners, .wpcf7-form input[name=barrier-135-corners]' ).val( corner_135 == '' ? 0 : corner_135 );
				$( '.results #flexible-barrier-corners, .wpcf7-form input[name=barrier-flexible-corners]' ).val( corner_flex == '' ? 0 : corner_flex );
				
// 				runs =  Math.ceil(no_of_ends * 2);
				
				if(no_of_ends != '' || no_of_ends != 0) {
				   runs =  Math.ceil(no_of_ends / 2);
				}

				$( '.product-calculator #runs, .wpcf7-form input[name=runs]' ).val( runs == '' ? 1 : runs );

// 				console.log(runs, ped_ends );

				$( '.wpcf7-form input[name=total-length]' ).val( length == '' ? 0 : length );
				$( '.wpcf7-form input[name=post-spacing]' ).val( usage == '' ? 0 : usage );

				$( '.wpcf7-form input[name=ped-ends]' ).val( ped_ends == '' ? 0 : ped_ends );
				$( '.wpcf7-form input[name=fish-ends]' ).val( steel_ends_fish_tail == '' ? 0 : steel_ends_fish_tail );
				$( '.wpcf7-form input[name=end-cap-ends]' ).val( pvc_end_cap == '' ? 0 : pvc_end_cap );
				$( '.wpcf7-form input[name=beam-sleeve-ends]' ).val( pvc_beam_sleeve == '' ? 0 : pvc_beam_sleeve );


				corners = Number(corner_90) + Number(corner_135) + Number(corner_flex);

				$( '.results #total-direction' ).val( corners == '' ? 0 : corners );

				calculate_post_fixing(fixingDig, fixing);
				calculate_posts(runs, length, usage, corners, fixingDig, fixing );
				calculate_beams(length, usage, beams);
				calculate_ancillary_items(corners, beams, end_type);
				calculate_post_bolts(runs, length, usage, corners, beams);
				calculate_lap_bolts(length, usage, beams, corners, fixing, fixingDig, end_type, endProtection);
				calculate_floor_anchors(length, usage, corners, fixing, fixingDig);
				calculate_post_type();
				calculate_beam_type();
			});
		});

		$('.results input[name="end-protection"]').change(function () {
			endProtection = $('.results #end-protection').val();
			beams = $( '.product-calculator .field-beams input[name="beams"]:checked' ).val();
			corners = $( '.results #total-corners' ).val();
			end_type = $( '.product-calculator .field-end-type input[name="end-type"]:checked' ).val();
			calculate_end_type(corners, beams, end_type, endProtection);
			lapBolts = $('.wpcf7-form input[name=lap-bolts]').val();
			calculate_lap_bolts_reverse(lapBolts, endProtection, end_type);
		});

		$('.results input[name="posts-amount"]').change(function () {
			runs = $( '.product-calculator #runs' ).val();
			length = $('.product-calculator #length').val();
			usage = $('.product-calculator #usage').val();
			beams = $( '.product-calculator .field-beams input[name="beams"]:checked' ).val();
			corners = $( '.results #total-corners' ).val();
			end_type = $( '.product-calculator .field-end-type input[name="end-type"]:checked' ).val();
			fixing = $('.product-calculator #fixings-bolt').val();
			fixingDig = $('.product-calculator #fixings-dig').val();
			postType = $( '.product-calculator .field-post-type input[name="post-type"]:checked' ).val();
			newPosts = $('.results #posts').val();
			newBeams = $('.results #beams').val();
			calculate_posts_reverse(runs, length, usage, beams, corners, end_type, fixing, fixingDig, postType, newPosts, newBeams);
		});

		$('.results input[name="beams-amount"]').change(function () {
			runs = $( '.product-calculator #runs' ).val();
			length = $('.product-calculator #length').val();
			usage = $('.product-calculator #usage').val();
			beams = $( '.product-calculator .field-beams input[name="beams"]:checked' ).val();
			corners = $( '.results #total-corners' ).val();
			end_type = $( '.product-calculator .field-end-type input[name="end-type"]:checked' ).val();
			fixing = $('.product-calculator #fixings-bolt').val();
			fixingDig = $('.product-calculator #fixings-dig').val();
			postType = $( '.product-calculator .field-post-type input[name="post-type"]:checked' ).val();
			newPosts = $('.results #posts').val();
			newBeams = $('.results #beams').val();
			calculate_beams_reverse(length, usage, beams, corners, end_type, fixing, fixingDig, postType, newPosts, newBeams);
		});

		$('.product-calculator #corners').change(function () {
			if ($(this).val() === "3.2") {
				$('img.cars').removeClass('invisible');
				$('img.lorry').addClass('invisible');
			} else {
				$('img.cars').addClass('invisible');
				$('img.lorry').removeClass('invisible');
			}
		});

		if ($('.product-calculator #usage').val() === "3.2") {
			$('img.cars').removeClass('invisible');
			$('img.lorry').addClass('invisible');
		} else {
			$('img.cars').addClass('invisible');
			$('img.lorry').removeClass('invisible');
		}

		$('.product-calculator #usage').change(function () {
			if ($(this).val() === "3.2") {
				$('img.cars').removeClass('invisible');
				$('img.lorry').addClass('invisible');
			} else {
				$('img.cars').addClass('invisible');
				$('img.lorry').removeClass('invisible');
			}
		});

		if ($('.product-calculator #end-type').val() === "steel-ends") {
			$('img.pedestrian').removeClass('invisible');
			$('img.fish-tail').addClass('invisible');
		}

		$( '.product-calculator .field-end-type .tab-radio-input' ).on( 'click change', function () {
			
			if ( $( this ).val() == 'Pedestrian' ) {
				$('img.pedestrian').removeClass('invisible');
				$('img.fish-tail').addClass('invisible');
				$('img.end-cap').addClass('invisible');
				$('img.beam-sleeve').addClass('invisible');
			}

			if ( $( this ).val() == 'Fish Tail' ) {
				$('img.fish-tail').removeClass('invisible');
				$('img.pedestrian').addClass('invisible');
				$('img.end-cap').addClass('invisible');
				$('img.beam-sleeve').addClass('invisible');
			}

			if ( $( this ).val() == 'End Cap' ) {
				$('img.end-cap').removeClass('invisible');
				$('img.fish-tail').addClass('invisible');
				$('img.pedestrian').addClass('invisible');
				$('img.beam-sleeve').addClass('invisible');
			}

			if ( $( this ).val() == 'Beam Sleeve' ) {
				$('img.beam-sleeve').removeClass('invisible');
				$('img.end-cap').addClass('invisible');
				$('img.fish-tail').addClass('invisible');
				$('img.pedestrian').addClass('invisible');
			}
		});

		// if ($('.product-calculator #post-type').val() === "RSJ Section") {
		// 	$('img#rsj-section').removeClass('invisible');
		// 	$('img#economy-z').addClass('invisible');
		// } else {
		// 	$('img#rsj-section').addClass('invisible');
		// 	$('img#economy-z').removeClass('invisible');
		// }

		// $('.product-calculator #post-type').change(function () {
		// 	if ($(this).val() === "RSJ Section") {
		// 		$('img#rsj-section').removeClass('invisible');
		// 		$('img#economy-z').addClass('invisible');
		// 	} else {
		// 		$('img#rsj-section').addClass('invisible');
		// 		$('img#economy-z').removeClass('invisible');
		// 	}
		// });

		// $( 'input[name="fixing-type"]' ).on( 'click change', function () {
		// 	var _self = $( this ).val();
		// 	if ( 'digin' === _self ) {
		// 		$( '.fixings-bolt' ).css( 'display', 'none' );
		// 		$( '.fixings-dig' ).css( 'display', 'block' );
				
		// 		if ( ! $( '.results #floor-anchors' ).parent().parent().hasClass( 'd-none' ) ) {
		// 			$( '.results #floor-anchors' ).parent().parent().addClass( 'd-none' );
		// 		}
		// 	} else {
		// 		$( '.fixings-bolt' ).css( 'display', 'block' );
		// 		$( '.fixings-dig' ).css( 'display', 'none' );
		// 		if ( $( '.results #floor-anchors' ).parent().parent().hasClass( 'd-none' ) ) {
		// 			$( '.results #floor-anchors' ).parent().parent().removeClass( 'd-none' );
		// 		}
		// 	}
		// });

		$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'block' );
		$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'none' );
		$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'none' );
		$( '#handrails-no-radio, #boltdown-radio' ).trigger( 'click' );
		$( '#end-type option' ).first().prop('selected', true);
		$( '#pedestrian, #fish-tail' ).parent().css( 'display', 'block' );
		$( '#beam-sleeve, #end-cap' ).parent().css( 'display', 'none' );

		var _self = $( 'input[name="handrails-type"]:checked' ).val();
		if ( 'no' === _self ) {
			$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'block' );
			$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'none' );
			$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'none' );
			$( '#fixings-bolt option[value="Bolt Down (760mm)"]' ).prop( 'selected', true );
			$( '#fixings-dig option[value="Dig In (1200mm)"]' ).prop( 'selected', true );
			if ( ! $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
				$( '.results #handrails' ).parent().parent().addClass( 'd-none' );
			}
			
			if($( 'input[value="Double"]' ).is(':checked')) {
				console.log('1 no double');
			} else if($( 'input[value="Single"]' ).is(':checked')) {
				console.log('1 no single');
			}
		} else if ( 'yes' === _self ) {
			$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'none' );
			$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'block' );
			$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'block' );
			$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).prop( 'selected', true );
			$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).prop( 'selected', true );
			if ( $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
				$( '.results #handrails' ).parent().parent().removeClass( 'd-none' );
			}
			if($( 'input[value="Double"]' ).is(':checked')) {
				console.log('1 yes double');
			} else if($( 'input[value="Single"]' ).is(':checked')) {
				console.log('1 yes single');
			}
		}
		$( 'input[name="handrails-type"]' ).on( 'click, change', function () {
			var _self = $( this ).val();
			if ( 'no' === _self ) {
				$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'block' );
				$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'none' );
				$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'none' );
				$( '#fixings-bolt option[value="Bolt Down (760mm)"]' ).prop( 'selected', true );
				$( '#fixings-dig option[value="Dig In (1200mm)"]' ).prop( 'selected', true );
				if ( ! $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
					$( '.results #handrails' ).parent().parent().addClass( 'd-none' );
				}
				
				if($( 'input[value="Double"]' ).is(':checked')) {
					console.log('2 no double');
				} else if($( 'input[value="Single"]' ).is(':checked')) {
					console.log('2 no single');
				}
			} else if ( 'yes' === _self ) {
				$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'none' );
				$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'block' );
				$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'block' );
				$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).prop( 'selected', true );
				$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).prop( 'selected', true );
				if ( $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
					$( '.results #handrails' ).parent().parent().removeClass( 'd-none' );
				}
				
				if($( 'input[value="Double"]' ).is(':checked')) {
					console.log('2 yes double');
				} else if($( 'input[value="Single"]' ).is(':checked')) {
					console.log('2 yes single');
				}
			}
		});
		$( 'input[name="fixing-type"]' ).on( 'click change', function () {
			var _self = $( 'input[name="handrails-type"]:checked' ).val();
			if ( 'no' === _self ) {
				$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'block' );
				$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'none' );
				$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'none' );
				$( '#fixings-bolt option[value="Bolt Down (760mm)"]' ).prop( 'selected', true );
				$( '#fixings-dig option[value="Dig In (1200mm)"]' ).prop( 'selected', true );
			} else if ( 'yes' === _self ) {
				$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'none' );
				$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'block' );
				$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'block' );
				$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).prop( 'selected', true );
				$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).prop( 'selected', true );
			}
		});

		$('#finish-no-radio').trigger( 'click' );
		$( 'input[name="finish-type"]' ).on( 'click change', function () {
			var _self = $( this ).val();
			if ( 'yes' === _self ) {
				$( '.finish-type-wrap' ).removeClass( 'd-none' );
			} else {
				$( '.finish-type-wrap' ).addClass( 'd-none' );
			}
		});

		$( '#pedestrian-steel-ends-input' ).trigger( 'click' );
		$( '.tabs-input.pedestrian-steel-ends-input' ).removeClass( 'invisible' );
		$( '.tab-radio-input' ).on( 'click', function (event) {
			var _self = $( this ),
				parents = _self.parents( '.field-wrapper' );

			/* input field*/
			parents.find( '.calculator-tabs-input-wrap .tabs-input' ).addClass( 'invisible' );
			parents.find( '.' + _self.attr( 'data-id' ) ).removeClass( 'invisible' );

			/* input field image*/
			parents.find( 'img:not(.image-js)' ).addClass( 'invisible' );
			parents.find( '.' + _self.attr( 'data-id' ) ).removeClass( 'invisible' );
			
			if($( this ).attr( 'data-id' ) == 'Lightweight-Z') {
				$('#handrails-yes-radio').prop("disabled", true);
				$( '#fixings-bolt option[value="Bolt Down (1100mm)"]' ).css( 'display', 'none' );
				$( '#handrails-no-radio' ).trigger( 'click' );
			} else if($( this ).attr( 'data-id' ) == 'Heavy-Duty-RSJ') {
				$('#handrails-yes-radio').prop("disabled", false);
				$( '#fixings-bolt option[value="Bolt Down (1100mm)"]' ).css( 'display', 'block' );
			}
			
			if($( this ).attr( 'data-id' ) == 'Single') {
				var _self = $( 'input[name="handrails-type"]:checked' ).val();
				if ( 'no' === _self ) {
					console.log('single no');
					$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'block' );
					$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'none' );
					$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'none' );
					$( '#fixings-bolt option[value="Bolt Down (760mm)"]' ).prop( 'selected', true );
					$( '#fixings-dig option[value="Dig In (1200mm)"]' ).prop( 'selected', true );
					if ( ! $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
						$( '.results #handrails' ).parent().parent().addClass( 'd-none' );
					}
				} else if ( 'yes' === _self ) {
					console.log('single yes');
					$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'none' );
					$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'block' );
					$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'block' );
					$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).prop( 'selected', true );
					$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).prop( 'selected', true );
					if ( $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
						$( '.results #handrails' ).parent().parent().removeClass( 'd-none' );
					}
				}
			} else if($( this ).attr( 'data-id' ) == 'Double') {
				var _self = $( 'input[name="handrails-type"]:checked' ).val();parents
				if ( 'no' === _self ) {
					console.log('double no');
					$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'block' );
					$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'none' );
					$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'none' );
					$( '#fixings-bolt option[value="Bolt Down (760mm)"]' ).prop( 'selected', true );
					$( '#fixings-dig option[value="Dig In (1200mm)"]' ).prop( 'selected', true );
					if ( ! $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
						$( '.results #handrails' ).parent().parent().addClass( 'd-none' );
					}
				} else if ( 'yes' === _self ) {
					console.log('double yes');
					$( '#fixings-bolt option, #fixings-dig option' ).css( 'display', 'none' );
					$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).css( 'display', 'block' );
					$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).css( 'display', 'block' );
					$( '#fixings-bolt option[value="Bolt Down (760mm + Handrail Ext.)"]' ).prop( 'selected', true );
					$( '#fixings-dig option[value="Dig In (1500mm + Handrail Ext.)"]' ).prop( 'selected', true );
					if ( $( '.results #handrails' ).parent().parent().hasClass( 'd-none' ) ) {
						$( '.results #handrails' ).parent().parent().removeClass( 'd-none' );
					}
				}
			}
		});

		$( '.field-end-type .calculator-options .tab-radio-input' ).parent().css( 'display', 'none' );
		$( '#pedestrian-steel-ends-input, #fish-tail-steel-ends-input' ).parent().css( 'display', 'block' );
		$( '.product-calculator select' ).each(function () {
			$( this ).change( function () {
				var end_type = $( '.product-calculator #end-type' ).val();
				switch ( end_type ) {
					case 'steel-ends':
						$( '.field-end-type .calculator-options .tab-radio-input' ).parent().css( 'display', 'none' );
						$( '#pedestrian-steel-ends-input, #fish-tail-steel-ends-input' ).parent().css( 'display', 'block' );
						$( '#pedestrian-steel-ends-input' ).trigger( 'click' );
						break;
					case 'polymer-ends':
						$( '.field-end-type .calculator-options .tab-radio-input' ).parent().css( 'display', 'none' );
						$( '#pedestrian-polymer-ends-input, #fish-tail-polymer-ends-input, #end-cap-polymer-ends-input' ).parent().css( 'display', 'block' );
						$( '#pedestrian-polymer-ends-input' ).trigger( 'click' );
						break;
					case 'pvc':
						$( '.field-end-type .calculator-options .tab-radio-input' ).parent().css( 'display', 'none' );
						$( '#pedestrian-pvc-input, #end-cap-pvc-input, #beam-sleeve-pvc-input' ).parent().css( 'display', 'block' );
						$( '#pedestrian-pvc-input' ).trigger( 'click' );
						break;
				}
			});
		});

		/* Sticky Element */
		sticky_sidebar();
		function sticky_sidebar() {
			if ( $( window ).width() >= 1024  ) {
				if ( $( '.sidebar-block' ).length > 0 ) {
					$( '.sidebar-block' ).stick_in_parent({
						offset_top: 52
					});
				}
			}
		}

		$( window ).on( 'resize', function() {
			setTimeout( function () {
				$( '.sidebar-block' ).trigger( 'sticky_kit:recalc' );
			}, 500 );
		});
	}
});
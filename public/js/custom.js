/* =================================
	 COMMON PAGINATION START
======================================*/
// $(window).on('hashchange', function () {

// 	if (window.location.hash) {
// 		var page = window.location.hash.replace('#', '');
// 		if (page == Number.NaN || page <= 0) {
// 			return false;
// 		} else {
// 			getData(page);
// 		}
// 	}
// });
// $(document).ready(function () {
// 	$(document).on('click', '.pagination a', function (event) {
// 		event.preventDefault();
// 		$('li.page-item').removeClass('active');
// 		$(this).parent('li.page-item').addClass('active');
// 		var myurl = $(this).attr('href');
// 		var page = $(this).attr('href').split('page=')[1];
// 		getData(page);
// 	});
// });
// function getData(page) {


// 	var filter_str = '';

// 	// SEARCH FILTER FOR Customer
// 	if ($('#first_name').val() != '' && $('#first_name').val() != undefined)
// 		filter_str += '&first_name=' + $('#first_name').val();
// 	if ($('#last_name').val() != '' && $('#last_name').val() != undefined)
// 		filter_str += '&last_name=' + $('#last_name').val();
// 	if ($('#email').val() != '' && $('#email').val() != undefined)
// 		filter_str += '&email=' + $('#email').val();
// 	if ($('#role_id').val() != null && $('#role_id').val() != undefined)
// 		filter_str += '&role_id=' + $('#role_id').val();
// 	if ($('#end_date').val() != '' && $('#end_date').val() != undefined)
// 		filter_str += '&end_date=' + $('#end_date').val();
// 	if ($('#gender').val() != '' && $('#gender').val() != undefined)
// 		filter_str += '&gender=' + $('#gender').val();
// 	if ($('#start_date').val() != '' && $('#start_date').val() != undefined)
// 		filter_str += '&start_date=' + $('#start_date').val();
// 	if ($('#age_from').val() != '' && $('#age_from').val() != undefined)
// 		filter_str += '&age_from=' + $('#age_from').val();
// 	if ($('#age_to').val() != '' && $('#age_to').val() != undefined)
// 		filter_str += '&age_to=' + $('#age_to').val();
// 	//   if($('#mobile_number').val()!='' && $('#mobile_number').val()!=undefined)
// 	// filter_str +=  '&mobile_number=' +$('#mobile_number').val();
// 	if ($('#status').val() != '' && $('#status').val() != undefined)
// 		filter_str += '&status=' + $('#status').val();
// 	if ($('#title').val() != '' && $('#title').val() != undefined)
// 		filter_str += '&title=' + $('#title').val();
// 	if ($('#per_page').val() != '' && $('#per_page').val() != undefined)
// 		filter_str += '&per_page=' + $('#per_page').val();

// 	//alert($('#role_id').val());

// 	$.ajax({
// 		url: '?page=' + page + filter_str,
// 		type: "get",
// 		datatype: "html"
// 	})
// 		.done(function (data) {
// 			$("#tag_container").empty().html(data);
// 			location.hash = page;
// 			bindSortableDataElement();
// 			sortingElements();

// 		})
// 		.fail(function (jqXHR, ajaxOptions, thrownError) {
// 			alert('No response from server');
// 		});
// }

// /* =================================
// 	 COMMON PAGINATION START
// ======================================*/
// /* =======Notification Message =========
// position - top-right,top-left,bottom-left,bottom-right
// theme - success,info,warning,error,none
// showDuration - 4000
// ==================================*/
// function notification(title, message, positionClass, theme, showDuration) {
// 	window.createNotification({
// 		closeOnClick: true,
// 		displayCloseButton: 1,
// 		positionClass: 'nfc-' + positionClass,
// 		showDuration: showDuration,
// 		theme: theme
// 	})({
// 		title: title,
// 		message: message
// 	});
// }

// $('.clear').click(function () {
// 	$(this).parents().find('form')[0].reset();
// })

/*======================================================
	OPEN CONFIRM BOX TO COMPLETE THE REPORT
=========================================================*/
$(document).on('click', '#open_confirmBox,.open_confirmBox', function (e) {
	e.preventDefault();

	var id = $(this).data('id');
	var confirm_message = $(this).data('confirm_message');
	var confirm_message_1 = $(this).data('confirm_message_1');
	var leftButtonId = $(this).data('left_button_id');
	var leftButtonName = $(this).data('left_button_name');
	var leftButtonCls = $(this).data('left_button_cls');
	var language = $(this).data('language');

	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: "POST",
		url: base_url + '/confirmModal',
		data: { id: id, confirm_message: confirm_message, confirm_message_1: confirm_message_1, leftButtonId: leftButtonId, leftButtonName: leftButtonName, leftButtonCls: leftButtonCls, _token: csrf_token, language: language },
		success: function (data) {
			$('.confirmBoxCompleteModal').html(data)
			$('.confirmBoxCompleteModal').modal('show')
		}
	});
});


/*--------------------------------------------------------------------
Notifiaction
-----------------------------------------------------------*/
/* 	setInterval(function(){
		countnotification();
		var pageURL= $(location).attr("href").split('/').pop();
		if(pageURL=='requests')
			request_listing();
		if(pageURL=='users')
			user_listing();
		if(pageURL=='reports')
			complete_request_listing();
		if(pageURL=='analysts')
			analyst_request_listing();
	},5000); */




function countnotification() {
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: "POST",
		url: base_url + '/getUnreadNotificationsCount',
		data: { _token: csrf_token },
		dataType: "json",
		success: function (data) {

			if (data.total_notification > 0) {
				$('#count').removeClass('count');
				$('#count').addClass('count1');
				//If request/user created then show request in list without page refresh

			}

			$('#count').html(data.total_notification);

		}
	});
}
$("#notificationButton").on("click", function () {
	var $attrib = $("#notificationDropdown");
	if ($attrib.is(":hidden")) {
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: "POST",
			url: base_url + '/getUnreadNotifications',
			data: { _token: csrf_token },
			dataType: "json",
			success: function (data) {
				if (data.success) {
					$('#scroll').html(data.notifications);
					$('#viewAll').show();
				} else {
					$('#scroll').html('<span style="color:red;display:block;text-align:center">No Record Found. </span>');
					$('#viewAll').hide();
				}
			}
		});
	}
});
/*--------------------------------------------------------------------
Notifiaction
-----------------------------------------------------------*/
// jQuery(".main-menu li.has-menu i.fa-solid").click(function () {
//     jQuery(this).parent().siblings(".sub-dropmenu").toggleClass('activa');
//     jQuery(this).toggleClass("fa-angle-down fa-angle-up");
// });

// jQuery(".main-menu li.has-menu ul.sub-dropmenu li a").click(function () {
// 	jQuery(this).parent().siblings().removeClass("active");
// 	jQuery(this).parent().addClass("active");
// });

jQuery("#user_filter").click(function () {
	if (jQuery(window).width() >= 992) {
		if (jQuery(".user-wrap").height() < 150) {
			jQuery(".user-wrap").animate({ height: "150px" }, 500).addClass("mb-4");
		}
		else {
			jQuery(".user-wrap").animate({ height: "0px" }, 500).removeClass("mb-4");
		}
	}
	else {
		if (jQuery(".user-wrap").height() < 475) {
			jQuery(".user-wrap").animate({ height: "475px" }, 500).addClass("mb-4");
		}
		else {
			jQuery(".user-wrap").animate({ height: "0px" }, 500).removeClass("mb-4");
		}
	}
});
function handleFileSelect1(event) {
	var input = this;
	if (input.files && input.files.length) {
		var filesAmount = input.files.length;
		for (i = 0; i < filesAmount; i++) {
			var reader = new FileReader();
			this.enabled = false
			reader.onload = (function (e) {
				document.getElementById('featuredimg').innerHTML = ['<span><img id="test" class="thumb" src="', e.target.result, '" title="', escape(e.name), '"/><span class="remove_img_preview"></span></span>'].join('');
			});
			reader.readAsDataURL(input.files[i]);
		}
	}
	if (this.files[0].type != "application/pdf" && this.files[0].type != "application/msword" && this.files[0].type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
		sts = true;
		alerr += "Jenis file bukan .pdf/.doc/.docx ";
	}
}
function handleFileSelect(event) {
	var input = this;
	if (input.files && input.files.length) {
		var filesAmount = input.files.length;
		for (i = 0; i < filesAmount; i++) {
			var reader = new FileReader();
			this.enabled = false
			reader.onload = (function (e) {
				var span = document.createElement('span');
				span.innerHTML = ['<img id="test" class="thumb" src="', e.target.result, '" title="', escape(e.name), '"/><span class="remove_img_preview"></span>'].join('');
				document.getElementById('preview').insertBefore(span, null);
			});
			reader.readAsDataURL(input.files[i]);
		}
	}
}
$('#photos').change(handleFileSelect);
$('#preview').on('click', '.remove_img_preview', function () {
	$(this).parent('span').remove();
	$(this).val("");
});
$('#blogimg').change(handleFileSelect1);
$('#featuredimg').on('click', '.remove_img_preview', function () {
	$(this).parent('span').remove();
	$(this).val("");
});

/* Select all the checkboxes on the media listing */
jQuery(".media-listing table thead tr th input[type='checkbox']").click(function () {
	if (!jQuery(this).prop("checked")) {
		jQuery(this).parents('thead').siblings('tbody').find('input[type="checkbox"]').prop("checked", false);
	}
	else {
		jQuery(this).parents('thead').siblings('tbody').find('input[type="checkbox"]').prop("checked", true);
	}
});

/************************************************* */
jQuery(window).on("load", function () {
	desktopHoverMenu();
});
jQuery(window).on("resize", function () {
	desktopHoverMenu();
});
function desktopHoverMenu() {
	if (jQuery(window).width() >= 768) {
		jQuery(".menu .main-menu .scroll ul li.has-menu").mouseenter(function () {
			jQuery(".menu .sub-menu").addClass("shown");
			let link = jQuery(this).data('link');
			jQuery(".menu").addClass("radius-zero");
			jQuery(".menu .sub-menu ul").removeClass('shown');
			jQuery(".menu .sub-menu ul[data-link='" + link + "']").addClass('shown');
		});
		jQuery(" .sub-menu").mouseleave(function () {
			jQuery(".menu .sub-menu").removeClass("shown");
			let link = jQuery(this).data('link');
			jQuery(".menu").removeClass("radius-zero");
			jQuery(".menu .sub-menu ul[data-link='" + link + "']").removeClass('shown');
		});
	}
}

jQuery(".menu .main-menu .scroll ul li.has-menu .mobile-icon").click(function (e) {
	setTimeout(function () {
		jQuery(".menu .main-menu .scroll ul li.has-menu .mobile-icon").removeClass("open");
		e.target.classList.add("open");
		jQuery(".menu .sub-menu").addClass("shown");
		let link = e.target.getAttribute('data-link');
		jQuery(".menu").addClass("radius-zero");
		jQuery(".menu .sub-menu ul").removeClass('shown');
		jQuery(".menu .sub-menu ul[data-link='" + link + "']").addClass('shown');
	}, 1000);
});

jQuery(".navbar .menu-button-mobile").on("click", function () {
	jQuery("body").addClass("open-sidebar");
});

$('main, .navbar').click(function (event) {
	var container = $(".menu");
	if (!container.is(event.target) && !container.has(event.target).length) {
		jQuery(".menu .sub-menu").removeClass("shown");
		jQuery("body").removeClass("open-sidebar");
		jQuery(".menu .main-menu .scroll ul li.has-menu .mobile-icon").removeClass("open");
		jQuery(".menu").removeClass("radius-zero");
	}
});

/*********************************** */
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

// setTimeout(function () {
//     $("#alert-box-container").empty().remove();
// }, 3000);

/* =======================================
	FOR SHOWING AND HIDE THE LOADERS
======================================= */
function toggleLoader(value) {
    $('.loadingwrap').css('display', value);
 }

/* =======================================
	FOR CUSTOMIZE THE TOASTER NOTIFICATION
======================================= */
toastr.options = 
{
	closeButton: true,
	closeHtml: '<button type="button">&times;</button>',
	closeClass:'toast-close-button',
	newestOnTop: false,
	progressBar: false,
	positionClass: 'toast-top-right',
	preventDuplicates: false,
	onclick: null,
	showDuration: '300',
	hideDuration: '1000',
	timeOut: '5000',
	extendedTimeOut: '1000',
	showEasing: 'swing',
	hideEasing: 'linear',
	showMethod: 'fadeIn',
	hideMethod: 'fadeOut',
	iconClasses: {
		error: 'toast-error',
		info: 'toast-info',
		success: 'toast-success',
		warning: 'toast-warning',
		classic: 'toast-classic'
	},
}
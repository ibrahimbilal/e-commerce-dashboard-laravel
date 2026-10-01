'use strict';

$(() => {

    // Prevent Default Action If Link Equal //#
    $('a[href="#"]').on('click', function (e) {
        e.preventDefault();
    });

    // Close Open / Hide Showen => Elements On Click Any Where
    $(document).on('click', () => {

        // hide search area
        $('header .search-area:not(.mobile)').addClass('d-flex').fadeIn('fast');
        $('header .action-area').addClass('d-flex').fadeIn('fast');
        $('header .mobile').fadeOut('fast', () => $('header .mobile').removeClass('d-flex'));

        // hide Float Window
        $('.float-window').removeClass('d-block');
    });

    $(window).on('resize', function () {
        if ($(window).width() > 578 && $(window).width() < 992) {
            $('header .search-area:not(.mobile)').addClass('d-flex').fadeIn('fast');
            $('header .action-area').addClass('d-flex').fadeIn('fast');
            $('header .mobile').fadeOut('fast', () => $('header .mobile').removeClass('d-flex'));
        }
    });

    // Show Alert When User Leave a Page And his Did Changes In Form
    preventLeavePage();

    // Collaps Menu
    $('#collaps').on('click', function (e) {
        e.preventDefault();
        if ($('body').hasClass('collapsed')) {
            $('body').removeClass('collapsed');
            localStorage.removeItem('collapse_menu');
        } else {
            $('body').addClass('collapsed');
            localStorage.setItem('collapse_menu', 'collapsed');
        }
    });

    // Toggle Full Screen
    $('#expand').on('click', function () {
        var fullScreenTooltip = $(this).attr('main-tooltip'),
            exitFullScreenTooltip = $(this).attr('alt-tooltip');
        //in fullscreen, so exit it
        if (document.fullscreenElement ||
            document.webkitFullscreenElement ||
            document.mozFullScreenElement ||
            document.msFullscreenElement) {
            $('#expand').attr('tooltip', fullScreenTooltip);
            $('#expand i').removeClass('fi-rr-compress').addClass('fi-rr-expand');
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        } else { //not fullscreen, so enter it
            $('#expand').attr('tooltip', exitFullScreenTooltip);
            $('#expand i').addClass('fi-rr-compress').removeClass('fi-rr-expand');
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        }
    });

    // Toggle Theme Mode ( dark / light )
    $('#theme-mode').on('click', function () {
        var LightTooltip = $(this).attr('alt-tooltip'),
            DarkTooltip = $(this).attr('main-tooltip');
        if ($('html').hasClass('dark')) {
            $('#theme-mode').attr('tooltip', DarkTooltip);
            $('html').removeClass('dark');
            $('table').removeClass('table-dark');
            $(this).find('.fi-rr-sun').removeClass('fi-rr-sun').addClass('fi-rr-moon-stars');
            localStorage.removeItem('theme_mode');
        } else {
			$('#theme-mode').attr('tooltip', LightTooltip);
            $('html').addClass('dark');
            $('table').addClass('table-dark');
			$(this).find('.fi-rr-moon-stars').removeClass('fi-rr-moon-stars').addClass('fi-rr-sun');
            localStorage.setItem('theme_mode', 'dark');
        }
    });

    // Create Tooltip If Side Menu is Collapsed
    $('.dashbord-menu .list-item').on('mouseenter', function () {
        var eleWidth = $(this).find('i').width(),
            top = $(this).find('i').offset().top,
            left = $(this).find('i').offset().left + eleWidth,
            content = $(this).find('> a > .title').text();

        $('body aside').append('<span class="tooltip" flow="right"><span class="after">' + content + '</span><span class="before"></span></span>');
        $('body aside .tooltip .after, body aside .tooltip .before').css({display: 'block' });
        $('body aside .tooltip').addClass('show');
        $('body aside .tooltip').css({
            top: top + (eleWidth/2),
            left: left,
        })
    });
    // ReCalculate Item Top On Scroll Window
    $(window).on('scroll', function () { //when window is scrolled
        $('.dashbord-menu .list-item').on('mouseenter', function () {
            var top = $(this).find('i').offset().top - $(window).scrollTop(),
				eleWidth = $(this).find('i').width();
            $('body aside .tooltip').css({
				top: top + (eleWidth/2),
            })
        });
        $('body aside .tooltip').remove();
    });
    // Remove Tooltip On Mouse Leave
    $('.dashbord-menu .list-item').on('mouseleave', function () {
        $('body aside .tooltip').remove();
    });

    // Show Side Menu On Small Screens
    $('#menu-btn').on('click', function () {
        $('aside').fadeIn('300');
        $('html').css('overflow-y', 'hidden');
        setTimeout(() => {
            $('.dashbord-menu').addClass('show');
        }, 300);
    });

    // Hide Side Menu When Click On Overlay
    $('aside').on('click', function () {
        $('.dashbord-menu').removeClass('show');
        $('html').css('overflow-y', 'auto');
        setTimeout(() => {
            $('aside').fadeOut('300');
        }, 300);
    });
    $('.dashbord-menu').on('click', function (e) {
        e.stopPropagation();
    });

    // Show Side Menu When Tablet Landscape
    $(window).on('orientationchange', function (e) {
        if ($(window).width() >= 768 && $(window).width() <= 1024) {
            if ($('aside').is(':hidden') && !$('.dashbord-menu').hasClass('show')) {
                $('aside').show();
                $('html').css('overflow-y', 'auto');
            } else if ($('aside').is(':visible') && $('.dashbord-menu').hasClass('show')) {
                $('aside').show();
                $('.dashbord-menu').removeClass('show');
                $('html').css('overflow-y', 'auto');
            } else {
                $('aside').hide();
                $('.dashbord-menu').removeClass('show');
            }
        }
    });

    // Show / Hide Submenu
    $('.has-submenu > a').on('click', function(e) {
        if ( $(this).parent().hasClass('active') ) {
            $(this).next('.submenu').slideUp();
            $(this).parent().removeClass('active');
        } else {
            e.preventDefault();
            $(this).next('.submenu').slideDown();
            $(this).parent().addClass('active');
        }
    });

    // Show Search Form On Mobile
    $('#search-btn').on('click', function (e) {
        e.stopPropagation();
        $('header .search-area:not(.mobile)').fadeOut('fast', () => $('header .search-area:not(.mobile)').removeClass('d-flex'));
        $('header .action-area').fadeOut('fast', () => $('header .action-area').removeClass('d-flex'));
        $('header .mobile').fadeIn('fast').addClass('d-flex');
    });
    $('header .mobile .close').on('click', function () {
        $('header .search-area:not(.mobile)').addClass('d-flex').fadeIn('fast');
        $('header .action-area').addClass('d-flex').fadeIn('fast');
        $('header .mobile').fadeOut('fast', () => $('header .mobile').removeClass('d-flex'));
    });

    // Toggle Show/Hide Notify/Messages Window
    $(".header-btn").on('click', function (e) {
        // e.stopPropagation();
        $(this).find('.dot').remove();
        var windowID = $(this).data('window');
        $(windowID).siblings().removeClass('d-block');
        if ($(windowID).hasClass('d-block')) {
            $(windowID).removeClass('d-block');
        } else {
            $(windowID).addClass('d-block');
        }
    });

    // Mark As Read
    $('.mark-as-read').on('click', function (e) {
        // e.stopPropagation();
        $(this).parent().siblings().find('.doted').removeClass('doted');
    });
    // Prevent Closing Window
    $('.header-btn, .float-window').on('click', function (e) {
        e.stopPropagation();
    });

    // String To Slug
	if ( $('#item-title').length > 0 ) {
		$('#item-title').stringToSlug({
			setEvents: 'keyup keydown input',
			getPut: '#item-slug',
			space: '-',
			prefix: '',
			suffix: '',
			replace: '',
			AND: '-and-',
			options: {
				lang: 'ar',
				titleCase: false
			},
			callback: false
		});
	}

    // Tabs
    $('.tab-btn').on('click', function () {
        var tabID = $(this).data('tab-id');
        $(this).addClass('active').siblings().removeClass('active');
        $('.tabs-boxs')
            .find(tabID)
            .fadeIn()
            .addClass('active')
            .siblings()
            .hide()
            .removeClass('active');
    });

    // DatePicker.
	if ( $('[data-toggle="datepicker"]').length > 0 ) {
		$('[data-toggle="datepicker"]').pickadate({
			format: 'dd mmm, yyyy',
			formatSubmit: 'yyyy-mm-dd',
            showMonthsShort: true,
            selectMonths: true,
            selectYears: true,
			onOpen: function () {
				// Chenge Datepicker position
				var pageHeight = $(document).height(); // 1361
				var inputOffsetTop = $('[data-toggle="datepicker"]').offset().top; // 1128
				var inputHeight = $('[data-toggle="datepicker"]').outerHeight(); // 38
				var datePickerHeight = 350; // 347
				var datePickerOffsetTop = -(inputHeight + datePickerHeight);
				if (pageHeight < (inputOffsetTop + datePickerHeight)) {
					$('.picker__holder').css({
						'top': datePickerOffsetTop,
					});
				}
			}
		});
	}

    // Sweet Alert 2
    $('form#add-newitem-form, form#settings-form, form#edit-image-gallery').on('submit', function (e) {
        e.preventDefault();
        var postType = $(this).data('post-type');
        Swal.fire({
            icon: 'success',
            title: 'Your ' + postType + ' has been Published',
            showConfirmButton: true,
            confirmButtonColor: 'var(--main-color)',
        });
    });

    // Save As Draft Alert
    $('form#add-newitem-form .draft').on('click', function (e) {
        e.preventDefault();
        var postType = $(this).data('post-type');
        Swal.fire({
            icon: 'success',
            title: 'Your ' + postType + ' has been Saved As Draft',
            showConfirmButton: true,
            confirmButtonColor: 'var(--main-color)',
        });
    });

    // Delete Alert
    $('form#add-newitem-form .delete').on('click', function (e) {
        e.preventDefault();
        var postType = $(this).data('post-type');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--main-color)',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your ' + postType + ' has been deleted.',
                    'success'
                )
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your ' + postType + ' is safe :)',
                    icon: 'error',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                })
            }
        })
    });

    // Close Gallery Overlay
    $('.gallery #close-overlay').on('click', function () {
        $('.gallery').fadeOut();
        $('html, body').css('overflow', 'visible');
    });

    // Open Gallery
    $('.gallery-btn').on('click', function (e) {
        e.preventDefault();
        $('.gallery').fadeIn();
        $('html, body').css('overflow', 'hidden');
		$(this).addClass('gallery-btn-clicked');
    });

    // Gallery Items Select in Gallery Popup
    $('.gallery .img-item').on('click', function (e) {
        $(this).addClass('selected').siblings().removeClass('selected');
    });

    // Select Button Action
    $('.gallery .select-btn').on('click', function () {
        // $(this).addClass('selected').siblings().removeClass('selected');
        var selectedImage = $('.gallery .img-item.selected').find('img').attr('src');
        $('.gallery-btn-clicked').next('.selected-img').find('.img-holder').append('<span class="overlay added" style="opacity:1;padding-top:0;color:#FFF;display: flex;justify-content: center;align-items: center;"><i class="rotate fi-rr-spinner" style="color:#FFF;margin: 0;width: 20px;height: 20px;transform-origin: center;text-align: center;line-height: 26px;"></i></span>')
        $('.gallery').fadeOut();
        $('html, body').css('overflow', 'visible');
        setTimeout(() => {
			$('.gallery-btn-clicked').next('.selected-img').find('.preview').attr('src', selectedImage);
            $('.gallery-btn-clicked').next('.selected-img').find('.img-holder').find('.added').fadeOut('100');
			$('.gallery-btn-clicked').removeClass('gallery-btn-clicked');
			$('.gallery .img-item.selected').removeClass('selected');
        }, 1000);
    });

	// Gallery Items Select in Gallery Page
	$('.gallery-page .img-item').on('click', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('selected')) {
            $(this).addClass('selected').siblings().removeClass('selected');
            $('.gallery-page .meta-box').removeClass('hide');
            $('.gallery-page .post-box').removeClass('open');
            var selectedImage = $('.gallery-page .img-item.selected').find('img').attr('src');
            $('.img-view img').attr('src', selectedImage);
        } else {
            $(this).removeClass('selected');
            $('.gallery-page .meta-box').addClass('hide');
            $('.gallery-page .post-box').addClass('open');
        }
    });

    // Toggle Addresses
    $(document).on('click', '.repeater-holder .repeater-title h5, .repeater-holder .repeater-title .icon', function () {
        $(this).parent().find('.icon').toggleClass('active');
        $(this).parents('.repeater').find('.repeater-inputs').slideToggle();
        $(this).parents('.repeater').siblings().find('.repeater-inputs').slideUp();
        $(this).parents('.repeater').siblings().find('.icon').removeClass('active');
    });

    // Add New Address 
    $('.add-repeater-item .btn').on('click', function () {
        $(".repeater-holder").append($(".repeater-holder .repeater:first").clone());
    });

	// Remove Address
	$(document).on('click', '.repeater-holder .remove', function () {
        $(this).parents('.repeater').remove();
    });

    // Generate Random Password
    $('.generate-password').on('click', function () {
        var possible = '',
            text = '';
        possible += 'abcdefghijklmnopqrstuvwxyz';
        possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        possible += '0123456789';
        // possible += '![]{}()%&*$#^<>~@|';
        possible += '!%&*$#^<>~@';
        for (var i = 0; i < 16; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        $('#password').val(text);
    });

    // Show Password
    $('.show-pass').on('click', function () {
        var type = $(this).prev('input').attr('type');
        if (type == 'password') {
            $(this).prev('input').attr('type', 'text');
            $(this).find('i').removeClass('fi-rr-eye').addClass('fi-rr-eye-crossed');
        } else {
            $(this).prev('input').attr('type', 'password');
            $(this).find('i').removeClass('fi-rr-eye-crossed').addClass('fi-rr-eye');
        }
    });

	// Detect Custom Date/Time Format
	$('[name="time_formate"], [name="date_formate"]').on('change', function() {
		let inputName = $(this).attr('name');
		if ( $(this).val() === 'custom' ) {
			$(`[name="${inputName}_custom"]`).removeAttr('disabled');
		} else {
			$(`[name="${inputName}_custom"]`).attr('disabled', 'disabled').val($(this).val());
		}
	});

	// Change Colors When Choose
	$('.form-control-color').on('input', function() {
		let cssVar = $(this).attr('name'),
			cssVarVal = $(this).val();
		$('html').get(0).style.setProperty('--' + cssVar, cssVarVal);
	});

	// Toggle Form Item
	$(".control-toggle").on('change', function() {
		const toggleWrapper = $(this).data('toggle');
		if ( $(this).is(':checked') ) {
			$(`#${toggleWrapper}`).addClass('d-flex').removeClass('d-none');
		} else {
			$(`#${toggleWrapper}`).removeClass('d-flex').addClass('d-none');
		}
	});

	// Download Invoice
	$('#download.btn').on('click', function() {
		var element = document.querySelector('.invoice');
		var fileName = 'invoice-no-' + $(this).data('invoice');
		var opt = {
			margin:       0.1,
			filename:     fileName + '.pdf',
			image:        { type: 'jpeg', quality: 1 },
			html2canvas:  { scale: 2 },
			jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
		};

		// New Promise-based usage:
		var worker = html2pdf().set(opt).from(element).save();
	});

	// Print Invoice
	$('#print.btn').on('click', function() {
		var restorepage = $('body').html();
		var printcontent = $('.invoice').clone();
		$('body').empty().html(printcontent);
		window.print();
		$('body').html(restorepage);
	});

	// Prevent Leave Page When User Make Changes on Form
    function preventLeavePage() {
        var isSubmitting = false,
            forms = $('form').not(".search-form, .bulk-form");
    
        forms.on('submit', function () {
            isSubmitting = true
        })
    
        forms.data('initial-state', forms.serialize());
    
        $('form').not(".search-form, .bulk-form").on('change', function () {
            $(window).on('beforeunload', function () {
                if (!isSubmitting && forms.serialize() != forms.data('initial-state')) {
                    return 'Changes you made may not be saved.';
                }
            });
        });
    }

});

// Swiper Slider
if ( $('.swiper-container').length > 0 ) {
	var swiper = new Swiper('.swiper-container', {
		freeMode: true,
		slidesPerView: 'auto',
		pagination: false,
		speed: 500,
		grabCursor: true,
		touchStartTime: 5000,
	});
}

// Function For Category Checklist
function checkboxFunctions() {
    const checkboxes = document.querySelectorAll(".my-checkbox");

    const checkboxActive = (el) => {
        el.querySelector(".my-checkbox__input").setAttribute('checked', 'checked');
        el.classList.add("my-checkbox--active");
        el.querySelector(".my-checkbox__icon").innerHTML = '<i class="fi-sr-checkbox"></i>';

    };

    const checkboxInactive = (el) => {
        el.querySelector(".my-checkbox__input").removeAttribute('checked');
        el.classList.remove("my-checkbox--active");
        el.querySelector(".my-checkbox__icon").innerHTML = '<i class="fi-rr-square"></i>';
    };

    checkboxes.forEach((checkbox) => {
        checkbox
            .querySelector(".my-checkbox__input")
            .addEventListener("input", () => {
                let state = checkbox.classList.contains("my-checkbox--active");
                if (state) {
                    checkboxInactive(checkbox);
                } else {
                    checkboxActive(checkbox);
                }
            });
    });
}

// Function For Parent Category Checklist
function radioBoxFunctions() {
    const radioBoxes = document.querySelectorAll(".my-radiobox");

    const radioBoxActive = (el) => {
        el.querySelector(".my-radiobox__input").setAttribute('checked', 'checked');
        el.classList.add("my-radiobox--active");
        el.querySelector(".my-radiobox__icon").innerHTML = '<i class="fi-ss-circle"></i>';

    };

    const radioBoxInactive = (el) => {
        el.querySelector(".my-radiobox__input").removeAttribute('checked');
        el.classList.remove("my-radiobox--active");
        el.querySelector(".my-radiobox__icon").innerHTML = '<i class="fi-rr-circle"></i>';
    };

    radioBoxes.forEach((radioBox) => {
        radioBox
            .querySelector(".my-radiobox__input")
            .addEventListener("input", () => {
                let state = radioBox.classList.contains("my-radiobox--active");
                if (!state) {
                    radioBoxes.forEach((item)=> {
                        radioBoxInactive(item);
                    })
                    radioBoxActive(radioBox);
                } 
            });
    });
}

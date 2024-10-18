(function ($, root, undefined) {
	$(function () {
		'use strict';
		// initializer
		const init = () => {
			startHeader();
			startAccordion();
			// startCarouselSwiper();
			startJoinForm();
		}
		init();
	});

	function startJoinForm () {
		const pfield = document.querySelector(".form input[name='password']");
		const pcfield = document.querySelector(".form input[name='confirm_password']");

		if (pfield) pfield.type = "password";
		if (pcfield) pcfield.type = "password";

		$(".form input[name='password']").on("input", function(e){
			pcfield.pattern = pfield.value;
		});

		$(".form input[name='confirm_password']").on("focusout", function(e){
			if (pcfield.value != pfield.value) {
				pcfield.value = '';
				pcfield.focus();
			}
		});
	}

	function startHeader () {

		$(".hamburger").on("click touch", function(e){
			$(this).toggleClass('active');
			$('.header-right').toggleClass('show');
		});

		// add nav icons
		var element = '<div class="nav-icon-container"><i class="fa fa-angle-down"></i></div>';
		$(".menu-item-has-children > a:first-of-type").append(element);

		// close submenu when hovering different element
		$("#main-menu > .menu-item").on("mouseenter focusin", function(){
			$('.menu-item-has-children').removeClass("open");
		});

		// prevent first click on mobile --->
		$(".menu-item-has-children").on("click touch", function(e){
			let target = $(e.currentTarget);
			if(!target.hasClass('open-mobile') && screen.width < 1300){
				e.preventDefault();
			}
			$(e.currentTarget).addClass("open-mobile");
		});

		// open submenu on hover
		$(".menu-item-has-children").on("mouseenter focusin", function(e){
        	$(e.currentTarget).addClass("open");
		});

		// close submenu on leave
		$("header").on("mouseleave", function(){
			$('.menu-item-has-children').removeClass("open");
			$('.menu-item-has-children').removeClass("open-mobile");
		});

		// open main menu
		const hamburgers = document.querySelectorAll(".hamburger");
		hamburgers.forEach((hamburger) => {
			hamburger.addEventListener("click", () => {
			const currentState = hamburger.getAttribute("data-state");

			if (!currentState || currentState === "closed") {
				hamburgers.forEach((ham) => {
					ham.setAttribute("data-state", "opened");
					ham.setAttribute("aria-expanded", "true");
				});
				$(".main-nav").addClass('open');
				$(".nav-overlay").addClass('open');
			} else {
				hamburgers.forEach((ham) => {
					ham.setAttribute("data-state", "closed");
					ham.setAttribute("aria-expanded", "false");
				});
				$(".main-nav").removeClass('open');
				$(".nav-overlay").removeClass('open');
			}
			});
		});
		// document.querySelector(".nav-overlay").addEventListener("click", () => {
		// 	hamburgers.forEach((ham) => {
		// 		ham.setAttribute("data-state", "closed");
		// 		ham.setAttribute("aria-expanded", "false");
		// 	});
		// 	$(".main-nav").removeClass('open');
		// 	$(".nav-overlay").removeClass('open');
		// });

		// submenu alignments
		let menuItems = document.querySelectorAll('#main-menu .menu-item-has-children');
		menuItems.forEach(menuItem => {
			let menuRight = window.innerWidth - menuItem.offsetLeft - (menuItem.offsetWidth / 2);

			let subItems = menuItem.querySelectorAll('.sub-menu > li');

			let totalWidth = 0;
			subItems.forEach(subItem => {
				totalWidth += subItem.offsetWidth;
			});

			let subRight = Math.max(menuRight - (totalWidth / 2), 0);
			subItems[subItems.length - 1].style.marginRight = subRight + 'px';
		});
	}

	// function stickyHeader() {
	// 	var header = document.getElementById("header");
	// 	var scroll = $(window).scrollTop();
	//   	if (scroll >= 100) {
	//     	header.classList.add("sticky");
	//   	} else {
	//     	header.classList.remove("sticky");
	//   	}
	// }
	let lastScrollTop = 0;
	window.addEventListener("scroll", function() {
		var header = document.getElementById("header");
		var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
		if (scrollTop > lastScrollTop) {
			header.classList.add('sticky');
		} else {
			header.classList.remove('sticky');
		}
		lastScrollTop = scrollTop;
	});

    function startAccordion(){
    	//FAQ
    	$(".accordion-loop .question").on("click touch", function(e){
    		$(".accordion-loop").not($(this).parent()).removeClass('expand');
    		$(this).parent().toggleClass('expand');
    	});
    	//Locations
    	$(".locations-loop .name").on("click touch", function(e){
    		$(".locations-loop").not($(this).parent()).removeClass('expand');
    		$(this).parent().toggleClass('expand');
    	});
    }


	$(".member-block.modal").on("click touch", function(e){
		$("body").addClass("overlay");
		$("body .member-bio .bio-container").remove();
		//get member data
		var member_id = $(this).attr('data-id');
        jQuery.ajax({
            type: 'POST',
            url: "/wp-admin/admin-ajax.php",
            dataType: "html",
            data: {
                action : 'get_ajax_member_data',
                'member-id' : member_id,
            },
            success: function( response ) {
             	$('#memberdata').append(response);
            },
            error: function(error){
            	console.log('error');
            }
        });
        $("body .member-bio").addClass('active');
        return false;
	});
	$("#biocross").on("click touch", function(e){
		closeTeamModal();
		return false;
	});

	function closeTeamModal(){
		$("body").removeClass("overlay");
		$("body .member-bio").removeClass('active');
		$("body .member-bio .bio-container").remove();
	}
	//Content Modal
	$(".modal-btn").on("click touch", function(e){
		const modalId = '#'+$(this).attr("data-id");
		$("body").addClass("overlay");
		$(modalId).addClass('active');
		return false;
	});
	$(".cross").on("click touch", function(e){
		closeContentModal();
		return false;
	});
	function closeContentModal(){
		$("body").removeClass("overlay");
		$("body .content-modal").removeClass('active');
	}
	//Video Modal
	$(".modal-video-btn").on("click touch", function(e){
		const modalId = '#'+$(this).attr("data-id");
		$("body").addClass("overlay");
		$(modalId).addClass('active');
		// var modal = modalId+" iframe";
		// var iframe = document.querySelector("#m1 iframe");
		// iframe.play();
		return false;
	});
	$(".videocross").on("click touch", function(e){
		const iframe = document.querySelector('.videocross ~ .content-container iframe');
		if (iframe) {
			const src = iframe.src;
			iframe.src = '';
			iframe.src = src;
		}
		closeVideoModal();
		return false;
	});
	function closeVideoModal(){
		$("body").removeClass("overlay");
		$("body .video-modal").removeClass('active');
	}

	//close modal on ESC key
	$(document).keydown(function(event) {
	  	if (event.keyCode == 27) {
	  		closeTeamModal();
			closeContentModal();
			closeVideoModal();
		}
	});

	//close modal on click outside modal
	document.addEventListener('click', (e) => {
		if($('body').hasClass("overlay")){
			modal = document.querySelector('.custom-modal');
	  		let clickInside = modal.contains(e.target)

	  		if (!clickInside) {
	     		closeTeamModal();
				closeContentModal();
				closeVideoModal();
	  		}
	  	}
	});

	$('input:checkbox').change(function(){
	    if($(this).is(":checked")) {
	        $(this).parent().parent().parent().parent().addClass("menuitemshow");
	    } else {
	        $(this).parent().parent().parent().parent().removeClass("menuitemshow");
	    }
	});

    //function startCarouselSwiper () {
		const swiper = new Swiper('.resource-swiper', {
			slidesPerView: 1,
			loop: true,
		  	spaceBetween: 80,
		  	pagination: {
		    	el: '.swiper-pagination',
		    	clickable: true
		  	},
		  	navigation: {
		    	nextEl: '.swiper-button-next',
		    	prevEl: '.swiper-button-prev',
		  	},
		  	breakpoints: {
	  			'0': {
			      	slidesPerView: 1.2,
			      	loop: false,
			      	spaceBetween: 20,
			    },
			    '768': {
			      	slidesPerView: 1,
			    },
			},
		});
		$(".custom-nav .next").on("click touch", function(e){
	    	$(".swiper-button-next").trigger("click");
	    	return false;
	    });
	    $(".custom-nav .prev").on("click touch", function(e){
	    	$(".swiper-button-prev").trigger("click");
	    	return false;
	    });
	//}

	var galleryThumbs = new Swiper('.gallery-thumbs', {
		spaceBetween: 10,
		slidesPerView: 5,
		freeMode: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: false,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
	  	},
		  breakpoints: {
			'0': {
				slidesPerView: 3,
		  },
		  '600': {
				slidesPerView: 5,
		  },
	  },
	});
	var galleryTop = new Swiper('.gallery-top', {
		spaceBetween: 10,

		thumbs: {
		  	swiper: galleryThumbs
		}
	});

	// Play video on click
	$(document).ready(function(){
		$("video").click(function() {
			$("video").each(function(){
				if (this !== event.target) {
					this.pause();
					$(this).removeClass("playing");
				} else {
					$(this).addClass('playing');
					this.play();
				}
			});
		});
	});

	//Play youtube video
	$(".playvideo").click(function(){
		$(this).addClass("playing");
		$(".playvideo iframe")[0].src += "&autoplay=1";
	});
	//Stop Youtube Video
	var originalIframeSrc = [];
	document.querySelectorAll('.gallery-top .swiper-slide iframe').forEach(function(iframe) {
		originalIframeSrc.push(iframe.src);
	});

	$(".gallery-thumbs .swiper-slide img").click(function(){
		var index = $(this).closest('.swiper-slide').index();
		var iframes = document.querySelectorAll('.gallery-top .swiper-slide iframe');
		iframes.forEach(function(iframe, i) {
			if (i === index) {
				var iframeSrc = iframe.src;
				iframe.src = iframeSrc;
			} else {
				iframe.src = originalIframeSrc[i];
			}
		});
	})

	window.addEventListener('scroll', scrollFunc, { passive: true });

	function scrollFunc() {
		//stickyHeader();
		var statistics = document.querySelectorAll('.increment-stat');
		if(statistics.length){
			statistics.forEach(statistic => {
				let stat = $(statistic);
				let startValue = 0;
				let endValue = stat.data('value');
				//let endValue = parseInt(statistic.textContent.replace(/[^0-9]/g, ""));

				var windowHeight = window.innerHeight;
				var elementTop = statistic.getBoundingClientRect().top;
				var elementVisible = 150;

				if (elementTop < windowHeight - elementVisible) {
					incrementStat(stat, startValue, endValue);
					stat.removeClass('increment-stat');
				}
			});
		}
		reveals = [".reveal-bottom"];
		for (var j = 0; j < reveals.length; j++) {
			var reveals1 = document.querySelectorAll(reveals[j]);
			for (var i = 0; i < reveals1.length; i++) {
				var windowHeight = window.innerHeight;
				var elementTop = reveals1[i].getBoundingClientRect().top;
				if (elementTop < windowHeight) {
					reveals1[i].classList.add("active");
				}
			}
		}
	}

	function timeout(ms) {
		return new Promise(resolve => setTimeout(resolve, ms));
	}

	async function incrementStat(stat, startValue, endValue){
		let start = startValue;
		let end = endValue.toLocaleString("en-US");
		var comma = end.indexOf(',');
		var partial = '';
		for(var num = 0; num < end.length; num++){
			var diff = end.length - partial.length;
			var loop = 2;
			if(num === 0){
				loop = 6;
			}
			for(var i = 0; i < loop; i++){
				if(end.charAt(num) === ','){
					break;
				}
				for(var j = 0; j < 10; j++){
					let temp = partial + j.toString().repeat(diff);
					if(comma !== -1){
						temp = temp.substring(0, comma) + ',' + temp.substring(comma + 1);
					}
					stat.html(temp);
					await timeout(1);
				}
			}
			partial = partial + end.charAt(num);
		}
		stat.html(partial);
	}

	//custom-dropdown-handler
	const url = window.location.href;
	console.log(url.includes('/fr'));
	if(url.includes('/fr')){
		const selectedValue = document.querySelector(".selected-value");
		selectedValue.textContent = 'fr';
	}

	const customSelect = document.querySelector(".custom-select");
	const selectBtn = document.querySelector(".select-button");

	const selectedValue = document.querySelector(".selected-value");
	const optionsList = document.querySelectorAll(".select-dropdown li");

	selectBtn.addEventListener("click", () => {
	  	customSelect.classList.toggle("active");
	  	selectBtn.setAttribute(
	    	"aria-expanded",
	    	selectBtn.getAttribute("aria-expanded") === "true" ? "false" : "true"
	  	);
	});


	$(document).ready(function() {
		$(".reveal-bottom").not($('.hero-container.plain + section .reveal-bottom')).removeClass('active');
		$(".hero-container.plain + section.reveal-bottom").addClass("active");
		$(".privacy-policy .simple-content .reveal-bottom").addClass("active");
	});

})(jQuery, this);


// Post Filter
function categoryfunction(obj){
	var post = jQuery(".post-type").val();
    var cat_val = [];
    jQuery.each(jQuery("input[name='category']:checked"), function(){
        cat_val.push(jQuery(this).val());
    });

    var page = 1;
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        dataType: 'html',
        data: {
            'cat-val' : cat_val,
            'post-type' : post,
            page : page,
            action : 'get_ajax_post',
        },
        beforeSend: function (xhr) {
        	jQuery("body").addClass("overlay");
        	jQuery(".spinner").addClass("show");
        },
        success: function( response ) {
        	jQuery("body").removeClass("overlay");
        	jQuery(".spinner").removeClass("show");
            jQuery('.listing').remove();
            jQuery('.listing-data').html( response );
        }
    });
    return false;
}

jQuery( "#clearfilter" ).click( function () {
	var post = jQuery(".post-type").val();
    var cat_val = '';
    var page = 1;
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        dataType: 'html',
        data: {
        	'cat-val' : cat_val,
        	'post-type' : post,
        	page : page,
            action : 'get_ajax_post',
        },
        beforeSend: function (xhr) {
            jQuery("body").addClass("overlay");
        	jQuery(".spinner").addClass("show");
        },
        success: function( response ) {
        	jQuery("body").removeClass("overlay");
        	jQuery(".spinner").removeClass("show");
            jQuery('.filter input[type="checkbox"]').prop('checked', false);
            jQuery('.listing').remove();
            jQuery('.listing-data').html( response );
        }
    });
    return false;
});

jQuery("#searchform").submit(function(e) {
	var post = jQuery(".post-type").val();
	var cat_val = '';
	var search = jQuery("#searchtext").val();
    var page = 1;
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        dataType: 'html',
        data: {
            'cat-val' : cat_val,
            'post-type' : post,
            page : page,
            'search-val' : search,
            action : 'get_ajax_post',
        },
        beforeSend: function (xhr) {
        	jQuery("body").addClass("overlay");
        	jQuery(".spinner").addClass("show");
        },
        success: function( response ) {
        	jQuery("body").removeClass("overlay");
        	jQuery(".spinner").removeClass("show");
            jQuery('.listing').remove();
            jQuery('.listing-data').html( response );
        }
    });
    return false;
});

jQuery( ".page-numbers" ).click( function () {
	var post = jQuery(".post-type").val();
    var cat_val = [];
    jQuery.each(jQuery("input[name='category']:checked"), function(){
        cat_val.push(jQuery(this).val());
    });
    var curent_page = jQuery(".page-numbers.current").text();
    var page = jQuery(this).text();
    if(jQuery(this).hasClass("next")){
    	page = parseInt(curent_page) + parseInt(1);
    }
    if(jQuery(this).hasClass("prev")){
    	page = parseInt(curent_page) - parseInt(1);
    }
    jQuery.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        dataType: 'html',
        data: {
            'cat-val' : cat_val,
            'post-type' : post,
            page : page,
            action : 'get_ajax_post',
        },
        beforeSend: function (xhr) {
            jQuery("body").addClass("overlay");
        	jQuery(".spinner").addClass("show");
        },
        success: function( response ) {
        	jQuery("body").removeClass("overlay");
        	jQuery(".spinner").removeClass("show");
            jQuery('.listing').remove();
            jQuery('.listing-data').html( response );
        }
    });
    jQuery('.page-numbers').removeClass('current');
    jQuery(this).addClass('current');
		document.querySelector('.listing-data').scrollIntoView();
    return false;
});

// Google Map functionality
function initMap() {
	let location = { lat: 45.42122934988226, lng: -75.69708898814712 };
	// JSON styles
	const options = [
		{
			"elementType": "labels.icon",
			"stylers": [
			{
				"color": "#767676"
			}
			]
		},
		{
			"elementType": "labels.text.fill",
			"stylers": [
			{
				"color": "#616161"
			}
			]
		},
		{
			"elementType": "labels.text.stroke",
			"stylers": [
			{
				"color": "#f5f5f5"
			}
			]
		},
		{
			"featureType": "administrative.land_parcel",
			"elementType": "labels.text.fill",
			"stylers": [
			{
				"color": "#bdbdbd"
			}
			]
		},
		{
			"featureType": "poi",
			"elementType": "geometry",
			"stylers": [
			{
				"color": "#eeeeee"
			}
			]
		},
		{
			"featureType": "poi",
			"elementType": "labels.text.fill",
			"stylers": [
			{
				"color": "#757575"
			}
			]
		},
		{
			"featureType": "poi.park",
			"elementType": "geometry",
			"stylers": [
			{
				"color": "#e5e5e5"
			}
			]
		},
		{
			"featureType": "poi.park",
			"elementType": "labels.text.fill",
			"stylers": [
			{
				"color": "#9e9e9e"
			}
			]
		},
		{
			"featureType": "road.local",
			"elementType": "labels.text.fill",
			"stylers": [
			{
				"color": "#9e9e9e"
			}
			]
		},
		{
  			featureType: "landscape.man_made.building",
  			elementType: "geometry.fill",
  			stylers: [
    			{ color: "#efefef"}
    		]
		},
	]
	// The map
	const map = new google.maps.Map(document.getElementById("map"), {
		zoom: 17,
		center: location,
		styles: options,
		maptype: 'roadmap',
		mapTypeControl: true,
		draggable: true,
	});
	// The marker
	const customIconUrl = '/wp-content/themes/operatic/img/hac-pin.png';
	const marker = new google.maps.Marker({
		position: location,
		map: map,
		icon: {
			url: customIconUrl
		}
	});
}
window.initMap = initMap;

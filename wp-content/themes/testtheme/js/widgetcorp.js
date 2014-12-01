// When the DOM is ready
jQuery(function() {


    jQuery(".scroll").click(function(event) {
        event.preventDefault();
        jQuery('html,body').animate({scrollTop: jQuery(this.hash).offset().top}, 1000);
    });

    jQuery().UItoTop({easingType: 'easeOutQuart'});


});
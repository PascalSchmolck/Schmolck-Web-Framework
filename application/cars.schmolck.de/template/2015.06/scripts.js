$(document).ready(function() {
    /*
     * ANIMATIONS
     */
    $('.alert').fadeIn('slow');

    // - progress bar on link clicks
    $('a').click(function() {
        var objProgress = $('body').find('.progress');        
        objProgress.slideDown();
    });
});
/**
 * Schmolck_Framework_Helper_Element
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 * 
 * @param {array} parameter various parameters
 */
var nProgressCounter = 0;

function Schmolck_Framework_Helper_Element(parameter) {
    /*
     * INITIALISATION
     */
    var objElement = $('#' + parameter.id);
    var objProgress = $('body').find('.progress');

    /*
     * PROGRESS BAR
     */
    objProgress.slideDown();
    nProgressCounter++;

    /*
     * AJAX
     */
    $.ajax({
        type: "POST",
        url: parameter.url,
        data: '_ajax=true&_id=' + parameter.id + '&' + parameter.data,
        success: function (data) {

            /*
             * DATA
             */
            objElement.replaceWith(data);

            /*
             * ACTION
             */
            if (parameter.success instanceof Function) {
                parameter.success(data);
            }
            
            /*
             * PROGRESS BAR
             */
            nProgressCounter--;
            if (nProgressCounter === 0) {
                objProgress.slideUp();
            }            
        }
    });
}
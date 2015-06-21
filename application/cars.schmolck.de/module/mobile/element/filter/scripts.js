$(document).ready(function () {

    /*
     * EVENTS
     */
    $('#SchmolckID select').change(function () {
        // - reset model selection if brand changed
        if ($(this).attr('name') === 'brand') {
            $('#SchmolckID select[name=model]').val('all');
        }
        SchmolckID_send();
        return false;
    });

    $('#SchmolckID input[type=button]').click(function () {
        SchmolckID_reloadResult();
        return false;
    });

    $('#SchmolckID input[type=reset]').click(function () {
        $('#SchmolckID input[name=reset]').val('true');
        SchmolckID_reset();
        return false;
    });

    /*
     * FUNCTIONS
     */
    SchmolckID_send = function () {
        var strData = $('#SchmolckID form').serialize();
        Schmolck_Framework_Helper_Element({
            url: 'SchmolckURL',
            id: 'SchmolckID',
            data: strData,
            success: function () {
                SchmolckID_checkCounter();
                SchmolckID_reloadResult();
            }
        });
    };

    SchmolckID_reset = function () {
        var strData = $('#SchmolckID form').serialize();
        Schmolck_Framework_Helper_Element({
            url: 'SchmolckURL',
            id: 'SchmolckID',
            data: strData,
            success: function () {
                SchmolckID_reloadResult();
            }
        });
    };

    SchmolckID_checkCounter = function () {
        if ($('#SchmolckID input[name=counter]').val() == '0') {
            SchmolckID_reloadResult();
        }
    }

    SchmolckID_reloadResult = function () {
        var objResult = $('#SchmolckRESULTID');
        if (objResult) {
            Schmolck_Framework_Helper_Element({
                url: 'mobile/element/result',
                id: 'SchmolckRESULTID'
            });
        }
    };
});
$(document).ready(function () {
    /*
     * ACTION
     */
    $('#SchmolckID input[name=request]').click(function () {
        $('#SchmolckID input[name=name]').focus();
    });

    $('#SchmolckID input[name=print]').click(function () {
        window.print();
    });
});
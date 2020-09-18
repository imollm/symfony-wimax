'use strict'

$(document).ready(function () {

    deleteModalGetUserId();

});

function deleteModalGetUserId(){

    $("#users-table > tbody > tr > td.d-flex.justify-content-between > a:nth-child(3)").on("click", function() {
        var btnId = $(this).prop('id');
        var userId = btnId.split('-');
        
        var modalButtonDelete = $('#exampleModal > div > div > div.modal-footer > a');
        var modalUrl = 'http://wimax.com.devel/user/delete/' + userId[1];

        modalButtonDelete.attr('href', modalUrl);
    });
    
}

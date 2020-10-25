'use strict'

$(document).ready(function () {

    const host = 'http://wimax.com.devel/';

    deleteModalGetUserId(host);

    hideFormInputsOfNewPayment();

    getUsers(host);

    showOtherInputsWhenUserIsClicked(host);

    disableAntennaInputWhenIsSelected();

});

function deleteModalGetUserId(host){

    $("#users-table > tbody > tr > td.d-flex.justify-content-between > a:nth-child(3)").on("click", function() {
        var btnId = $(this).prop('id');
        var userId = btnId.split('-');
        
        var modalButtonDelete = $('#exampleModal > div > div > div.modal-footer > a');
        var modalUrl = host + 'user/delete/' + userId[1];

        modalButtonDelete.attr('href', modalUrl);
    });
    
}

function hideFormInputsOfNewPayment() {
    
    const totalNumberOfInputs = 6;

    for (let input = 2; input <= totalNumberOfInputs ; input++) {
        $('#create_payment > div:nth-child('+ input +')').hide();
    }
}

function getUsers(host) {
    let url = host + 'getUsers';

    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            let users = JSON.parse(response);
            console.log(users);
            if (users.length < 0) {
                window.location.href = host;
            }else {
                let selectOfUsers = $('#create_payment_user');
                users.forEach(element => {
                    selectOfUsers.append('<option value="' + element.id + '">' + element.name + '</option>');
                });
            }
        },
        beforeSend: function () {
            console.log('Get users form ' + url);
        },
        error: function (err) {
            console.error(err);
        }
    });
}

function showOtherInputsWhenUserIsClicked(host) {
    $('select#create_payment_user').on('change', function () {
        var form = $('#create_payment');
        let userId = $(this).val();

        let url = host + 'user/' + userId + '/antennas';

        // $(this).attr('disabled', 'disabled');

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function (response) {
                console.log(response);
                
                var antennas = response.antennas;
                
                if (antennas.length > 0) {
                    var labelAntennas = $('label').attr('for', 'create_payment_antennas');
                    var inputAntennas = $('#create_payment_antenna');

                    if (inputAntennas.length > 0) {
                        labelAntennas.remove();
                        inputAntennas.remove();
                    }

                    var createInputAntennas = 
                    '<div>'+
                        '<label for="create_payment_user" class="required">Antenas</label>'+
                        '<select id="create_payment_antenna" name="antenna" class="mb-4 form-control">';
                    
                    antennas.forEach(antenna => {
                        createInputAntennas += '<option value="'+ antenna.id +'">' + antenna.name + '</option>';
                    });

                    createInputAntennas += '</select></div>';

                    $('#create_payment_user').after(createInputAntennas);

                    $(form).find('div').show();

                }else{
                    window.location.href = 'http://wimax.com.devel/';
                }
            },
            beforeSend: function() {
                console.log('Request user antennas -> ' + url);
            },
            error: function(err) {
                console.error(err);
            }
        });
    });
}

function disableAntennaInputWhenIsSelected() {
    $('select#create_payment_antenna').on('click', function () {
        console.log('Change on Antenna');
    });
}



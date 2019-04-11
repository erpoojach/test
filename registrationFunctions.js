/*
 * Catabatic Technology Pvt. Ltd.
 * File Name :registrationFunctions.js
 * File Description :registrationFunctions contains all data related to agency registration process
 * Created By : Pooja Choudhary
 * Created Date: 02-June-2016
 */

$(document).ready(function () {
    //mobileNoLength.    
    $.validator.addMethod("mobileNoLength", function (value, element) {
        return this.optional(element) || (value.length == 10);
    }, "Please enter a valid number.");

    $.validator.addMethod("noStartEndWhiteSpaces", function (value, element) {
//        return this.optional(element) || /^[a-zA-Z0-9](?:[a-zA-Z0-9 ]*[a-zA-Z0-9])?$/.test(value);
    return this.optional(element) || !(/^\s+|\s+$/g.test(value));
    }, "Spaces are not allowed.");

    $.validator.addMethod("imageUploadRequired", function (value, element) {
        if ($('#submitbutton').attr('name') == 'edit' || value != '')
        {
            return true;
        }
        return false;
    }, "Please upload required file.");
    
    $.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
    },'Contact name must contains letters.');
    
//    jQuery.validator.addMethod("alphanumeric", function(value, element) {
//        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
//}, "Please upload required file."); 

    $("#AgencyRegisterForm").validate({
//        debug: true,
        highlight: function (error, element) {
            var name = $(element).attr("name");
            $("input[name=" + name + "]").removeClass('error');

        },
        rules: {
            "agencyName": {
                required: true,
                noStartEndWhiteSpaces: true
            },
            "selectCountry": {
                required: true,
                noStartEndWhiteSpaces: true
            },
//            "selectState": {
//                required: true
//            },
            "selectCity": {
                required: true,
                noStartEndWhiteSpaces: true
            },
            "contactName": {
                required: true,
                noStartEndWhiteSpaces: true,
                alpha: true
            },
            "emailId": {
                required: true,
                email: true,
                remote: '/register/email-exists'
//                remote: {
//                    type: 'post',
//                    url: '/register/email-exists',
//                    data: {
//                        'emailId': function () {
//                            //console.log($('#emailId').val());
//                            return $('#emailId').val();
//                        }
//                    },
//                    dataType: 'json'
//                }
                        //remote: "agency/email-exists"
            },
            "mobileNo": {
                required: true,
//                mobileNoLength: true,
                number: true,
                noStartEndWhiteSpaces: true
            },
            "captcha": {
                required: true
            }
        },
        messages: {
            "agencyName": {
                required: 'Please enter agency name.'
            },
            "selectCountry": {
                required: 'Please enter country name.'
            },
//            "selectState": {
//                required: 'Please select state.'
//            },
            "selectCity": {
                required: 'Please enter city name.'
            },
            "contactName": {
                required: 'Please enter contact name.',
                alpha: 'Contact name must contains letters.'
                
            },
            "emailId": {
                required: 'Please enter email id.',
                email: 'Please enter a valid email id.',
                remote: 'Email id already exists.'
            },
            "mobileNo": {
                required: 'Please enter mobile number.'
            },
            "captcha": {
                required: 'Please enter captcha.'
            }
        },
        submitHandler: function () {
            saveRegisterDetails();
        }
    });
});
function saveRegisterDetails() {
    var regData = $('#AgencyRegisterForm').serialize();
    // alert(regData);
    $.ajax({
        url: '/register/save-sign-up',
        data: regData,
        method: 'POST',
//        dataType: 'json',
        
        beforeSend: function () {
            $('#loaderimg').css('display', 'block');
        },
        success: function (response) {
            if (response == 1) {
                $('.registerform').hide();
                $('.registermessage').show();
            } else if (response == 2) {
                $('#dispMessage').html('This email id already registered with us.').css('display', 'block');
            } else if(response == 3) {
                $('#dispMessage').html('Captcha code invalid.').css('display', 'block');
            } else {
//                $('#dispMessage').html(response).delay(30000).fadeOut();
//                $('#dispMessage').html(response).css('display', 'block');
            $('#dispMessage').html('There has been error, Please try again later.').css('display', 'block');
            }
            $('#dispMessage').delay(3000).fadeOut();
            $('#loaderimg').css('display', 'none');
        }
    }).complete(function () {
//            $('#loaderimg').css('display','block');        
    });

    return true;
}


function registration_process(count) {
//    alert(count);

    if (count == 5) {
        var regFormData = ['<h4 class="col-md-12"><i class="fa fa-smile-o large-icon orange"></i><br /><br />',
            'You are successfully <span class="orange text-uppercase">registered</span> as a partner,<br />',
            '<p class="panel-body">We shall send you an email shortly post activation of your account.</p>',
            '</h4>',
            '<div class="clear">&nbsp;</div> '].join('');
        $('.leadeBorder').empty().html(regFormData).addClass('text-center');
        history.pushState({page: 1}, "Title 1", "#no-back");
        window.onhashchange = function (event) {
            window.location.hash = "no-back";
        };

    }
    else  if (count == 6) {
        var regFormData = ['<h4 class="col-md-12"><i class="fa fa-smile-o large-icon orange"></i><br /><br />',
            'Your activation link is <span class="orange text-uppercase">expired</span> <br />',
            '<p class="panel-body">Please contact to our Help Center.</p>',
            '</h4>',
            '<div class="clear">&nbsp;</div> '].join('');
        $('.leadeBorder').empty().html(regFormData).addClass('text-center');
        history.pushState({page: 1}, "Title 1", "#no-back");
        window.onhashchange = function (event) {
            window.location.hash = "no-back";
        };
    } 
    else {
        var regFormData;
        switch (count) {
//        case 1:
//            regFormData = 'verify-contact';
//            break;
            case 2:
                regFormData = 'personal-details';
                break;
            case 3:
                regFormData = "company-details";
                break;
            case 4:
                regFormData = "more-about-company";
                break;
            default:
                regFormData = 'verify-contact';
                break;
        }

        var percent = count * 25;
        var regEmail = $('#regEmail').val();
        var progressBarData = ['<div class="col-md-12  text-center"><span class="col-md-12 no-padding" style="margin:5px 0px;">Your Registration Status</span>',
            '<div class="col-md-12 no-padding">',
            '<div class="progress progress-striped active no-margin" style="border-radius:10px;">',
            '<div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: ' + percent + '%; border-radius:10px;">',
            '<span class="sr-only">' + percent + '% Complete</span>',
            '</div>',
            ' </div>',
            '</div>',
            ' <span class="col-md-12 no-padding" style="margin:5px 0px;">' + count + '/4</span></div>'].join('');

        $('#regProcessProgressBar').html(progressBarData);
        $(".regProcessJs").removeClass('selected').addClass('done');
        $("#regProcessJs" + count).addClass('selected').removeClass('done');
        $("#regFormsData").load('/register/' + regFormData, {data: regEmail});
        //  console.log($(".regProcessJs").removeClass('done'));
//    console.log(regEmail);
    }
}


$(document).ready(function () {
    $.validator.addMethod("validPhoneCode", function (value, element) {
        return this.optional(element) || (/^\+?\d+$/.test(value)) || (/([0-9]{3})$/.test(value));
    }, "Invalid No.");
    $.validator.addMethod('filesize', function (value, element, param) {
        // param = size (in bytes) 
        // element = element to validate (<input>)
        // value = value of the element (file name)
        return this.optional(element) || (element.files[0].size <= param)
    },'File should be less than 1 MB');
    $.validator.addMethod("SendersEmailVerify",function(){
        $('#lforsenderEmailId').css('display','inline-block');
                    if ($('#regEmail').val() === $('#senderEmailId').val()) {
                        return true;
                    }  if ($('#IsEmailIdForCustVarified').val() == 1 && $('#senderEmailId').val() == $('#OldIdforCustomer').val()) {
                        return true;
                    }  else {
                        $('#lforsenderEmailId').css('display','none');
                        return false;
                    }
    }, "Sender's email id is not verified. Please <a onClick='validateEmail();'> Verify</a> Now");

    $("#AgencyPersonalDetailsForm").validate({
        errorPlacement: function (error, element) {
            //console.log(element.attr("name"));
            if (element.attr("name") == "photoIdProof") {
                error.appendTo("#errorPlacement1");
            } else if (element.attr("name") == "photoIdProofFile") {
                error.appendTo("#errorPlacement2");
            } else if (element.attr("name") == "senderEmailId") {
                error.appendTo('#senderEmailIderr');
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (error, element) {
            var name = $(element).attr("name");
            $("input[name=" + name + "]").removeClass('error');
        },
        rules: {
            "1_firstName": {
                required: true,
                noStartEndWhiteSpaces: true
            },
            "1_lastName": {
                required: true,
                noStartEndWhiteSpaces: true
            },
            "1_designation": {
                required: true,
                noStartEndWhiteSpaces: true
            },
            "1_cCode": {
                required: true,
                validPhoneCode: true
            },
            "1_contactNo": {
                required: true,
//                mobileNoLength: true,
                number: true,
                noStartEndWhiteSpaces: true
            },
//            "1_mCode": {
//                required: true,
//                validPhoneCode: true
//            },
//            "1_mobileNo": {
//                required: true,
////                mobileNoLength: true,
//                number: true,
//                noStartEndWhiteSpaces: true
//            },
            "1_emailId": {
                required: true,
                email: true
                        //remote: "agency/email-exists"
            },
            "photoIdProof": {
                required: true
            },
            "photoIdProofFile": {
//                required: true,
                imageUploadRequired: true,
                accept: 'gif|jpg|png|jpeg|pdf',
                filesize: 1048576
            },
            "2_firstName": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                noStartEndWhiteSpaces: true
            },
            "2_lastName": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                noStartEndWhiteSpaces: true
            },
            "2_designation": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                noStartEndWhiteSpaces: true
            },
            "2_cCode": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                validPhoneCode: true
            },
            "2_contactNo": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                mobileNoLength: true,
                number: true,
                noStartEndWhiteSpaces: true
            },
            "2_mCode": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                validPhoneCode: true
            },
            "2_mobileNo": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                mobileNoLength: true,
                number: true,
                noStartEndWhiteSpaces: true
            },
            "2_emailId": {
                required: {
                    depends: function () {
                        return $('input[name=isSameAsPrimaryContact]:checked').val() == 'No';
                    }
                },
                email: true,
//                remote: '/staff/email-exists?emailId=' + $('input[name=2_emailId]').val() + '&StaffUserId=' + $('#operationalContactId').val()
            },
            "senderEmailId": {
                required: true,
                SendersEmailVerify : true,
                email: true
            }
        },
//        debug: true,
        messages: {
            "1_firstName": {
                required: 'Please enter first name.'
            },
            "1_lastName": {
                required: 'Please enter last name.'
            },
            "1_designation": {
                required: 'Please enter designation.'
            },
            "1_cCode": {
                required: 'Enter code.',
                number: 'Invalid Code.'
            },
            "1_contactNo": {
                required: 'Please enter mobile number.',
                number: 'Invalid Contact No.'
            },
//            "1_mCode": {
//                required: 'Enter code.',
//                number: 'Invalid Code.'
//            },
//            "1_mobileNo": {
//                required: 'Please enter mobile number.',
//                number: 'Invalid mobile no.'
//            },
            "1_emailId": {
                required: 'Please enter email id.',
                email: 'Please enter a valid email id.'
                        //remote: 'Email id already registered with us.'
            },
            "photoIdProof": {
                required: 'Please select photo id proof name.'
            },
            "photoIdProofFile": {
                required: 'Please upload required file.',
                accept: "Please upload valid extension. Ex gif,jpg,png,jpeg,pdf",
            },
            "2_firstName": {
                required: 'Please enter first name.'
            },
            "2_lastName": {
                required: 'Please enter last name.'
            },
            "2_designation": {
                required: 'Please enter designation.'
            },
            "2_cCode": {
                required: 'Enter code.',
                number: 'Invalid Code.'
            },
            "2_contactNo": {
                required: 'Please enter contact number.',
                number: 'Invalid contact no.'
            },
            "2_mCode": {
                required: 'Enter code.',
                number: 'Invalid Code.'
            },
            "2_mobileNo": {
                required: 'Please enter mobile number.',
                number: 'Invalid mobile no.'
            },
            "2_emailId": {
                required: 'Please enter email id.',
                email: 'Please enter a valid email id.',
//                remote: 'Email id already exists.'
            },
            "senderEmailId": {
                required: 'Please enter email id.',
                email: 'Please enter a valid email id.'
            }
        },
//        submitHandler: function () {
//            alert($('#regEmail').val());
//            alert($('#IsEmailIdForCustVarified').val());
//            alert($('#senderEmailId').val());
//            
////            saveAgencyPersonalDetails();
////            registration_process(3);
//        }
    });
});



function saveAgencyPersonalDetails() {

    var formData = $("#AgencyPersonalDetailsForm").serialize();
    //alert(formData);
    $.ajax({
        url: '/register/save-personal-details',
        data: formData,
        method: 'POST',
        type: 'json',
        error: function () {

        },
        beforeSend: function () {

        },
        success: function (response) {
            registration_process(3);

        }
    });
}


function getState() {
    var CountryID = $('#selectCountry').val();
    if (CountryID != '') {
        $.ajax({
            url: '/register/get-state',
            data: {CountryID: CountryID},
            method: 'POST',
            error: function (err) {
                alert(err);
            },
            beforeSend: function () {

            },
            success: function (response) {
                $('#selectState').html(response);
            }
        });
    }

}

function getCity() {
    var StateId = $('#selectState').val();
    var CountryID = $('#selectCountry').val();
//    if (StateId != '') {
    $.ajax({
        //url: '/register/get-city-by-state',
        url: '/register/get-city-list',
        data: {CountryID: CountryID},
        method: 'POST',
        error: function (err) {
            alert(err);
        },
        beforeSend: function () {

        },
        success: function (response) {
            $('#selectCity').html(response);
        }
    });
//    }

}


function getState2() {
    var CountryID = $('#selectCountry2').val();
    if (CountryID != '') {
        $.ajax({
            url: '/register/get-state',
            data: {CountryID: CountryID},
            method: 'POST',
            error: function (err) {
                alert(err);
            },
            beforeSend: function () {

            },
            success: function (response) {
                $('#selectState2').html(response);
            }
        });
    }

}

function getCity2() {
    var StateId = $('#selectState2').val();
    if (StateId != '') {
        $.ajax({
            url: '/register/get-city-by-state',
            data: {StateId: StateId},
            method: 'POST',
            error: function (err) {
                alert(err);
            },
            beforeSend: function () {

            },
            success: function (response) {
                $('#selectCity2').html(response);
            }
        });
    }

}



function getState3() {
    var CountryID = $('#selectCountry3').val();
    if (CountryID != '') {
        $.ajax({
            url: '/register/get-state',
            data: {CountryID: CountryID},
            method: 'POST',
            error: function (err) {
                alert(err);
            },
            beforeSend: function () {

            },
            success: function (response) {
                $('#selectState3').html(response);
            }
        });
    }

}

function getCity3() {
    var StateId = $('#selectState3').val();
    if (StateId != '') {
        $.ajax({
            url: '/register/get-city-by-state',
            data: {StateId: StateId},
            method: 'POST',
            error: function (err) {
                alert(err);
            },
            beforeSend: function () {

            },
            success: function (response) {
                $('#selectCity3').html(response);
            }
        });
    }

}





//hideModal is used to hide a model by model id
$(document).ready(function () {

    $('input[type="radio"]').click(function () {
        var inputValue = $(this).attr("value");
        if (inputValue === "yes") {
            $(".check").toggle();
            $(".box1").toggle();
        }

        if (inputValue === "no") {
            $(".check").hide();
        }
        if (inputValue === "no") {
            $(".box1").hide();
        }
    });
    
    if($('.checkgst').is(':checked')) {
        var yes = $('.yes').is(":checked");
        var no = $('.no').is(":checked");
        if(yes === true){
            $(".check").toggle();
            $(".box1").toggle();
        }
        if(no === true){
            $(".check").hide();
            $(".box1").hide();
        }
    }
    
    var hidden_selected_country_id = $('#hidden_selected_country_id').val();
    if(hidden_selected_country_id === '101'){
        $('#state').removeAttr('disabled', true);
    }else{
        $('#state').val('');
        $('#hidden_selected_states_id').val('');
        $('#state').attr('disabled', true);
    }

});
function hideModal(id) {
    $('#' + id).modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}


function supplier_process(count) {

    var supplierFormData;

    var SupplierUserId = $('#SupplierUserId').val();
    if (!SupplierUserId) {
        supplierFormData = 'supplier-overview';
    } else {
        switch (count) {
            case 2:
                supplierFormData = 'supplier-contacts';
                break;
            case 3:
                supplierFormData = "supplier-bank-details";
                break;
            default:
                supplierFormData = 'supplier-overview';
                break;
        }

        $(".supplierProcessJs").removeClass('selected').addClass('done');
        $("#supplierProcessJs" + count).addClass('selected').removeClass('done');
        var titleDesc = $("#stepDesc" + count).text();
        $("#supplierProcessTitle").text(titleDesc);
    }

    $("#supplierFormsData").load('/supplier/' + supplierFormData, {id: SupplierUserId});
    //  console.log($(".supplierProcessJs").removeClass('done'));
//    console.log(regEmail);
}


function getCountryList() {
    $("input[name=country]").autocomplete({
        source: '/register/autosuggest-country',
        minLength: 3,
        focus: function (event, ui) {
            event.preventDefault();
            //alert(ui.item.value);               
            $("#tags").val(ui.item.label);

        },
        select: function (event, ui) {
            event.preventDefault();
            $("input[name=country]").val(ui.item.label);
            $("#hidden_selected_country_id").val(ui.item.value).trigger('change');
            //set city blank
            $("input[name=city]").val('');
            $("#hidden_selected_city_id").val('');

        }
    });


}
//    $().ready(function() { 
function getCityList() {
    $('#hidden_selected_city_id').val('');
    var countryId = $('#hidden_selected_country_id').val();

    $("input[name=city]").autocomplete({
        source: "/register/autosuggest-city?countryId=" + countryId,
        minLength: 3,
        focus: function (event, ui) {
            event.preventDefault();
            $("#tags").val(ui.item.label);
        },
        select: function (event, ui) {
            event.preventDefault();
            $("input[name=city]").val(ui.item.label);
            $("#hidden_selected_city_id").val(ui.item.value).trigger('change');

        }
    });

}


//common (Custom) methods for validations
$(document).ready(function () {
    $.validator.addMethod("noStartEndWhiteSpaces", function (value, element) {
//        return this.optional(element) || /^[a-zA-Z0-9](?:[a-zA-Z0-9 ]*[a-zA-Z0-9])?$/.test(value);
        return this.optional(element) || !(/^\s+|\s+$/g.test(value));
    }, "Spaces are not allowed.");

//mobileNoLength.    
    $.validator.addMethod("mobileNoLength", function (value, element) {
        return this.optional(element) || (value.length == 10);
    }, "Please enter a valid number.");

});

//Validations on add/edit supplier
$(document).ready(function () {
    //remove onchange messages 
    $('#salution,#suppliertype,#supplierservices').change(function () {
        $(this).parent().children('label').text('');
    });
    
    $.validator.addMethod("noSpecialChars", function(value, element) {
      return this.optional(element) || /^[a-z0-9\s\_\,\-\.]+$/i.test(value);
  }, "No special character allowed!");


    $("#overviewRegForm").validate({
        highlight: function (error, element) {
            var name = $(element).attr("name");
            $("input[name=" + name + "]").removeClass('error');
        },
        rules: {
            "companyName": {
                required: true
//                noStartEndWhiteSpaces: true
            },
            "checkRadio": {
                required: true
            },
            "selectRadio": {required: {
                    depends: function () {
//                        if( $(".selectRadio").is(':checked')){
                        if ($("input[name='checkRadio']" === "yes").is(':checked')) {
                            return true;
                        }
                    }
                }},
            //"selectRadio":{
            //    required:true
            //},
            "salution": {
                required: true
            },
            "firstName": {
                required: true
//                noStartEndWhiteSpaces: true
            },
//            "lastName": {
//                required: true
////                noStartEndWhiteSpaces: true
//            },
            "designation": {
                required: true
//                noStartEndWhiteSpaces: true
            },
            "email": {
                required: true,
                email: true

            },
            "mobileno": {
                required: true,
                number: true,
//                mobileNoLength: true
            },
            "address1": {
                required: true
            },
            "country": {
                required: true
            },
            "city": {
                required: true
            },
            "state": {
                required: true
            },
            "suppliertype[]": {
                required: true
            },
            "supplierservices[]": {
                required: true
            }

        },
        messages: {
            "companyName": {
                required: 'Please enter company name.'
            },
            "checkRadio": {
                required: 'Please choose any one of this.'
            },
            "selectRadio": {
                required: 'Please choose any one of this.'
            },
            "salution": {
                required: 'Please select.'
            },
            "firstName": {
                required: 'Please enter first name.'
            },
//            "lastName": {
//                required: 'Please enter last name.'
//            },
            "designation": {
                required: 'Please enter designation.'
            },
            "email": {
                required: 'Please enter email id.',
                email: 'Please enter a valid email id.'
            },
            "mobileno": {
                required: 'Please enter mobile no.'
            },
            "country": {
                required: 'Please enter country name.'
            },
            "city": {
                required: 'Please enter city name.'
            },
            "suppliertype[]": {
                required: 'Please enter supplier type.'
            },
            "supplierservices[]": {
                required: 'Please enter supplier services.'
            }
        },
        submitHandler: function () {
            saveSupplierDetails();
        }
    });
});




function saveSupplierDetails() {
    var overviewRegForm = $('#overviewRegForm').serialize();
    var gstNumber = $('#gstNumber').val();
    if( $(".selectRadio").is(':checked')){
        
    }
    if($('.checkgst').is(':checked')) {
        var yes = $('.yes').is(":checked");
        var no = $('.no').is(":checked");
        if(yes === true){
            var nor = $('.nor').is(":checked");
            var com = $('.com').is(":checked");
            //console.log(com);
            if(com !== true && nor !== true){
                alert('Please Choode Registration Scheme');
                return false;
            }
            if(gstNumber === ''){
                alert('Please enter GST number.');
                return false;
            }
        }
    }
    //alert(gstNumber);return false;
    var SupplierUserId = $('#SupplierUserId').val();
    $.ajax({
        url: '/supplier/save-supplier-details?id=' + $('#SupplierUserId').val(),
        data: overviewRegForm,
        method: 'POST',
        dataType: 'json',
        error: function (err) {
            //  alert(err);
        },
        beforeSend: function () {
            $('#loaderimg').css('display', 'inline-block');
        },
        success: function (response) {
            if(response.success){
                alert(response.msg);
                if(SupplierUserId === ''){
                    var newURL = location.href + '/id/' + response.id;
                    window.history.pushState("object or string", "Title",newURL);
                }else{
                    //var newURL = location.href + '/id/' + response.id;
                    window.history.pushState("object or string", "Title");
                }
                //var newURL = location.href + '/id/' + response.id;
                //window.history.pushState("object or string", "Title");
                $('#SupplierUserId').val(response.id);
                supplier_process(2);
            }else{
                $('#dispMessage').html(response.msg).css('display', 'block').delay(30000).fadeOut();
            }
//            if (response.result == 5) {
//                $('#dispMessage').html('Please fill all mandatory fields.').css('display', 'block').delay(30000).fadeOut();
//            } else if (response.result == 2) {
//                $('#dispMessage').html('This email id already registered with us.').css('display', 'block').delay(30000).fadeOut();
//            } else if (response.result == 3) {
//                $('#SupplierUserId').val(response.id);
//                supplier_process(2);
//            } else if (response.result == 1) {
//                var newURL = location.href + '/id/' + response.id;
//                window.history.pushState("object or string", "Title", newURL);
//                $('#SupplierUserId').val(response.id);
//                supplier_process(2);
//            } else {
//                $('#dispMessage').html(TECHNICAL_ERROR_MSG).css('display', 'block').delay(30000).fadeOut();
//            }
            $('#loaderimg').css('display', 'none');
//            alert(response);
        }
    })

    return true;
}


//Validations on add/edit supplier contacts
$(document).ready(function () {
    $("#addSupplierContactForm").validate({
        highlight: function (error, element) {
            var name = $(element).attr("name");
            $("input[name=" + name + "]").removeClass('error');
        },
        rules: {
//            "companyName": {
//                required: true,
//                noStartEndWhiteSpaces: true
//            },
            "salution": {
                required: true
            },
            "firstName": {
                required: true,
//                noStartEndWhiteSpaces: true
            },
            "lastName": {
                required: true,
//                noStartEndWhiteSpaces: true
            },
            "designation": {
                required: true,
//                noStartEndWhiteSpaces: true
            },
            "email": {
                required: true,
                email: true

            },
            "mobileno": {
                required: true,
                number: true,
                // mobileNoLength: true
            },
//            "country_id[]": {
//                required: true
//            },
            "city_id": {
                required: true
            },
//            "supplierservices[]": {
//                required: true
//            }

        },
        messages: {
//            "companyName": {
//                required: 'Please enter company name.'
//            },
            "salution": {
                required: 'Required.'
            },
            "firstName": {
                required: 'Please enter first name.'
            },
            "lastName": {
                required: 'Please enter last name.'
            },
            "designation": {
                required: 'Please enter designation.'
            },
            "email": {
                required: 'Please enter email id.',
                email: 'Please enter a valid email id.'
            },
            "mobileno": {
                required: 'Please enter mobile no.'
            },
            "country": {
                required: 'Please enter country name.'
            },
            "city": {
                required: 'Please enter city name.'
            },
//            "supplierservices[]": {
//                required: 'Please enter supplier services.'
//            }
        },
        submitHandler: function () {
            saveSupplierContacts();
        }
    });
});

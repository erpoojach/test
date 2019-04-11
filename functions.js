
$( document ).ready(function() {
    
    $(".priceonly").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        // 190 is the key code of decimal
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
           (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || (e.keyCode == 190) ||  
            // Allow: home, end, left, right, down, up
           (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    $(".numberonly").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        // 190 is the key code of decimal
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            // Allow: Ctrl+A, Command+A
           (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||  
            // Allow: home, end, left, right, down, up
           (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    
 });
 
function trimComma(str) {
    if(str!='' && str!=null) {
     return str.replace(/^,|,$/g,'');
    }
    return '';
}

function isEmpty(str) {
    if(str == 'NAN') return true;
    
    if(str!='' && str!=null) {
        str.trim();
    }
    
    if(parseInt(str) == 0) return true;
    
    return (!str || 0 === str.length);
}

function getPercentage(fltPercentage, value) {
    if( isEmpty(value) || isEmpty(fltPercentage) ) return '';
    
    return ( value * fltPercentage / 100 ) ;
}

function showMessage(type, msg) {
    $(".alert-danger").css("display","none");
    $(".alert-success").css("display","none");
    
    if(type == 'error') {
        $("#error-message-box").html(msg);
        $(".alert-danger").css("display","block");
    }else if( type == 'success') {
        $("#success-message-box").html(msg);
        $(".alert-success").css("display","block");
    }
    
}


    function populateRoomType(AccomSysId) {
        
        $.ajax({
            url  : '/hotel/populate-acco-room-type',
            data : {AccomSysId : AccomSysId},
            dataType : 'html',
            type : 'POST',
            error : function() {

            },
            beforeSend : function() {

            },
            success : function(response) {
                $("#room_type").html(response);
            } 
        });
    }
    
    
     function getCityList(countryId, populateCtrlId) {
        $.ajax({
            url  : '/general/getcitydropdown',
            data : { intCountryId : countryId},
            dataType : 'html',
            type : 'POST',
            error : function() {

            },
            beforeSend : function() {
                //$("#hotel-city").html('<option vaue="0">Please wait...</option>');
                $("#" + populateCtrlId).html('<option vaue="0">Please wait...</option>');
            },
            success : function(response) { 
                //$("#hotel-city").html(response);
                $("#" + populateCtrlId).html(response);
            }
        });
    }



function openPopup(modelId, url) {  

    $('#'  + modelId).removeData('bs.modal');
    $('#' + modelId).modal({  
        remote: url
    });
    
}

function validateCustomerSmsTemplate(TPSysId,CustomerSysId){
	var TPSysId=TPSysId;
	var CustomerSysId=CustomerSysId;
	if($('input[name=smstemplate]:checked').length==0){
		alert('Please select at least one template to send sms');
		return false;
	}
	var selectedRadio=$('input[name=smstemplate]:checked').val();
		$.ajax({
			url: '/leaddetail/send-sms-to-customer',
			data: {'tpid':TPSysId,'cid':CustomerSysId,'tempid':selectedRadio},
			type: 'POST',
			async:false,
			dataType: 'json',
			beforeSend: function (data) {
				//$(".modalloader").show();
				$("#sendSmsTemplateButton").attr('disabled',true);
			},
			success: function (response) {
				$("#sendSmsTemplateButton").removeAttr('disabled',true);
				if(response.status=='success'){
					//alert('Sms Sent')
				 	$("#succmsgSms").show().fadeOut(10000);
				}else{
					alert("fail : Please try after some time");
				}
			},
			error:function(){
				alert("fail : Please try after some time");
			}
		});
}
$('#myModalSendSMSToDoCustomer').on('hidden.bs.modal', function () {
					$(this).removeData('bs.modal');
	});
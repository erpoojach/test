//Created by Pooja Choudhary
//Created on 8 Jan 2016
//For custom js functions

$(document).ready(function () {
    $("#CORPORATENAME1").change(function () {
        var Corporate = $('#CORPORATENAME').val();
        $.ajax({
            type: 'POST',
            url: 'ajax/getCompanyData.php',
            data: {'Corporate': Corporate},
            beforeSend: function () {
                $('#corpLoading').html('<div class="greenTxt">Loading...</div>');
            },
            success: function (response) {
                $('#comp_data').html(response);
                $('#pop').click();
                $('#overlay_form').css('display', 'block');
                $('#corpLoading').html('');
            }
        });
    });

});


function getProductData(PRODUCT) {
    if (PRODUCT == 'GHI') {
        $('.onlyGHI').show();
    } else {
        $('.onlyGHI').hide();
    }
    $.ajax({
        type: 'POST',
        url: 'ajax/getProductData.php',
        dataType: "json",
        data: {'PRODUCT': PRODUCT},
//        contentType: "application/json; charset=utf-8",
        beforeSend: function () {
            $('#productLoading').html('<div class="greenTxt">Loading...</div>');
        },
        success: function (response)
        {
            //alert(response.intermediary);
            $('#INDUSTRYID').html(response.industry);
            $('#LOCATIONID').html(response.location);
            $('#FAMILYDEFINITION').html(response.family);
            $('#SELECTINTERMEDIARY').html(response.intermediary);
            if(PRODUCT != 'GTI')
            {
                $('#EXPIRINGINSURER').html(response.expiringinsurer);
                $('#POLICYSTRUCTURE').html(response.policystructure);            
                $('#MANDATETYPEDIV').html(response.mandatetype);
            }            
            $('#productLoading').html('');
        },
    });
}


function policyType(type) {
    if (type == "Renewal") {
        $(".policyRenewal").show();
    }
    if (type == "Fresh") {
        $(".policyRenewal").hide();
    }
}

function showIntermediary() {
    var SELECTINTERMEDIARY = $("#SELECTINTERMEDIARY").val();
    if (SELECTINTERMEDIARY == 'other') {
        $("#otherintermediary").show();
    } else {
        $("#otherintermediary").hide();
    }
}

function  validateQuote() {
//    alert('pooja');
    //document.getElementById("samapping").submit();
    //return true;
    var CORPORATENAME = $.trim($("#CORPORATENAME").val());
    if (CORPORATENAME == '')
    {
        alert("Please select Corporate Name.");
        return false;
    }

    var PRODUCT = $.trim($('input[name=PRODUCT]:checked', '#samapping').val());
    if (PRODUCT == '' || PRODUCT == 'undefined')
    {
        alert("Please choose Product Name.");
        return false;
    }

    var NOOFEMPLOYEE = $("#NOOFEMPLOYEE").val();
    if (NOOFEMPLOYEE == '') {
        alert('Please enter number of lives');
        $("#NOOFEMPLOYEE").focus();
        return false;
    }


    var INDUSTRYID = $("#INDUSTRYID").val();
    if (INDUSTRYID == '') {
        alert('Please select industry');
        $("#INDUSTRYID").focus();
        return false;
    }
    var LOCATIONID = $("#LOCATIONID").val();
    if (LOCATIONID == '') {
        alert('Please select location');
        $("#LOCATIONID").focus();
        return false;
    }




//    if (PRODUCT == 'GHI') {
        var familyValue = $("#FAMILYDEFINITION").val();
        var familyArr = familyValue.split("_");
        var FAMILYDEFINITION = familyArr[0];
        var familyChkRatio = familyArr[1];
        if (FAMILYDEFINITION == '') {
            alert('Please select family definition');
            $("#FAMILYDEFINITION").focus();
            return false;
        }
//    }

    var SELECTINTERMEDIARY = $.trim($("#SELECTINTERMEDIARY").val());
    if (SELECTINTERMEDIARY == '')
    {
        alert("Please select Intermediary(Broker/Agent/Direct) Name.");
        return false;
    }


    //var RMNAME = $.trim($("#RMNAME").val());
    /*if (RMNAME == '')
    {
        alert("Please select RM Name.");
        return false;
    }*/

    var RMEMAIL = $.trim($("#RMEMAIL").val());
    if (RMEMAIL == '')
    {
        alert("Please select RM email.");
        return false;
    }
    if (RMEMAIL != '') {
        if (!validateEmail(RMEMAIL)) {
            alert("Please enter a valid Email address");
            return false;
        }
    }
	
	var SELECTINTERMEDIARY = $.trim($("#SELECTINTERMEDIARY").val());
    if(SELECTINTERMEDIARY!= 'Direct' )
		{
			var MANDATETYPE = $.trim($("#MANDATETYPE").val());
    		if (MANDATETYPE == '')
    			{
					alert("Please select Mandate Type.");
					return false;
    			}
		}


    var POLICYSTRUCTURE = $.trim($("#POLICYSTRUCTURE").val());
    if (POLICYSTRUCTURE == '')
    {
        alert("Please select Policy Structure.");
        return false;
    }
    
        var POLICYTYPE = $('input[name=POLICYTYPE]:checked', '#samapping').val();
    var policyTypeArr = POLICYTYPE.split("_");
    var POLICYTYPE = policyTypeArr[0];
    if (POLICYTYPE == '') {
        alert('Please select a policy type');
        $("#POLICYTYPE").focus();
        return false;
    }
    if (POLICYTYPE == 'Renewal') {

        var EXPIRINGINSURER = $("#EXPIRINGINSURER").val();
        if (EXPIRINGINSURER == '') {
            alert('Please enter Expiring Insurer');
            $("#EXPIRINGINSURER").focus();
            return false;
        }
        var PREMIUMAMOUNT = $("#PREMIUMAMOUNT").val();
        if (PREMIUMAMOUNT == '') {
            alert('Please enter Expiring premium amount');
            $("#PREMIUMAMOUNT").focus();
            return false;
        }
            var POLICYSTARTDATE = $("#POLICYSTARTDATE").val();
            if (POLICYSTARTDATE == '') {
                alert('Please enter policy start date');
                $("#POLICYSTARTDATE").focus();
                return false;
            }
            var CLAIMAMOUNT = $("#CLAIMAMOUNT").val();
            if (CLAIMAMOUNT == '') {
                alert('Please enter claim amount');
                $("#CLAIMAMOUNT").focus();
                return false;
            }
            
            var CLAIMDATE = $("#CLAIMDATE").val();
            if (CLAIMDATE == '') {
                alert('Please enter claim date');
                $("#CLAIMDATE").focus();
                return false;
            }

    }
//        alert('hi');
    document.getElementById("samapping").submit();
    /*
     var familyValue		 	= 	$("#FAMILYDEFINITION").val();
     var familyArr			=   familyValue.split("_");
     var FAMILYDEFINITION 	=	familyArr[0];
     var familyChkRatio	 	=	familyArr[1];
     if(FAMILYDEFINITION==''){	
     alert('Please select family definition'); 
     $("#FAMILYDEFINITION").focus();
     return false;	
     }
     if(familyChkRatio=='YES'){	
     var PARENTSNO 	= $("#PARENTSNO").val();
     if(PARENTSNO==''){				
     alert('Please enter number of parents'); 
     $("#PARENTSNO").focus();
     return false;	
     }		
     }
     var SELECTINTERMEDIARY = $("#SELECTINTERMEDIARY").val();
     if(SELECTINTERMEDIARY==''){	
     alert('Please select intermediary.'); 
     $("#INTERMEDIARYNAME").focus();
     return false;	
     }
     if(SELECTINTERMEDIARY=='other'){
     var OTINTERMEDIARY = $("#OTINTERMEDIARY").val();
     if(OTINTERMEDIARY==''){	
     alert('Please enter intermediary name.'); 
     $("#OTINTERMEDIARY").focus();
     return false;	
     }
     }
     var INTERMEDIARYCOMMISSION 	= $("#INTERMEDIARYCOMMISSION").val();
     var minPercent 				= $("#minPercent").val();
     var maxPercent 				= $("#maxPercent").val();
     if(INTERMEDIARYCOMMISSION==''){	
     alert('Please enter commission'); 
     $("#INTERMEDIARYCOMMISSION").focus();
     return false;	
     }
     //alert(minPercent);
     //alert(maxPercent);
     //alert(INTERMEDIARYCOMMISSION);
     if((parseFloat(minPercent)<=parseFloat(INTERMEDIARYCOMMISSION))&&(parseFloat(INTERMEDIARYCOMMISSION)<=parseFloat(maxPercent))){	
     } else {	
     alert('Please enter commission between '+minPercent+' and '+maxPercent); 
     $("#INTERMEDIARYCOMMISSION").focus();
     return false;	
     }		
     
     if(POLICYTYPE=='Renewal'){		
     var STRICTLYEXPIRY = $('input[name=STRICTLYEXPIRY]:checked', '#samapping').val();
     if(STRICTLYEXPIRY!='on'){	
     alert('Please select expiry condition'); 
     $("#STRICTLYEXPIRY").focus();
     return false;	
     }	
     var PREMIUMAMOUNT = $("#PREMIUMAMOUNT").val();
     if(PREMIUMAMOUNT==''){	
     alert('Please enter premium amount'); 
     $("#PREMIUMAMOUNT").focus();
     return false;	
     }
     if(!isInteger(PREMIUMAMOUNT)){
     alert('Please enter only numeric values'); 
     $("#PREMIUMAMOUNT").focus();
     return false;
     }
     var CLAIMAMOUNT = $("#CLAIMAMOUNT").val();
     if(CLAIMAMOUNT==''){	
     alert('Please enter claim amount'); 
     $("#CLAIMAMOUNT").focus();
     return false;	
     }
     if(!isInteger(CLAIMAMOUNT)){
     alert('Please enter only numeric values'); 
     $("#CLAIMAMOUNT").focus();
     return false;
     }
     var CLAIMDATE = $("#CLAIMDATE").val();
     if(CLAIMDATE==''){	
     alert('Please enter claim date'); 
     $("#CLAIMDATE").focus();
     return false;	
     }
     if(CLAIMDATE>POLICYSTARTDATE){	
     alert('Please enter claim date smaller than start date'); 
     $("#CLAIMDATE").focus();
     return false;	
     }
     var LASTYEARLIVES = $("#LASTYEARLIVES").val();
     if(LASTYEARLIVES==''){	
     alert('Please enter last year number of lives'); 
     $("#LASTYEARLIVES").focus();
     return false;	
     }		
     }	
     
     var SUMINSURED1 = $("#SUMINSURED1").val();
     if(SUMINSURED1==''){	
     alert('Please select sum-insured'); 
     $("#SUMINSURED1").focus();
     return false;	
     }
     var copay1 = $("#copay1").val();
     if(copay1==''){	
     alert('Please enter co-pay'); 
     $("#copay1").focus();
     return false;	
     }
     var ROOMTYPE1 = $("#ROOMTYPE1").val();
     if(ROOMTYPE1==''){	
     alert('Please select a room type'); 
     $("#ROOMTYPE1").focus();
     return false;	
     }
     var ICULIMIT1 = $("#ICULIMIT1").val();
     if(ICULIMIT1==''){	
     alert('Please select a icu limit'); 
     $("#ICULIMIT1").focus();
     return false;	
     }
     var NORMALMATERNITY1 = $('input[name=NORMALMATERNITY1]:checked', '#samapping').val();
     if(NORMALMATERNITY1=='yes'){	
     var NORMALMATERNITYTYPE1 = $("#NORMALMATERNITYTYPE1").val();
     if(NORMALMATERNITYTYPE1==''){
     alert('Please select a normal maternity type'); 
     $("#NORMALMATERNITYTYPE1").focus();
     return false;	
     }
     }
     var MATERNITY1 = $('input[name=MATERNITY1]:checked', '#samapping').val();
     if(MATERNITY1=='yes'){	
     var MATERNITYTYPE1 = $("#MATERNITYTYPE1").val();
     if(MATERNITYTYPE1==''){
     alert('Please select a c-section maternity type'); 
     $("#MATERNITYTYPE1").focus();
     return false;	
     }
     }
     //alert(MATERNITY1);
     //alert(MATERNITYTYPE1);
     var CORPORATEFLOATER1 = $('input[name=CORPORATEFLOATER1]:checked', '#samapping').val();
     if(CORPORATEFLOATER1=='yes'){
     var CFMOUNT1 = $("#CFMOUNT1").val();
     if(CFMOUNT1==''){	
     alert('Please select a corporate floater amount'); 
     $("#CFMOUNT1").focus();
     return false;	
     }
     }
     var NEWBABY1 = $('input[name=NEWBABY1]:checked', '#samapping').val();
     if(NEWBABY1=='yes'){
     var BABYAMOUNT1 = $("#BABYAMOUNT1").val();
     if(BABYAMOUNT1==''){	
     alert('Please select a new born baby covered amount'); 
     $("#BABYAMOUNT1").focus();
     return false;	
     }
     }	
     var diseaseId = $("#diseaseId1").val();
     if(diseaseId==''){	
     alert('Please select a disease wise limit.'); 
     $("#diseaseId1").focus();
     return false;	
     }
     var prePostId = $("#prePostId1").val();
     if(prePostId==''){	
     alert('Please select pre-post hospitalization.'); 
     $("#prePostId1").focus();
     return false;	
     }
     var GHICOVERTYPE1 = $("#GHICOVERTYPE1").val();
     if(GHICOVERTYPE1==''){	
     alert('Please select cover type.'); 
     $("#GHICOVERTYPE1").focus();
     return false;	
     }
     var forloop;
     var slabno = $("#slabNo").val();
     for(forloop=1;forloop<=slabno;forloop++){	//
     var SITYPERES = $("#SITYPE"+forloop).val();
     var nameres 	= "SITYPE"+forloop+"";		
     var SITYPERES = $('input[name='+nameres+']:checked', '#samapping').val();		
     if(SITYPERES=='Graded'){
     var SITYPEREMARKSRES = $("#SITYPEREMARKS"+forloop).val();			
     if(SITYPEREMARKSRES==''){			
     alert('Please enter Sum-Insured type reason.'); 
     $("#SITYPEREMARKS"+forloop).focus();
     return false;
     }
     var gradeBaisisId = $("#gradeBaisisId"+forloop).val();			
     if(gradeBaisisId==''){			
     alert('Please select grade basis.'); 
     $("#gradeBaisisId"+forloop).focus();
     return false;
     }
     }	
     }
     var slabmemno1 = $("#slab1total").html();
     var slabmemno2 = $("#slab2total").html();
     var slabmemno3 = $("#slab3total").html();
     var slabmemno4 = $("#slab4total").html();
     var totalslabmemno = parseInt(slabmemno1)+parseInt(slabmemno2)+parseInt(slabmemno3)+parseInt(slabmemno4);
     if(totalslabmemno<1) {
     alert("Please enter atleast one member in any slab.");		
     return false;
     }
     var OPDCOVERAGEID 	= $("#OPDCOVERAGEID").val();
     var OPDLOCATIONID 	= $("#OPDLOCATIONID").val();
     var OPDSIID		  	= $("#OPDSIID").val();
     var OPDEMPLOYEE 	= $("#OPDEMPLOYEE").val();
     var OPDMEMBERS 		= $("#OPDMEMBERS").val();
     var OPDFAMILYID 	= $("#OPDFAMILYID").val();
     var OPDCOPAYID 		= $("#OPDCOPAYID").val();
     if((OPDCOVERAGEID!='')||(OPDLOCATIONID!='')||(OPDSIID!='')||(OPDEMPLOYEE!='')||(OPDMEMBERS!='')||(OPDFAMILYID!='')||(OPDCOPAYID!='')){
     if(OPDCOVERAGEID==''){			
     alert('Please select opd coverage.'); 
     $("#OPDCOVERAGEID").focus();
     return false;
     }
     if(OPDLOCATIONID==''){			
     alert('Please select opd location.'); 
     $("#OPDLOCATIONID").focus();
     return false;
     }
     if(OPDSIID==''){			
     alert('Please select opd sum insured.'); 
     $("#OPDSIID").focus();
     return false;
     }
     if(OPDEMPLOYEE==''){			
     alert('Please enter opd employee.'); 
     $("#OPDEMPLOYEE").focus();
     return false;
     }
     if(OPDMEMBERS==''){			
     alert('Please enter opd members.'); 
     $("#OPDMEMBERS").focus();
     return false;
     }
     if(OPDFAMILYID==''){			
     alert('Please select opd family.'); 
     $("#OPDCOPAYID").focus();
     return false;
     }
     if(OPDCOPAYID==''){			
     alert('Please select opd copay.'); 
     $("#OPDCOPAYID").focus();
     return false;
     }
     }	
     document.getElementById("samapping").submit();
     
     */



    /*var ajaxData=$("#samapping").serialize();	
     blocking('load');
     $.ajax({
     type: "POST",
     url: "validateQuote.php",
     data: ajaxData,
     success: function(msg){
     unblocking('load');
     var msgArr			=   msg.split("_");
     var msg1 			=	msgArr[0];
     var msg2 			=	msgArr[1];
     if(msg1=='Error') {
     if(msg2=='GroupMember') {
     alert("Total member is smaller than 16. Please route the case to U/W team.");
     return false;
     }
     if(msg2=='MaxGroupSize') {
     alert("Total member is greater than defined group size. Please route the case to U/W team.");
     return false;
     }
     if(msg2=='ClaimRatio') {
     alert("Claim ratio is greater than defined value. Please route the case to U/W team.");
     return false;
     }
     if(msg2=='ParentEmpClaimRatio') {
     alert("Parents employee ratio is not present. Please route the case to U/W team.");
     return false;
     }
     if(msg2=='LastYearClaimRatio') {
     alert("Last year claim ratio is greater than defined value. Please route the case to U/W team.");
     return false;
     }
     } else {						
     var FREECHECKUPNO 	= msg2;	
     if(FREECHECKUPNO!=''){
     var confirmresult = confirm("Number of free health check-up is "+FREECHECKUPNO+", Are you sure you want to continue?");
     if(confirmresult==true){	
     document.getElementById("samapping").submit();
     }	else	{
     return false;
     }
     }					
     }	
     return true;						
     }
     });*/
    return false;
}

function validateEmail($email) {
    emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test($email)) {
        return false;
    } else {
        return true;
    }
}


function checkUsernameForgotPass(user) { $('#userLoading').html('');
    $.ajax({
        type: 'POST',
        url: 'ajax/getUsernameForgotPassData.php',
        data: {'username': user},
        beforeSend: function () {
            $('#userLoading').html('<div class="greenTxtforgot">Loading...</div>');
        },
        success: function (response)
        {
            $('#userLoading').html('');
//            alert(response);
            if (response == 1) {
                $('#userLoading').html('<div class="errorMsg">Sorry that username is not in our system.</div>');
            }


        },
    });
}



function validatePerformanceInvoice() {

    var CORPORATENAME = $.trim($("#CORPORATENAME").val());
    if (CORPORATENAME == '')
    {
        alert("Please Enter Corporate Name.");
        return false;
    }
    var LEGALNAME = $.trim($("#LEGALNAME").val());
    if (LEGALNAME == '')
    {
        alert("Please Enter Legal Name.");
        return false;
    }

    var STREET1 = $.trim($("#STREET1").val());
    if (STREET1 == '')
    {
        alert("Please Enter Street1 Address.");
        return false;
    }
    var STREET2 = $.trim($("#STREET2").val());
    if (STREET2 == '')
    {
        alert("Please Enter Street2 Address.");
        return false;
    }
    var LOCALITY = $.trim($("#LOCALITY").val());
    if (LOCALITY == '')
    {
        alert("Please Enter Locality.");
        return false;
    }
    var CITY = $.trim($("#CITY").val());
    if (CITY == '')
    {
        alert("Please Enter City.");
        return false;
    }
    var STATE = $.trim($("#STATE").val());
    if (STATE == '')
    {
        alert("Please Enter State.");
        return false;
    }
    var PINCODE = $.trim($("#PINCODE").val());
    if (PINCODE == '')
    {
        alert("Please Enter Pin Code.");
        return false;
    }
    var TELEPHONE = $.trim($("#TELEPHONE").val());
    if (TELEPHONE == '')
    {
        alert("Please Enter Contact No.");
        return false;
    }
//    var INTERNETADDRESS = $.trim($("#INTERNETADDRESS").val());
//    if (INTERNETADDRESS == '')
//    {
//        alert("Please Enter Internet Address.");
//        return false;
//    }

    var PANCARD = $.trim($("#PANCARD").val());
    if (PANCARD == '')
    {
        alert("Please Enter Pan Card Number.");
        return false;
    } else if (PANCARD.length != 10 || PANCARD == 'PAN Card Number' || (!PANCARD.match(/^([A-Z]{5})([0-9]{4})([A-Z]{1})$/)))
    {
        alert('Please enter valid PAN No.');
        return false;
    }
    
    var SERVICETAXNO = $.trim($("#SERVICETAXNO").val());
    if (SERVICETAXNO == '')
    {
        alert("Please Enter Service Tax Number.");
        return false;
    } else if (SERVICETAXNO.length != 15 || SERVICETAXNO == 'Service Tax Number' || (!SERVICETAXNO.match(/^([A-Z]{5})([0-9]{4})([A-Z]{1})([A-Z0-9]{5})$/)))
    {
        alert('Please enter valid Service Tax Number.');
        return false;
    }

    var CONTACTPERSON = $.trim($("#CONTACTPERSON").val());
    if (CONTACTPERSON == '')
    {
        alert("Please Enter Consent Person Name.");
        return false;
    }


    var CONSENTEMAIL = $.trim($("#CONSENTEMAIL").val());
    if (CONSENTEMAIL == '')
    {
        alert("Please Enter Consent Person E-mail Id.");
        return false;
    }
    if (CONSENTEMAIL != '') {
        if (!validateEmail(CONSENTEMAIL)) {
            alert("Please Enter a valid Email address");
            return false;
        }
    }
    
    var POLICYNUMBER = $.trim($("#POLICYNUMBER").val());
    if (POLICYNUMBER == '')
    {
        alert("Please Enter Policy Number.");
        return false;
    }
    
    flag=1;
     $('.additional_file').each(function(){
             if(this.value!=""){
                            var file_name = this.value;
                            var filext = file_name.substring(file_name.lastIndexOf(".")+1);
                            var file_id = this.id;
                            var file_id_no=  file_id.substring(file_id.lastIndexOf("_")+1)
                            if($("#DOCUMENTNAME_"+file_id_no).val()=="")
                            { $("#error-"+this.id).html("Please Select Document type");  flag=0;}
                            else if(filext == "doc" || filext == "docx"|| filext == "pdf"|| filext == "xls"|| filext == "xlsx")
                            { return true; }
                            else
                            {  $("#error-"+this.id).html("Invalid File Format.Use doc,docx,pdf,xls,xlsx only");  flag=0;   }
             } 
             else
             {  $("#error-"+this.id).html("");  }
        }); 
    $('.UPLOADFILEINPUT').each(function(){
             if(this.value!=""){
                            var file_name = this.value;
                            var filext = file_name.substring(file_name.lastIndexOf(".")+1);                             
                            if(filext == "doc" || filext == "docx"|| filext == "pdf"|| filext == "xls"|| filext == "xlsx")
                            { return true; }
                            else
                            {  $("#error-"+this.id).html("Invalid File Format.Use doc,docx,pdf,xls,xlsx only");  flag=0;   }
             }
            else if(this.value=="")
             {    $("#error-"+this.id).html("Please upload the required Document");  flag=0;   }
             else
             {  $("#error-"+this.id).html("");  }
        }); 
    if (flag == 0)
    {
//        alert("Please upload the required Document");
        return false;
    }

    document.getElementById("CreateClientId").submit();
    return true;

}


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


function send_mail_pdf(id)
	{
		  function validateEmail($email)
		   {
				emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			  	if( !emailReg.test( $email ) ) 
					{
						return false;
			  		} 
				else 
					{
						return true;
			  		}
			}
		 pdf_email_id=$("#pdf_email_id").val();
            if(pdf_email_id=="")
              {
                          $("#error_message").show();
                          $("#error_message").html("<span style='color:red;' >Please enter your  Email Id.</a>");
                          $("#error_message").hide(5000);
                          return false;
              } 
             if(pdf_email_id !='')
                {
                    if(!validateEmail(pdf_email_id))
                    {
                   		  $("#error_message").show();
                          $("#error_message").html("<span style='color:red;' >Please enter a valid  Email Id.</a>");
                          $("#error_message").hide(5000);
                    	  return false;	
                    }
                }
				
		 var quoteId = $("#sendPdfQid").val();
		 var pdf_email_id = $("#pdf_email_id").val();
		 $.ajax({
            type:"post",
            url:'religare_sendPdf.php',   
            data:{quoteId: quoteId, email_id: pdf_email_id },
            success:function(resp){   
                          $("#mail_coupon_load_image"+id).hide();
                          $("#error_message").show();
                          $("#error_message").html("<span style='color:green;' >Pdf has been sent.</span>");
                          $("#error_message").hide(5000); 
                  }  
          }); 
	}
        
        
   function updateAdminPremium(quoteId, userId) {
    $.ajax({
        type: "POST",
        url: "ajax/update_quote_otcuw_premium.php",
        data: "quoteId=" + quoteId + "&userId=" + userId,
        success: function (msg) {
            var getData = $.trim(msg);
//        alert(getData);
            $("#popupMainIn").html(getData);
            popupOpen();
        }
    });
    return false;
}


function popupOpen(){
    $(".overflowBox").show();
    $(".popupMain").show();
}

function popupclose(){
  $(".overflowBox").hide();
  $(".popupMain").hide();   
}


   function updateRMPremium(quoteId, userId) {
    $.ajax({
        type: "POST",
        url: "update_quote_premium.php",
        data: "quoteId=" + quoteId + "&userId=" + userId,
        success: function (msg) {
            var getData = $.trim(msg);
//        alert(getData);
            $("#popupMainIn").html(getData);
            popupOpen();
        }
    });
    return false;
}



   function updateRMStatus(quoteId, userId, premiumWithTax) {
    $.ajax({
        type: "POST",
        url: "update_quote_status.php",
        data: "quoteId=" + quoteId + "&userId=" + userId + "&totalPremium=" + premiumWithTax,
        success: function (msg) {
            var getData = $.trim(msg);
//        alert(getData);
            $("#popupMainIn").html(getData);
            popupOpen();
        }
    });
    return false;
}


 function updateGPARMStatus(quoteId, userId, totalPremium) {
    $.ajax({
        type: "POST",
        url: "update_gpaquote_status.php",
        data: "quoteId=" + quoteId + "&userId=" + userId + "&totalPremium=" + totalPremium,
        success: function (msg) {
            var getData = $.trim(msg);
//        alert(getData);
            $("#popupMainIn").html(getData);
            popupOpen();
        }
    });
    return false;
}


   function updateGPARMPremium(quoteId, userId) {
    $.ajax({
        type: "POST",
        url: "update_gpaquote_premium.php",
        data: "quoteId=" + quoteId + "&userId=" + userId,
        success: function (msg) {
            var getData = $.trim(msg);
//        alert(getData);
            $("#popupMainIn").html(getData);
            popupOpen();
        }
    });
    return false;
}



function quoteUpdateStatus(quoteId,userId) {
	$.ajax({
	type: "POST",
	url: "ajax/update_quote_otcuw_status.php",
	data: "quoteId="+quoteId+"&userId="+userId,
	success: function(msg){
	var getData = $.trim(msg);
	$("#popupMainIn").html(getData);
        popupOpen();
	}
	});
    return false;	
}

function gpaQuoteUpdateStatus(quoteId,userId) {
	$.ajax({
	type: "POST",
	url: "ajax/update_gpa_quote_status.php",
	data: "quoteId="+quoteId+"&userId="+userId,
	success: function(msg){
	var getData = $.trim(msg);
	$("#popupMainIn").html(getData);
        popupOpen();
	}
	});
    return false;	
}



function updateGpaAdminPremium(quoteId,userId) {
	$.ajax({
	type: "POST",
	url: "ajax/update_gpa_quote_admin_premium.php",
	data: "quoteId="+quoteId+"&userId="+userId,
	success: function(msg){
	var getData = $.trim(msg);
	$("#popupMainIn").html(getData);
        popupOpen();
	}
	});
    return false;	
}



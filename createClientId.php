<?php

include_once("conf/company_session.php");
include_once("conf/conf.php");
include_once("conf/fucts.php");
$pageType = "Create Client Id";
include_once("inc/hd.php");
//createClientId.php
if ((trim(@$_REQUEST["quoteId"]) == "") || (trim(@$_SESSION["userId"]) == "")) {
    session_unset();
    session_destroy();
    $url = "Location:  index.php";
    header($url);
    exit;
}
$quoteId = sanitize_data(@$_REQUEST['quoteId']);

if(@$_REQUEST['quoteType'] == 'UNDERWRITERQUOTE')
{
    $quoteTypeTable = 'UNDERWRITERQUOTE';
    $corporateArr = corpDetails('UNDERWRITERQUOTE', $quoteId);    
}
else if(@$_REQUEST['quoteType'] == 'GHI')
{
    $quoteTypeTable = 'CRMOAQQUOTE';
    $corporateArr = corpDetails('CRMOAQQUOTE', $quoteId);
}
if(@$_REQUEST['quoteType'] == 'GPA')
{
    $quoteTypeTable = 'GPAQUOTE';
    $corporateArr = corpDetails('GPAQUOTE', $quoteId);
}

//$corporateArr = corpDetails('UNDERWRITERQUOTE', $quoteId);
//pr($corporateArr); die;

?>
<!--<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/ui.browser.js"></script>
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css">-->

<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>


<script>
function getCityState() {
    var PINCODE = $("#PINCODE").val();
    if (PINCODE != ""){
            $.ajax({
        type: 'POST',
        url: 'ajax/getDataByPincode.php',
        dataType: "json",
        data: {'PINCODE': PINCODE},
        beforeSend: function () {
            $('#codeLoading').html('<div class="greenTxt">Loading...</div>');
        },
        success: function (response)
        {
            if(response == 1){
                $('#CITY').hide();
                $('#STATE').hide();
                $('#codeLoading').html('<div style="color:#F00;">Please Enter Valid Pin Code.</div>');
                return false;
             } 
            else {
                $('#codeLoading').html('');
                $('#CITYDIV').html(response.CITYDIV);
                $('#STATEDIV').html(response.STATEDIV);             
            }
             

        },
    });
    }
} 
</script>

<style>
.error{
	color: #F00 !important;
	float: left !important;
        position: relative;    
        padding-right: 20px !important;
    /*padding-top: 30px !important;*/
}
.error_UPLOADFILE_add{
    color: #F00 !important;
	float: left !important;
        position: relative;    
        padding-right: 20px !important;
}
.errorTxtCustom{
  border: 1px solid red;
  min-height: 20px;
}
input, textarea, select {
    color: black !important;
    outline: medium none;
}
.inputBoxIn input{
     color: black !important;
    outline: medium none;
}
.inputBoxIn select{
     color: black !important;
    outline: medium none;
}
.inputBoxIn textarea{
     color: black !important;
    outline: medium none;
}
</style>
<!--Middle section start here-->
<section>
    <div class="title-bg"><h1>Create Client Id</h1></div>
    <form action="writeCreateClientId.php" method="POST" name="CreateClientId" id="CreateClientId" autocomplete="off"  enctype="multipart/form-data">        
        <div class="grayBorder">
            <div class="myPlanForm">
                <input type="hidden" name="PRODUCTTYPE" id="PRODUCTTYPE" class="txtField" value="<?php echo $corporateArr[0]['PRODUCT'] ; ?>" >
                 <input type="hidden" name="QUOTEID" id="QUOTEID" class="txtField" value="<?php echo $quoteId; ?>" >
                
                
                <div class="myPlanformBox myPlanLeft">
                    <label>Quote Request  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox inputBoxgr">
                        <div class="inputBoxIn">
                            <input type="text" name="REFRENCENUMBER" id="REFRENCENUMBER" class="txtField" value="<?php echo $corporateArr[0]['REFRENCENUMBER'] ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>Corporate Name  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text"  name="CORPORATENAME" id="CORPORATENAME" class="txtField" value="<?php echo $corporateArr[0]['CORPORATENAME'] ?>" placeholder="Corporate Name">
                        </div>
                    </div>
                    <div id="error-CORPORATENAME"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>Legal Name  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text"  name="LEGALNAME" id="LEGALNAME" class="txtField" value="<?php echo $corporateArr[0]['LEGALNAME'] ?>" placeholder="Legal Name">
                        </div>
                    </div>
                    <div id="error-LEGALNAME"></div>
                    <div class="clearfix"></div></div>



                <div class="myPlanformBox myPlanLeft">
                    <label>Street1  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="STREET1" id="STREET1" class="txtField" value="<?php echo $corporateArr[0]['STREET1'] ?>" placeholder="Street1">
                        </div>
                    </div>
                    <div id="error-STREET1"></div>
                    <div class="clearfix"></div></div>



                <div class="myPlanformBox myPlanLeft">
                    <label>Street2  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="STREET2" id="STREET2" class="txtField" value="<?php echo $corporateArr[0]['STREET2'] ?>" placeholder="Street2">
                        </div>
                    </div>
                    <div id="error-STREET2"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>Locality  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="LOCALITY" id="LOCALITY" class="txtField" value="<?php echo $corporateArr[0]['LOCALITY'] ?>"  placeholder="Locality">
                        </div>
                    </div>                    
                    <div id="error-LOCALITY"></div>
                    <div class="clearfix"></div></div>
                    
                   <div class="myPlanformBox myPlanLeft">
                    <label>Pincode  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="PINCODE" id="PINCODE" class="txtField" value="<?php echo $corporateArr[0]['PINCODE'] ?>" placeholder="Pincode" onkeypress="return isNumber(event);" onblur="getCityState();" maxlength="6">
                        </div>
                    </div><span id="codeLoading"><span>
                            <div id="errorPINCODE"></div>
                            <div id="error-PINCODE"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>City  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox" id="CITYDIV">
                        <div class="inputBoxIn">
                            <input type="text" name="CITY" id="CITY" class="txtField" value="<?php echo $corporateArr[0]['CITY'] ?>" placeholder="City" readonly="">
                        </div>
                    </div>
                    <div id="error-CITY"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>State  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn" id="STATEDIV">
                            <input type="text" name="STATE" id="STATE" class="txtField" value="<?php echo $corporateArr[0]['STATE'] ?>" placeholder="State" readonly="">
                        </div>
                    </div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>Contact No. <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="TELEPHONE" id="TELEPHONE" class="txtField" value="<?php echo $corporateArr[0]['TELEPHONE'] ?>" placeholder="Contact No." onkeypress="return isNumber(event);" maxlength="10">
                        </div>
                    </div>
                    <div id="error-TELEPHONE"></div>
                    <div class="clearfix"></div></div>


                <!--                <div class="myPlanformBox myPlanLeft">
                                    <label>Internet Address  <?php echo MANDFIELDS; ?></label>
                                    <div class="inputBox">
                                        <div class="inputBoxIn">
                                            <input type="text" name="INTERNETADDRESS" id="INTERNETADDRESS" class="txtField" placeholder="Internet Address">
                                        </div>
                                    </div>
                                    <div class="clearfix"></div></div>-->


                <div class="myPlanformBox myPlanLeft">
                    <label>PAN Card Number <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="PANCARD" id="PANCARD" class="txtField" value="<?php echo $corporateArr[0]['PANCARD'] ?>" placeholder="PAN Card Number Ex. AAAAA1111A" maxlength="10">
                        </div>
                    </div>
                    <div id="error-PANCARD"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>Service Tax Number:<?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="SERVICETAXNO" id="SERVICETAXNO" class="txtField" value="<?php echo $corporateArr[0]['SERVICETAXNO'] ?>" placeholder="Service Tax Number Ex. AAAAA1111ABBBBB" maxlength="15">
                        </div>
                    </div>
                    <div id="error-SERVICETAXNO"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>Consent Person Name  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="CONTACTPERSON" id="CONTACTPERSON" class="txtField" value="<?php echo $corporateArr[0]['CONTACTPERSON'] ?>" placeholder="Consent Person Name">
                        </div>
                    </div>
                    <div id="error-CONTACTPERSON"></div>
                    <div class="clearfix"></div></div>

                <div class="myPlanformBox myPlanLeft">
                    <label>Consent Person E-mail Id <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="CONSENTEMAIL" id="CONSENTEMAIL" class="txtField" value="<?php echo $corporateArr[0]['CONSENTEMAIL'] ?>" placeholder="Consent Person E-mail Id">
                        </div>
                    </div>
                    <div id="error-CONSENTEMAIL"></div>
                    <div class="clearfix"></div></div>
                    
                <div class="myPlanformBox myPlanLeft">
                    <label>CD Balance Amount</label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="CDBALAMOUNT" id="CDBALAMOUNT" class="txtField" value="<?php echo $corporateArr[0]['CDBALAMOUNT'] ?>" placeholder="CD Balance Amount" <!--onkeypress="return isNumber(event);"--> maxlength="10">
                        </div>
                    </div>
                    <div id="error-CDBALAMOUNT"></div>
                    <div class="clearfix"></div></div>
                    
                <div class="myPlanformBox myPlanLeft">
                    <label>Policy Number <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="POLICYNUMBER" id="POLICYNUMBER" class="txtField" value="<?php echo $corporateArr[0]['POLICYNUMBER'] ?>" placeholder="Policy Number"  maxlength="8">
                        </div>
                    </div>
                    <div id="error-POLICYNUMBER"></div>
                    <div class="clearfix"></div></div>
                    
                <div class="myPlanformBox myPlanLeft">
                    <label>Value Add Service</label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="VALUEADDSERVICE" id="VALUEADDSERVICE" class="txtField" value="<?php echo $corporateArr[0]['VALUEADDSERVICE'] ?>" placeholder="Value Add Service" maxlength="10">
                        </div>
                    </div>
                    <div id="error-VALUEADDSERVICE"></div>
                    <div class="clearfix"></div></div>
                <div class="clearfix"></div></div>

            <?php
//            include_once('qtp_dns.php');            
           include_once('ftp_upload_form.php'); //DNS MERGING
           ?>
            <input type="hidden" id="totalcount" value="">
            <div class="myPlanBtn">
		<input type="hidden" name="QUOTETYPETABLE" id="QUOTETYPETABLE" value="<?php echo $quoteTypeTable;?>">
                <a class="submit-btn" onclick="return validatePerforma();" href="javascript:void(0);">Submit</a>
                <a class="cancel-btn" href="quote_list.php">Cancel</a>
                <div class="clearfix"></div></div>
        </div>
    </form>
    <div class="cl"></div></section>

<!--footer start here-->
<a href="allocationProcess.php"></a>
<?php include_once("inc/ft.php"); ?>



<!-- Added existing validation. for refrence see /script/qtpCustom.js. - 17/03/2016 17:49 @SHAKTIRANA -->
<script type="text/javascript">
//Make string toUpperCase.
$(document).ready(function(){    
      $('#PANCARD, #SERVICETAXNO').keyup(function() {
      $(this).val($(this).val().toUpperCase());
    });
  });
  
  
function validatePerforma() {
    //$("#CreateClientId").submit();
    
    //mandatory file upload validation.
    flag=1;
    $('.additional_file').each(function(){
         if(this.value!=""){
                        var file_name = this.value;
                        var filext = file_name.substring(file_name.lastIndexOf(".")+1);
                        var file_id = this.id;
                        var file_id_no=  file_id.substring(file_id.lastIndexOf("_")+1)
                        if($("#DOCUMENTNAME_"+file_id_no).val()=="")
                        { $("#errorselect-"+this.id).html("Please Select Document type");  flag=0;}
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

    if(flag==0)
    { 
        return false;
    }
//    serverSideValidationCheck();
    $("#CreateClientId").submit();
    //document.getElementById("CreateClientId").submit();
}
</script>



<!-- Added new validation - 17/03/2016 17:49 @SHAKTIRANA -->
<script type="text/javascript">
  
  $(document).ready(function(){
        //notStartWithNumeric. only alphanumeric. Not start with space or any number or any with space and no initial as a number.
        $.validator.addMethod("notStartWithNumeric", function(value, element) {
                return this.optional(element) || (value.substr(0, 1).match(/[A-Za-z]/) && /^[a-zA-Z0-9](?:[a-zA-Z0-9&-_. ]*[a-zA-Z0-9&-_. ])?$/.test(value));
            }, function(value, element){ 
                var elementName;
                if(element.id == 'CORPORATENAME') {
                    elementName = 'Corporate Name';
                }
                else if(element.id == 'LEGALNAME') {
                    elementName = 'Legal Name';
                }
                val = $('#'+element.id).val();
                if(val.substr(0, 1).match(/[A-Za-z]/) == null)
                {
                    return elementName + " cannot starts with number or any special character.";                                                
                }
                else
                {
                    return elementName + " cannot contain any special character.";
                }
            });   

        //alphaNumeric.
//        $.validator.addMethod("alphaNumeric", function(value, element) {                
//                return this.optional(element) || /^[a-zA-Z0-9](?:[a-zA-Z0-9&_ ]*[a-zA-Z0-9&_ ])?$/.test(value));
//            }, "Corporate Name can not contain any special charecter.");  
            
        //onlyFloat. for price.    
        $.validator.addMethod("onlyFloat", function(value, element) {
                return this.optional(element) || /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/.test(value);
            }, "Not valid Amount.");     
        
        $.validator.addMethod("priceValidation", function(value, element) {
                return this.optional(element) || /^\d+(?:\.\d{1,2})?$/.test(value);
            }, "Not valid Amount.");     
            
        //mobileNoLength.    
        $.validator.addMethod("mobileNoLength", function(value, element) {
                return this.optional(element) || value.length == 10;
            }, "Contact No. must contain 10 digit.");       

        //email.
        jQuery.validator.addMethod("email", function (value, element) {
            return this.optional(element) || (/^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test(value) 
                    && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value));
        }, 'Please enter valid email address.');
            
        $.validator.addMethod("noStartEndWhiteSpaces", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9](?:[a-zA-Z0-9 ]*[a-zA-Z0-9])?$/.test(value);
            }, "Spaces are not allowed.");
        
        $.validator.addMethod("validPAN", function(value, element) {
                return this.optional(element) || (value.length == 10 && /([A-Z]{5})([0-9]{4})([A-Z]{1})$/.test(value));
            }, "Please enter valid PAN No.");
            
        $.validator.addMethod("validServiceTaxNumber", function(value, element) {
                return this.optional(element) || (value.length == 15 && /([A-Z]{5})([0-9]{4})([A-Z]{1})([A-Z0-9]{5})$/.test(value));
            }, "Please enter valid Service Tax Number.");    
        
        
      //added custom validation.
      $("#CreateClientId").validate({
        ignore: [], // this will allow to validate any hidden field inside a form
        errorPlacement: function(error, element) {
            $.each(element, function(key, value) {
                $("#error-"+value.name).replaceWith(error);
              });
        },
        rules: {
            "CORPORATENAME": {
                required: true,
                notStartWithNumeric: true
            },
            "LEGALNAME": {
                required: true,
                notStartWithNumeric: true
            },
            "STREET1": {
                required: true,
                noStartEndWhiteSpaces: true                
            },
            "STREET2": {
                required: true,
                noStartEndWhiteSpaces: true                
            },
            "LOCALITY": {
                required: true,
                noStartEndWhiteSpaces: true                
            },
            "PINCODE": {
                required: true,
                integer: true
            },
            "CITY": {
                required: {
                    depends: function() {
                        return $('#CITY').val() == 'Select City' || $('#CITY').val() == '';
                    }
                }
            },
            "TELEPHONE": {
                required: true,
                mobileNoLength: true
            },
            "PANCARD": {
                required: true,
                noStartEndWhiteSpaces: true,
                validPAN: true
            },
            "SERVICETAXNO": {
                required: true,
                noStartEndWhiteSpaces: true,
                validServiceTaxNumber: true
            },
            "CONTACTPERSON": {
                required: true,
                noStartEndWhiteSpaces: true                
            },
            "CONSENTEMAIL": {
                required: true,
                email: true
            },
            "CDBALAMOUNT": {
                required: true,
                priceValidation: true       
            },
           "POLICYNUMBER": {
                required: true,
                integer: true,
                noStartEndWhiteSpaces: true                
            },
            "VALUEADDSERVICE": {
                required: true,
                priceValidation: true             
            }            
        },
        messages: {
            "CORPORATENAME": {
                required: 'Please enter Corporate Name.'
            }, 
            "LEGALNAME": {
                required: 'Please enter Legal Name.'
            },
            "STREET1": {
                required: 'Please enter Street1.'
            },
            "STREET2": {
                required: 'Please enter Street2.'
            },
            "LOCALITY": {
                required: 'Please enter Locality.'
            },
            "PINCODE": {
                required: 'Please enter Pincode.'
            },
            "CITY": {
                required: 'Please enter City.'
            },
            "TELEPHONE": {
                required: 'Please enter Telephone.'
            },
            "PANCARD": {
                required: 'Please enter Pancard.'                
            },
            "SERVICETAXNO": {
                required: 'Please enter Service Tax No.'                
            },
            "CONTACTPERSON": {
                required: 'Please enter Contact Person.'               
            },
            "CONSENTEMAIL": {
                required: 'Please enter Consent Email.'                
            },
            "CDBALAMOUNT": {
                required: 'Please enter CD Balnace.'
            },
           "POLICYNUMBER": {
                required: 'Please enter Policy Number.',
                integer: 'Please enter valid Policy Number.'
            },
            "VALUEADDSERVICE": {
                required: 'Please enter VAS.'
            }
        },
        errorElement : 'div'
    });
 });
 

</script>    
<!-- Added new validation -->

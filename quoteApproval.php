<?php

include_once("conf/company_session.php");
include_once("conf/conf.php");
include_once("conf/fucts.php");
$pageType = "Quote Approval";
include_once("inc/hd.php");


$quoteId = sanitize_data(@$_REQUEST['quoteId']);
$quoteArr = fetchListById('UNDERWRITERQUOTE','ID',$quoteId);

$productType = $quoteArr[0]['PRODUCT'];

if($productType == 'GPA')
{
    $industryList = fetchListCond('GPAINDUSTRY', " WHERE STATUS = 'ACTIVE' order by INDUSTRYID ASC");
    $locationList = fetchListCond('GPALOCATION', " WHERE STATUS = 'ACTIVE' order by LOCATIONID ASC");
    $familyList   = fetchListCond('CRMGPAFAMILYSTRUCTURE', " WHERE STATUS = 'ACTIVE' order by ID ASC");
}
else if($productType == 'GTI')
{
    $industryList = fetchListCond('GTIINDUSTRY', " WHERE STATUS = 'ACTIVE' order by INDUSTRYID ASC");
    $locationList = fetchListCond('GTILOCATION', " WHERE STATUS = 'ACTIVE' order by LOCATIONID ASC");
    $familyList   = fetchListCond('CRMQTPGTIFAMILYSTRUCTURE', " WHERE STATUS = 'ACTIVE' order by ID ASC");
}
else if($productType == 'GHI')
{
    $industryList = fetchListCond('CRMOAQINDUSTRY', " WHERE STATUS = 'ACTIVE' order by ID ASC");
    $locationList = fetchListCond('CRMOAQLOCATION', " WHERE STATUS = 'ACTIVE' order by ID ASC");
    $familyList   = fetchListCond('CRMOAQFAMILYSTRUCTURE', " WHERE STATUS = 'ACTIVE' AND VISIBLEALL = 'yes' order by ID ASC");
}

/*$productType = sanitize_data(@$_REQUEST['product']);
if($productType=='GHI')
{
    $quoteArr   = quoteDetails($quoteId);
}
else if($productType=='GPA')
{
    $quoteArr = gpaQuoteDetails($quoteId);
}
*/

/*
$mapping_info = fetchListCondsWithColumn("ID,PAGEACTIONSTR","CRMROLEMATRIXMAPPING"," where SOURCEID='".$_SESSION['typeId']."' AND STATUS='Active' ");
$pageactionstr    = $mapping_info[0]["PAGEACTIONSTR"]; 
$pageactionstr_arr= json_decode($pageactionstr,true);
*/ 
?>

<!-- error/success message display 26/02/2016 12:11 @SHAKTIRANA-->
<?php if(@$_SESSION['quoteapprovalfail']){ ?>
<div class="errorMessage"><?= $_SESSION['quoteapprovalfail']; unset($_SESSION['quoteapprovalfail']); ?></div>
<?php } ?>
<!-- error/success message display -->

<!-- New Validation. 01/02/2016 @SHAKTIRANA -->
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>
<script type="text/javascript">
    var SOURCE_RM = '<?php echo SOURCE_RM ?>';
    var SOURCE_UNDERWRITER = '<?php echo SOURCE_UNDERWRITER ?>';
</script>
<script type="text/javascript" id="qtpconstants" src="js/qtpconstants.js"></script>
<!--<script type="text/javascript" src="js/qtpconstants.js"></script>-->
<style>
.error{
	color: #F00 !important;
	float: left !important;
        position: relative;    
        padding-right: 20px !important;
    /*padding-top: 30px !important;*/
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
<!-- New Validation. 01/02/2016 @SHAKTIRANA -->

<section>

    <form action="writeQuoteApproval.php" method="POST" name="quoteapproval" id="quoteapproval" autocomplete="off" enctype="multipart/form-data" >
            <!--<form action="writeQuoteApproval.php" method="POST" name="quoteapproval" id="quoteapproval" onsubmit="return validate();" autocomplete="off">-->
            
                <?php
                include_once 'quoteDetailView.php';
                if(in_array($quoteArr[0]['STATUS'], 
                    array(STATUS_PENDING_UWAPPROVAL, STATUS_PENDING_RATEAPPROVAL, STATUS_MOREINFO_REQUIRED, STATUS_PENDING_RIAPPROVAL, STATUS_PUTONHOLD)))
                {
                    if($_SESSION['userId'] == $quoteArr[0]['USERID'])
                    {
                        $moreInfoRequired = ($quoteArr[0]['STATUS']==STATUS_MOREINFO_REQUIRED) ? 1 : 0;
                        include("userQuoteApproval.php");            
                    }               
                    else if($_SESSION['type']== SOURCE_UNDERWRITER)
                    {
                        $premiumRange = fetchcolumnListCond('PMUM_MIN_RANGE, PMUM_MAX_RANGE', 'CRMOAQUSER', "WHERE ID=". $_SESSION['userId']);
                        if(!$premiumRange[0]['PMUM_MIN_RANGE'] || !$premiumRange[0]['PMUM_MAX_RANGE'])
                        {
                            $premiumRangeError = @$premiumRange[0]['PMUM_MIN_RANGE']."-".@$premiumRange[0]['PMUM_MAX_RANGE'];            
                        }
                        else if ($premiumRange[0]['PMUM_MIN_RANGE'] > $_POST['RATEPREMIUM'])
                        {
                            $premiumRangeError = @$premiumRange[0]['PMUM_MIN_RANGE']."-".@$premiumRange[0]['PMUM_MAX_RANGE'];            
                        }
                        
                        if($quoteArr[0]['STATUS'] != STATUS_PENDING_RATEAPPROVAL)
                        {
                            $moreInfoRequired = ($quoteArr[0]['STATUS']==STATUS_MOREINFO_REQUIRED) ? 1 : 0;
                            $backToRi = ($quoteArr[0]['STATUS']==STATUS_PENDING_RIAPPROVAL) ? 1 : 0; 
                            
                            include("uwQuoteApproval.php");       
                        }
                        else
                        {
                            include("miscQuoteApproval.php");       
                        }                        
                    }
                    else if($_SESSION['type']== SOURCE_RI)
                    {
                        $backToRi = ($quoteArr[0]['STATUS']==STATUS_PENDING_RIAPPROVAL) ? 1 : 0; 
                        include("riQuoteApproval.php");
                    }
                }
                else if(($quoteArr[0]['STATUS']==STATUS_APPROVED) && ($_SESSION['type']== SOURCE_RM))
                {  
                    //added a hidden field to limit the NEWRATEPREMIUMDISCOUNT
                    $discount       = fetchcolumnListCond('MAXDISCOUNT, GPAMAXDISCOUNT', 'CRMOAQSOURCE', "WHERE ID = ".$_SESSION['typeId']);
                    $maxDiscount    = ($_POST['PRODUCTTYPE'] == 'GHI') ? $discount[0]['MAXDISCOUNT'] : $discount[0]['GPAMAXDISCOUNT'];
                    $NEWRATEPREMIUMDISCOUNT = round(($quoteArr[0]['PREMIUMAMOUNT'] * (100-$maxDiscount))/100 ,2);
                    include("miscQuoteApproval.php");       
                }
                else if(in_array($quoteArr[0]['STATUS'], array(STATUS_PENDING_FORPOLICYISSUANCE, STATUS_POLICY_INFOREQUIRED, STATUS_POLICY_PUTONHOLD)))
                {   
                    if($_SESSION['type']== SOURCE_RM)
                    {                
                        $policyInfoReq = ($quoteArr[0]['STATUS']==STATUS_POLICY_INFOREQUIRED) ? 1 : 0;
                        include("rmPolicyIssuance.php");       
                    }
                    else if($_SESSION['type'] == SOURCE_OPERATIONS)
                    {           
                        $moreInfoRequiredPI = ($quoteArr[0]['STATUS']==STATUS_PENDING_FORPOLICYISSUANCE || $quoteArr[0]['STATUS']==STATUS_POLICY_PUTONHOLD) ? 0 : 1;
                        include("quotePolicyIssuance.php");       
                    } 
                }
                else
                {
                    echo ' ';
                }
    ?>

    </form>
   
<?php

include ('documentHistory.php'); 
include ('quoteHistory.php'); 
?>
    
</section>
<script type="text/javascript">

    $(document).ready(function () {
        $("#SELECTINTERMEDIARY").click(function () {
            if($("#SELECTINTERMEDIARY").val()=='Direct')
                        $( "#MANDATETYPE").parent().parent().parent().css( "display", "none" );
                        else
          $( "#MANDATETYPE").parent().parent().parent().css( "display", "block" );
        });

    });

    //make all input, select, radio  disabled of quote form.
    $(document).ready(function() {
        $('.disabledclass').find('input, select, radio').attr('disabled', 'true');
    });
    
    if($("#SELECTINTERMEDIARY").val()=='Direct')
    {       
        $( "#MANDATETYPE").parent().parent().parent().css( "display", "none" );
    }
    else
    {
        $( "#MANDATETYPE").parent().parent().parent().css( "display", "block" );
    }
       
</script>


<script>        
    $("#riRequestId").on('change', function () {
        var val = $('[id="RIREQUEST"]:checked').val();
        
        var valm = $('[id="MOREINFO"]:checked').val();

        if (val == 1) {
            $("#buttonmovetori").attr("href", "javascript:void(0);");
            $("#buttonmovetori").attr("onclick", "backToRMOrMoveToRI(STATUS_PENDING_RIAPPROVAL,'move_to_ri_team_remark');");            
            $("#rirequestremarkbutton").attr("style", "display:block");
            $("#uploadsection").attr("style", "display:none");            
        }
        else
        {
            $("#buttonmovetori").removeAttr("href");
            $("#buttonmovetori").removeAttr("onclick");        
            $("#rirequestremarkbutton").attr("style", "display:none");
            $("#uploadsection").attr("style", "display:block");
            if(valm == 1)
            {
                $("#uploadsection").attr("style", "display:none");
            }
        }
    });
    $("#moreInfoId").on('change', function () {
        var val = $('[id="MOREINFO"]:checked').val();
        var valr = $('[id="RIREQUEST"]:checked').val();
        

        if (val == 1) {
            $("#buttonbacktorm").attr("href", "javascript:void(0);");
            $("#buttonbacktorm").attr("onclick", "backToRMOrMoveToRI(STATUS_MOREINFO_REQUIRED,'Send_Back_to_RM');");            
            $("#moreinforemarkbutton").attr("style", "display:block");    
            $("#uploadsection").attr("style", "display:none");
            
        } else {
            $("#buttonbacktorm").removeAttr("href");
            $("#buttonbacktorm").removeAttr("onclick");
            $("#uploadsection").attr("style", "display:block");
            $("#moreinforemarkbutton").attr("style", "display:none");
            if(valr == 1)
            {
                $("#uploadsection").attr("style", "display:none");
            }
        }
    });
    
    
    //Sub buttons on quote approval call this function
    function backToRMOrMoveToRI(status,remark_class)
    {
        $(".submit-btn").hide();
        $(".cancel-btn").hide();
        var quoteId = '<?= @$quoteId;?>';
        var productType = '<?= @$productType;?>';
        //var remarks = $("textarea[name="+remark_name+"]").val();
        var remarks = $("."+remark_class).val();
        //File updload validation. 01/03/2016 @SHAKTIRANA
        if(status == STATUS_REJECTED || status== STATUS_PUTONHOLD || status==STATUS_POLICY_PUTONHOLD || status== STATUS_POLICY_INFOREQUIRED || status==STATUS_PENDING_RIAPPROVAL || status== STATUS_MOREINFO_REQUIRED)
        {
            
        }
        else
        {
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
            if(flag==0)
            { 
                flag=1;
                $(".submit-btn").show();
                return false;
            }            
        }
        //File updload validation. 01/03/2016 @SHAKTIRANA
        $.ajax({
                type : 'POST',
                url  : 'moreInfoMoveRI.php',
                data : {status: status, quoteId: quoteId, productType: productType,remarks: remarks},
                success : function(data)
                            {   
                                if(data == 'success')
                                {
                                    window.location.href= 'quote_list.php';  
                                }
                                else
                                {
                                    $(".submit-btn").show();
                                    $(".cancel-btn").hide();
                                }
                            }
            });            
	}
    
    //Main buttons on quote approval call this function
    function formSubmit(status,remark_class)
    {
        $("#STATUS").val(status);         
        $("#main_remark").val( $("."+remark_class).val());		
        
        if(status==STATUS_REJECTED || status==STATUS_PUTONHOLD || status == STATUS_POLICY_PUTONHOLD)
        {
        }
        else
        {
            flag=1;
            $('.additional_file').each(function(){
            if(this.value!="")
            {
                var file_name = this.value;
                var filext = file_name.substring(file_name.lastIndexOf(".")+1);
                var file_id = this.id;
                var file_id_no=  file_id.substring(file_id.lastIndexOf("_")+1)
                if($("#DOCUMENTNAME_"+file_id_no).val()=="")
                { 
                    $("#error-"+this.id).html("Please Select Document type");  
                    flag=0;
                }
                else if(filext == "doc" || filext == "docx"|| filext == "pdf"|| filext == "xls"|| filext == "xlsx")
                { 
                    return true; 
                }
                else
                {
                    $("#error-"+this.id).html("Invalid File Format.Use doc,docx,pdf,xls,xlsx only");
                    flag=0;   
                }
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
                flag=1;
                return false;
            }            
        }
        
        $("#quoteapproval").submit();        
    }
    
   $("#obtainquote").click(function () {
       
      $("#obtainId").toggle();
      $(".title-bgPlus").toggleClass("title-bgMinus");      
   });
    
    
</script>

<!-- Added new validation - 01/03/2016 17:05 @SHAKTIRANA -->
<script type="text/javascript">
  $(document).ready(function(){
        
            $.validator.addMethod("onlyNumeric", function(value, element) {    
                    //return this.optional(element) || /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/.test(value);
                    return this.optional(element) || /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/.test(value);
                }, "Please enter valid Rates.");    
           
            $.validator.addMethod("ratePremium", function(value, element) {  
                    var ratePremium = $('#RATEPREMIUM').val();
                    var premium     = $('#RATEPREMIUMRANGELIMIT').val();
                    if(premium != '')
                    {
                        premium         = premium.split('-');
                        if(premium[0]=='' || premium[1]=='')
                        {
                            errorMsg = false;
                        }                    
                        else
                        {
                            premium[0] = parseInt(premium[0]);                        
                            errorMsg = true;
                            if(premium[0] > ratePremium)
                            {
                                errorMsg = false;
                            }                        
                        }
                        //else if(ratePremium.isBetween(premium[0],premium[1]))
                        return this.optional(element) || errorMsg;
                    }
                    return this.optional(element);
                }, 
                function(){
                    var ratePremium = $('#RATEPREMIUM').val();
                    var premium     = $('#RATEPREMIUMRANGELIMIT').val();
                    var errorMsg    = '';
                    premium         = premium.split('-');
                    if(premium[0]=='' || premium[1]=='')
                    {
                        errorMsg = 'Rate is not defined.';
                    }
                    else
                    {
                        premium[0] = parseInt(premium[0]);
                        if(premium[0] > ratePremium)
                        {
                            errorMsg = "Rate must be greater than "+ premium[0];
                        }
                    } 
                    return errorMsg;
                });    
                
            $.validator.addMethod("discountPremium", function(value, element) {    
                    var newPremium = parseInt($('#NEWRATEPREMIUM').val());
                    var newPremiumDiscount =parseInt($('#NEWRATEPREMIUMDISCOUNT').val());
                    return newPremium >= newPremiumDiscount;
                }, "New Rate(s) must be greater than "+ $('#NEWRATEPREMIUMDISCOUNT').val());    
		
      //added custom validation.
      $("#quoteapproval").validate({
        ignore: [], // this will allow to validate any hidden field inside a form
        errorPlacement: function(error, element) {
            $.each(element, function(key, value) {
                $("#error-"+value.name).replaceWith(error);
              });
        },
        rules: {
            "RATEPREMIUM": {
                required: {
                    depends: function() {
                        //return $.inArray($('#STATUS').val(), [STATUS_PUTONHOLD, STATUS_REJECTED]) == '-1';
                        return $('#STATUS').val() == STATUS_APPROVED;
                    }
                },
                onlyNumeric: {
                    depends: function() {
                        //return $.inArray($('#STATUS').val(), [STATUS_PUTONHOLD, STATUS_REJECTED]) == '-1';
                        return $('#STATUS').val() == STATUS_APPROVED;
                    }
                },
                ratePremium: {
                    depends: function() {
                        //return $.inArray($('#STATUS').val(), [STATUS_PUTONHOLD, STATUS_REJECTED]) == '-1';
                        return $('#STATUS').val() == STATUS_APPROVED;
                    }
                }
            },           
            "NEWRATEPREMIUM": { 
                required: {
                    depends: function() {
                        return $('#RATEPREMIUM').val() != '' && $('#STATUS').val() != STATUS_REJECTED;
                    }
                },
                //number: true,
                onlyNumeric: {
                    depends: function() {
                        return $('#RATEPREMIUM').val() != '' && $('#STATUS').val() != STATUS_REJECTED;
                    }
                },
                discountPremium: {
                    depends: function() {
                        return $('#RATEPREMIUM').val() != '' && $('#STATUS').val() != STATUS_REJECTED;
                    }
                }
            }
        },
        messages: {
            "RATEPREMIUM": {
                required: 'Please enter Rates.',
                //notStartWithNumeric: 'Please enter valid Rates.'
            },
            "NEWRATEPREMIUM": {
                required: 'Please enter New Rates.',
                //notStartWithNumeric: 'Please enter valid New Rates.'
            }
        },
        errorElement : 'div',
        //errorLabelContainer: '.errorTxtCustom'
    });
 });
 

</script>    
<!-- Added new validation -->

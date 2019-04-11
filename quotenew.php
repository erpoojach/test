<?php
$pageType = "Create Quote";

include_once("conf/company_session.php");
include_once("conf/conf.php");
include_once("conf/fucts.php");
include_once("inc/hd.php");
include_once("qtpAccessMastersByRole.php");
//qtp_include_once("inc/hd.php");

$settingsArr 		=	fetchListById('GPASETTINGS','ID','1');
$SILIMIT		= 	$settingsArr[0]['SILIMIT'];
$TOPFIFTYSILIMIT	= 	$settingsArr[0]['TOPFIFTYSILIMIT'];
$TOTALSILIMIT		= 	$settingsArr[0]['TOTALSILIMIT'];
$HIGHESTSILIMIT		= 	$settingsArr[0]['HIGHESTSILIMIT'];

$is_GHI = $_SESSION['GHI'];
$is_GPA = $_SESSION['GPA'];
$is_GTI = $_SESSION['GTI'];

foreach ($_SESSION['quoteform'] as $key => $value) {
   $$key = $value;
}


if(@$_REQUEST['upload']=='required' || @$_REQUEST['error'])
{
$quoteArr[0] = $_SESSION['quoteform'];
}
else
{
    unset($_SESSION['quoteform']);
}
//print_r($_SESSION['quoteform']);
$policyArrs = explode('_',$quoteArr[0]['POLICYTYPE']);
$gradebasisArrs = explode('_',$quoteArr[0]['GRADEBASISID']);

if(!isset($_SESSION['minLives']))
{
    $minLives = fetchListCondsWithColumn('MINLIVES, MAXLIVES, GPAMINLIVES, GPAMAXLIVES','CRMOAQSOURCE', " WHERE SOURCE ='".$_SESSION['type']."'");
    $_SESSION['minLives']       = @$minLives[0]['MINLIVES'] ? $minLives[0]['MINLIVES'] : 0;
    $_SESSION['maxLives']       = @$minLives[0]['MAXLIVES'] ? $minLives[0]['MAXLIVES'] : 500;
    $_SESSION['gpaMinLives']    = @$minLives[0]['GPAMINLIVES'] ? $minLives[0]['GPAMINLIVES'] : 0;
    $_SESSION['gpaMaxLives']    = @$minLives[0]['GPAMAXLIVES'] ? $minLives[0]['GPAMAXLIVES'] : 500;
}
?>

<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/ui.browser.js"></script>
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/additional-methods.min.js"></script>
 
<script language="javascript">
    $(document).ready(function () {
        <?php if(strstr($policyArrs[0], 'Renewal')){ ?> policyType('Renewal'); <?php } else { ?>policyType('FRESH'); <?php }  ?>
	
		function showhideData(PRODUCT)
			{
				 if (PRODUCT == 'GHI') {
						$('.onlyGHI').show();
					} else {
						$('.onlyGHI').hide();
					}
//                                    if (PRODUCT == 'GPA') { siType('Flat');}   
                                        
			}
		showhideData("<?php echo ($quoteArr[0]['PRODUCT']) != ''?$quoteArr[0]['PRODUCT']:'GHI'; ?>");
		showIntermediary();
                showhideSi("<?php echo ($quoteArr[0]['PRODUCT']) != ''?$quoteArr[0]['PRODUCT']:'GHI'; ?>");
                showParents();


        $("#POLICYSTARTDATE").datepicker({
            minDate: -0,
            maxDate:180,
            yearRange: '2000:2025',
            dateFormat: "yy-mm-dd",
        });
        $("#CLAIMDATE").datepicker({
			minDate: '-90d',
			maxDate:0,
            yearRange: '2000:2025',
            dateFormat: "yy-mm-dd"
        });
        
     function policyType(type) {
//        alert(type);
        if (type == "RENEWAL") {
            $(".policyRenewal").show();
        }
        if (type == "FRESH") {
            $(".policyRenewal").hide();
        }
    }


//        $('#ui-datepicker-div').css('width','205px!important');

    });
     $(document).ready(function () {
        $(function() {
          $('#CORPORATENAME').on('input', function() {
            this.value = this.value.replace(/^(\d+)/, '');
          });
        }); 
});
    
        function siType(type) {
        if (type == "Flat") {
            $(".gradedSI").hide();
            $(".flatSI").show();
        }
        if (type == "Graded") {
            $(".flatSI").hide();
            $(".gradedSI").show();
        }
        if (type == "") {
            $(".flatSI").hide();
            $(".gradedSI").hide();
        }
    }
    
    
function showhideSi(PRODUCT){
    var type = $('input[name=SITYPE]:checked').val();
    if (PRODUCT == 'GPA') {
      $('.onlyGPA').show();
      siType(type);
    } else {
      $('.onlyGPA').hide();
      siType('');
    }
}
//DNS MERGING

function check_validation(qt_val)
{    
    if(qt_val=='1')
    {
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
    }
     var policytype = $('input[name=POLICYTYPE]:checked').val();
     var policytypeArr = policytype.split("_");
    if(policytypeArr[0] != 'Renewal')
    {
        $('#POLICYSTARTDATE').val('');
        $('#EXPIRINGINSURER').val('');
        $('#PREMIUMAMOUNT').val('');
        $('#CLAIMAMOUNT').val('');
        $('#CLAIMDATE').val('');
    }
    if($('#SELECTINTERMEDIARY').val() == 'Direct')
    {
        $('#MANDATETYPE').val('');
    }
    if($('input[name=PRODUCT]:checked').val() == 'GPA'){
    if($('input[name=SITYPE]:checked').val() == 'Graded'){
        $('#FLATSI').val('');
    }else{
        $('#TOTALSI').val('');
        $('#TOPFIFTYSI').val('');
        $('#HIGHESTSI').val('');
        $('#GRADEBASISID').val('');
    }
    } else {
        $('#FLATSI').val('');
        $('#TOTALSI').val('');
        $('#TOPFIFTYSI').val('');
        $('#HIGHESTSI').val('');
        $('#GRADEBASISID').val('');
    }
    $("#samapping").submit();
//document.getElementById("samapping").submit();
    
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
    <div class="title-bg"><h1>Create a Quote</h1></div>
    <!--<form action="writeQuoteG.php" method="POST" name="samapping" id="samapping" onsubmit="return validateQuote();" autocomplete="off" enctype="multipart/form-data">-->
		<form action="writeQuoteG.php" method="POST" name="samapping" id="samapping" autocomplete="off" enctype="multipart/form-data">
        <div class="grayBorder">
              <?php if(@$_REQUEST['error'])
                    {
                        if(in_array($_REQUEST['error'], array('uwerror','fileuploaderror','claimratio')))
                        {
                            $error = $_SESSION[$_REQUEST['error']];
                            if($_REQUEST['error'] != 'fileuploaderror')
                            {
                                unset($_SESSION[$_REQUEST['error']]);
                            }
                        }
                    }    
                    if(@$_SESSION['fileupload'])
                    {
                        $error = $_SESSION['fileupload'];
                    }
                    
                   if(@$error){ ?> 
                    <div id="errorMsg"><?php echo $error; ?></div>
                <?php } ?>
            <div class="myPlanForm">

		<?php /* if(isset($_SESSION['quoteform'])){ ?>
            	<div  style="padding-bottom:10px;  font-size:18px; color:#F33">Please Upload Documents !</div>
      		<?php } */ ?>
                
                <div class="myPlanformBox myPlanLeft">
                    <label>Name of Corporate <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input name="CORPORATENAME" type="text" class="txtField" id="CORPORATENAME" value="<?php echo $quoteArr[0]['CORPORATENAME']; ?>"  maxlength="50"   />
                        </div>
                    </div>
                    <div id="error-CORPORATENAME"></div>
                    <div id="corpLoading"></div>                     
                    <div class="clearfix"></div></div>

                <div class="myPlanformBox myPlanLeft">
                    <label>Product <?php echo MANDFIELDS; ?></label>
                    <div class="radioBox">
                        <?php if($is_GHI == 'yes'){?> 
                           <input type="radio" name="PRODUCT" id="PRODUCTGHI" value="GHI" onclick="getProductData(this.value);showhideSi(this.value);" <?php echo !in_array($quoteArr[0]['PRODUCT'],array('GPA','GTI')) ? 'checked' : ''; ?>/> GHI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <?php } ?>
                        <?php if($is_GPA == 'yes'){?> 
                           <input type="radio" name="PRODUCT" id="PRODUCTGPA" value="GPA" onclick="getProductData(this.value);showhideSi(this.value);" <?php echo $quoteArr[0]['PRODUCT'] == 'GPA' ? 'checked' : ''; ?>/> GPA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php } ?>
                        <?php if($is_GTI == 'yes'){?> 
                           <input type="radio" name="PRODUCT" id="PRODUCTGTI" value="GTI" onclick="getProductData(this.value);;showhideSi(this.value);" <?php echo $quoteArr[0]['PRODUCT'] == 'GTI' ? 'checked' : ''; ?>/> GTI
                        <?php } ?>
                        
                        
                        
                    </div>
                    <div id="productLoading"></div>
                    <div class="clearfix"></div></div>



                <div class="myPlanformBox myPlanLeft">
                    <label>No. of Lives <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input name="NOOFEMPLOYEE" type="text" class="txtField" id="NOOFEMPLOYEE" value="<?php echo $quoteArr[0]['NOOFEMPLOYEE']; ?>" maxlength="5" onkeypress="return isNumber(event);">
                        </div>
                    </div>
                    <div id="error-NOOFEMPLOYEE"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft">
                    <label>Industry Type <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg">
                            <select name="INDUSTRYID" id="INDUSTRYID">
                                
                                <?php
								
                                if($quoteArr[0]['PRODUCT'] == 'GPA'){
                                    $industryListCond = AccessMaster::getDropdownAccessData(PRODUCT_GPA,'Industry Type');
                                    $industryList = fetchListCond('GPAINDUSTRY', " WHERE STATUS = 'ACTIVE' $industryListCond order by INDUSTRYID ASC");
                                    
                                    $i = 0;
                                    echo '<option value="">Select GPA Industry Type</option>';
                                    while ($i < count($industryList)) {
                                        $industryId = $industryList[$i]['INDUSTRYID'] . '_' . ucfirst($industryList[$i]['INDUSTRYNAME']) .'_'.$industryList[$i]['IS_CAUTIONLIST'];
                                        $gpaSelected = ($industryId == $quoteArr[0]['INDUSTRYID'])? "selected": "";  
										
                                       echo '<option value="' . $industryList[$i]['INDUSTRYID'] . '_' . ucfirst($industryList[$i]['INDUSTRYNAME']) .'_'.$industryList[$i]['IS_CAUTIONLIST']. '" '.$gpaSelected.'>' . ucfirst($industryList[$i]['INDUSTRYNAME']) . '</option>';
						
                                        $i++;
                                    }
                               } else if($quoteArr[0]['PRODUCT'] == 'GTI'){ 
                                    $industryList = fetchListCond('GTIINDUSTRY', " WHERE STATUS = 'ACTIVE' order by INDUSTRYID ASC");
                                    
                                    $i = 0;
                                    echo '<option value="">Select GTI Industry Type</option>';
                                    while ($i < count($industryList)) {
                                        $industryId = $industryList[$i]['INDUSTRYID'] . '_' . ucfirst($industryList[$i]['INDUSTRYNAME']) .'_'.$industryList[$i]['IS_CAUTIONLIST'];
                                        $gpaSelected = ($industryId == $quoteArr[0]['INDUSTRYID'])? "selected": "";                                         
                                       
                                        echo '<option value="' . $industryList[$i]['INDUSTRYID'] . '_' . ucfirst($industryList[$i]['INDUSTRYNAME']) .'_'.$industryList[$i]['IS_CAUTIONLIST']. '" '.$gpaSelected.'>' . ucfirst($industryList[$i]['INDUSTRYNAME']) . '</option>';
                                        $i++;
                                    }
                               } else { ?>
                                <option value="">Select GHI Industry Type</option>
                               <?php
                               $industryListCond = AccessMaster::getDropdownAccessData(PRODUCT_GHI,'Industry Type');
                               $industryList = fetchListCond('CRMOAQINDUSTRY'," WHERE STATUS = 'ACTIVE' $industryListCond order by ID ASC");
                                $i = 0;
                                while ($i < count($industryList)) {
                                $industryId = $industryList[$i]['ID'].'_'.ucfirst($industryList[$i]['INDUSTRYNAME']).'_'.$industryList[$i]['IS_CAUTIONLIST'];
                                 ?>
                                 <option value="<?php echo $industryId; ?>" <?php if ($industryId == $quoteArr[0]['INDUSTRYID']) { echo 'selected'; } ?>/><?php echo ucfirst($industryList[$i]['INDUSTRYNAME']); ?></option>
                                <?php $i++;} }?>
                                
   
                            </select>
                        </div>
                    </div>
                    <div id="error-INDUSTRYID"></div>
                    <div class="clearfix"></div></div>

                <div class="myPlanformBox myPlanLeft">
                    <label>Location <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg">
                            <select id="LOCATIONID" name="LOCATIONID">
                                 <?php
                                if($quoteArr[0]['PRODUCT'] == 'GPA'){ 
                                    $locationAccessId = AccessMaster::getDropdownAccessData(PRODUCT_GPA,'Location');
                                    $locationList = fetchListCond('GPALOCATION', " WHERE STATUS = 'ACTIVE' $locationAccessId order by LOCATIONID ASC");
                                    $i = 0;
                                    echo '<option value="">Select GPA Location</option>';
                                    while ($i < count($locationList)) {
                                        $locationid = $locationList[$i]['LOCATIONID'] . '_' . ucfirst($locationList[$i]['LOCATION']);
                                        $gpaSelectedLoc = ($locationid == $quoteArr[0]['LOCATIONID'])? "selected": ""; 
                                        echo '<option value="' . $locationList[$i]['LOCATIONID'] . '_' . ucfirst($locationList[$i]['LOCATION']) . '" '.$gpaSelectedLoc.' >' . ucfirst($locationList[$i]['LOCATION']) . '</option>';
                                        $i++;
                                    }
                                } else if($quoteArr[0]['PRODUCT'] == 'GTI'){ 
                                    $locationList = fetchListCond('GTILOCATION', " WHERE STATUS = 'ACTIVE' order by LOCATIONID ASC");
                                    $i = 0;
                                    echo '<option value="">Select GTI Location</option>';
                                    while ($i < count($locationList)) {
                                        $locationid = $locationList[$i]['LOCATIONID'] . '_' . ucfirst($locationList[$i]['LOCATION']);
                                        $gpaSelectedLoc = ($locationid == $quoteArr[0]['LOCATIONID'])? "selected": ""; 
                                        echo '<option value="' . $locationList[$i]['LOCATIONID'] . '_' . ucfirst($locationList[$i]['LOCATION']) . '" '.$gpaSelectedLoc.' >' . ucfirst($locationList[$i]['LOCATION']) . '</option>';
                                        $i++;
                                    }
                                } else { ?>
                                <option value="">Select GHI Location</option>
                                <?php
                                $locationAccessId = AccessMaster::getDropdownAccessData(PRODUCT_GHI,'Location');
                                $locationList = fetchListCond('CRMOAQLOCATION'," WHERE STATUS = 'ACTIVE' $locationAccessId order by ID ASC");
                                $i = 0;
                                while ($i < count($locationList)) {
                                    ?>
                                    <option value="<?php echo $locationList[$i]['ID']; ?>_<?php echo $locationList[$i]['LOCATIONNAME']; ?>_<?php echo $locationList[$i]['LOCATIONTYPEID']; ?>" <?php echo ($locationList[$i]['ID'] . '_' . $locationList[$i]['LOCATIONNAME'].'_'.$locationList[$i]['LOCATIONTYPEID'] == $quoteArr[0]['LOCATIONID']) ? ' selected' : ''; ?>><?php echo ucfirst($locationList[$i]['LOCATIONNAME']); ?></option>
                               <?php $i++;}}  ?>
                            </select>
                        </div>
                    </div>
                    <div id="error-LOCATIONID"></div>
                    <div class="clearfix"></div></div>
                    
                <div class="myPlanformBox myPlanLeft">
                    <label>Family Structure<?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg">
                            <select name="FAMILYDEFINITION" id="FAMILYDEFINITION" onchange="showParents();">
                                <?php
                                if($quoteArr[0]['PRODUCT'] == 'GPA'){ 
                                    $i = 0;
                                    echo '<option value="">Select Family</option>';
                                    $familyListId = AccessMaster::getDropdownAccessData(PRODUCT_GPA,'Family Structure');
                                    $familyList = fetchListCond('CRMGPAFAMILYSTRUCTURE', " WHERE STATUS = 'ACTIVE' $familyListId order by ID ASC");
                                    while ($i < count($familyList)) {
                                        $familyDefinition = $familyList[$i]['ID'] . '_' . $familyList[$i]['CHECKRATIO'] . '_' . ucfirst($familyList[$i]['FAMILYSTRUCTURE']) . '_' . $familyList[$i]['QUOTETYPE'];
                                        $gpaSelectedFmly = ($familyDefinition == $quoteArr[0]['FAMILYDEFINITION'])? "selected": ""; 
                                        echo '<option value="' . $familyList[$i]['ID'] . '_' . $familyList[$i]['CHECKRATIO'] . '_' . ucfirst($familyList[$i]['FAMILYSTRUCTURE']) . '_' . $familyList[$i]['QUOTETYPE'] . '" '.$gpaSelectedFmly.'>' . ucfirst($familyList[$i]['FAMILYSTRUCTURE']) . '</option>';
                                        $i++;
                                    }
                                } else if($quoteArr[0]['PRODUCT'] == 'GTI'){ 
                                    $i = 0;
                                    echo '<option value="">Select Family</option>';
                                    $familyList = fetchListCond('CRMQTPGTIFAMILYSTRUCTURE', " WHERE STATUS = 'ACTIVE' order by ID ASC");
                                    while ($i < count($familyList)) {
                                        $familyDefinition = $familyList[$i]['ID'] . '_' . $familyList[$i]['CHECKRATIO'] . '_' . ucfirst($familyList[$i]['FAMILYSTRUCTURE']) . '_' . $familyList[$i]['QUOTETYPE'];
                                        $gpaSelectedFmly = ($familyDefinition == $quoteArr[0]['FAMILYDEFINITION'])? "selected": ""; 
                                        echo '<option value="' . $familyList[$i]['ID'] . '_' . $familyList[$i]['CHECKRATIO'] . '_' . ucfirst($familyList[$i]['FAMILYSTRUCTURE']) . '_' . $familyList[$i]['QUOTETYPE'] . '" '.$gpaSelectedFmly.'>' . ucfirst($familyList[$i]['FAMILYSTRUCTURE']) . '</option>';
                                        $i++;
                                    }
                                }else{ ?>
                                <option value="">Select Family</option>
                                <?php
                                $familyListId = AccessMaster::getDropdownAccessData(PRODUCT_GHI, 'Family Structure');
                                //$familyList = fetchListCond('CRMOAQFAMILYSTRUCTURE', " WHERE STATUS = 'ACTIVE' AND VISIBLEALL = 'yes' $locationAccessIds order by ID ASC");
                                $familyList = fetchListCond('CRMOAQFAMILYSTRUCTURE', " WHERE STATUS = 'ACTIVE' AND VISIBLEALL = 'yes' $familyListId ORDER by ID ASC");
                                $i = 0;
                                while ($i < count($familyList)) {
                                    ?>
                                    <option value="<?php echo $familyList[$i]['ID']; ?>_<?php echo $familyList[$i]['CHECKRATIO']; ?>_<?php echo ucfirst($familyList[$i]['FAMILYSTRUCTURE']); ?>_<?php echo $familyList[$i]['QUOTETYPE']; ?>" <?php echo ($familyList[$i]['ID'].'_'.$familyList[$i]['CHECKRATIO']."_".ucfirst($familyList[$i]['FAMILYSTRUCTURE'])."_".$familyList[$i]['QUOTETYPE'] == $quoteArr[0]['FAMILYDEFINITION'])?' selected':'';?>><?php echo ucfirst($familyList[$i]['FAMILYSTRUCTURE']); ?></option>
                                    <?php $i++;
                                }}
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="error-FAMILYDEFINITION"></div>
                    <div class="clearfix"></div></div>
                
                <div class="myPlanformBox myPlanLeft onlyGHI">
                    <label>No. of Employees <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="EMPLOYEENO" id="EMPLOYEENO" class="txtField" value="<?php echo @$quoteArr[0]['EMPLOYEENO']; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="error-EMPLOYEENO"></div>        
                </div>
                    
                <div class="myPlanformBox myPlanLeft parentsno" style="display:none">
                    <label>No. of Parents  <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="PARENTSNO" id="PARENTSNO" class="txtField" value="<?php echo @$quoteArr[0]['PARENTSNO']; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="error-PARENTSNO"></div>    
                </div>    

                <div class="myPlanformBox myPlanLeft">
                    <label>Is  Every  Employee / Member in Company Covered <?php echo MANDFIELDS; ?></label>
                    <div class="radioBox">
                        <input type="radio" name="CONTRIBUTORYTYPE" class="CONTRIBUTORYTYPE" value="Non-Contributory" <?php if ($quoteArr[0]['CONTRIBUTORYTYPE'] == 'Non-Contributory') { echo 'checked'; } if ($quoteArr[0]['CONTRIBUTORYTYPE'] == '') { echo 'checked'; } ?> /> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <!-- <input type="radio" name="CONTRIBUTORYTYPE" class="CONTRIBUTORYTYPE" value="Contributory" <?php// if ($quoteArr[0]['CONTRIBUTORYTYPE'] != 'Non-Contributory') { echo 'checked'; } ?>  /> No   commented by shailender -->
                      <input type="radio" name="CONTRIBUTORYTYPE" class="CONTRIBUTORYTYPE" value="Contributory" <?php if ($quoteArr[0]['CONTRIBUTORYTYPE'] == 'Contributory') { echo 'checked'; } ?>  /> No
                    </div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft onlyGHI">
                    <label>Type of Health Card <?php echo MANDFIELDS; ?> </label>
                    <div class="radioBox">
                        <input type="radio" name="CARDTYPE" id="CARDTYPE" value="ecard" <?php echo $quoteArr[0]['CARDTYPE']!='physical'?'checked="checked"':'';?>>E-Card&nbsp;&nbsp;
                        <input type="radio" name="CARDTYPE" id="CARDTYPE" value="physical" <?php echo $quoteArr[0]['CARDTYPE']=='physical'?'checked="checked"':'';?>>Physical
                    </div>
                    <div class="clearfix"></div></div>

                <div class="myPlanformBox myPlanLeft">
                    <label>Intermediary(Broker/Agent/Direct)Name <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg">
                            <select id="SELECTINTERMEDIARY" name="SELECTINTERMEDIARY" onchange="showIntermediary()">
                                <option value="">Select Intermediary</option>
                               <?php
                                if ($quoteArr[0]['PRODUCT'] == 'GPA') {
                                    $intTable = 'GPAINTERMEDIARY';
                                    $insurer_list_Id = AccessMaster::getDropdownAccessData(PRODUCT_GPA, 'Intermediary');
                                } else if ($quoteArr[0]['PRODUCT'] == 'GTI') {
                                    $intTable = 'GTIINTERMEDIARY';
                                    $insurer_list_Id = '';
                                } else {
                                    $intTable = 'CRMOAQINTERMEDIARY';
                                    $insurer_list_Id = AccessMaster::getDropdownAccessData(PRODUCT_GHI, 'Intermediary');
                                }
                                $insurer_list = fetchListCond($intTable, " WHERE STATUS = 'ACTIVE' $insurer_list_Id order by INTERMEDIARY ASC");
                                $b = 0;
                                while ($b < count($insurer_list)) {//loop to fetch list
                                    ?>
                                    <option value="<?php echo $insurer_list[$b]['INTERMEDIARY']; ?>" <?php echo ($insurer_list[$b]['INTERMEDIARY'] == $quoteArr[0]['SELECTINTERMEDIARY']) ? ' selected' : ''; ?>><?php echo $insurer_list[$b]['INTERMEDIARY']; ?></option>
                                    <?php $b++;
                                }
                                ?>
                                <option value="other" <?php echo ($quoteArr[0]['SELECTINTERMEDIARY'] == 'other') ? ' selected' : ''; ?>>Other, Please specify</option>
                            </select> 
                            
                        </div>
                    </div>
                    <div id="error-SELECTINTERMEDIARY"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft" id="otherintermediary" style="display:<?php echo $quoteArr[0]['SELECTINTERMEDIARY'] != 'other' ? 'none' : 'block'; ?>;">
                    <label>Other Intermediary </label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="OTINTERMEDIARY" id="OTINTERMEDIARY" class="txtField" value="<?php echo $quoteArr[0]['OTINTERMEDIARY']; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div></div>




                <div class="myPlanformBox myPlanLeft" style="display:none">
                    <label>RM Name <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="RMNAME" id="RMNAME" class="txtField" value="<?php echo $quoteArr[0]['RMNAME']; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div></div>

                <div class="myPlanformBox myPlanLeft">
                    <label>RM Email-ID <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="RMEMAIL" id="RMEMAIL" class="txtField" value="<?php echo $quoteArr[0]['RMEMAIL']; ?>">
                        </div>
                    </div>
                    <div id="error-RMEMAIL"></div>
                    <div class="clearfix"></div></div>
				
		<?php if($quoteArr[0]['SELECTINTERMEDIARY']!='Direct'){ ?>
                <div class="myPlanformBox myPlanLeft">
                    <label>Mandate Type <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg" id="MANDATETYPEDIV">
                            <?php
                            $pProductforInputControl = ($quoteArr[0]['PRODUCT'])?$quoteArr[0]['PRODUCT']:PRODUCT_GHI; // used in mandate type, policy structure and expiring insurer
                            echo $mandateTypeData = AccessMaster::getStaticDropdownAccessData($pProductforInputControl,'Mandate Type','MANDATETYPE','MANDATETYPE',$quoteArr[0]['MANDATETYPE']);?>                          
                            
                        </div>
                    </div>
                    <div id="error-MANDATETYPE"></div>
                    <div class="clearfix"></div></div>
                    <?php } ?>


                <div  class="myPlanformBox myPlanLeft">
                    <label>Policy Structure <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg">
                            <select id="POLICYSTRUCTURE" name="POLICYSTRUCTURE">
                                <option value="">Select Policy Structure</option>
<?php
$policyListId = AccessMaster::getDropdownAccessData($pProductforInputControl, 'Policy Structure');
$policyList = fetchListCond('CRMQTPPOLICYSTRUCTURE', " WHERE STATUS = 'ACTIVE' $policyListId order by ID ASC");
$i = 0;
while ($i < count($policyList)) {
    ?>
                                    <option value="<?php echo $policyList[$i]['ID']; ?>_<?php echo $policyList[$i]['POLICYSTR']; ?>" <?php echo ($policyList[$i]['ID'] . '_' . $policyList[$i]['POLICYSTR'] == $quoteArr[0]['POLICYSTRUCTURE']) ? ' selected' : ''; ?> ><?php echo ucfirst($policyList[$i]['POLICYSTR']); ?></option>
    <?php $i++;
} ?>
                            </select>
                        </div>
                    </div>
                    <div id="error-POLICYSTRUCTURE"></div>
                    <div class="clearfix"></div></div>
                    
                    <div class="myPlanformBox myPlanLeft">
                    <label>Policy Type <?php echo MANDFIELDS; ?></label>
                    <div class="radioBox">
                        <?php
                        $sourceList = fetchListCond('CRMOAQPOLICYTYPE', " WHERE STATUS = 'ACTIVE' order by ID ASC");
                        $i = 0;
                        while ($i < count($sourceList)) {
                            ?>
                            &nbsp;&nbsp;<input type="radio" name="POLICYTYPE" id="POLICYTYPE" onclick="policyType('<?php echo $sourceList[$i]['TYPE']; ?>')"
                                         <?php if ($sourceList[$i]['TYPE'] == $policyArrs[0]) { echo 'checked';} else if (!@$policyArrs[0]) { echo 'checked';}?>
                            value="<?php echo $sourceList[$i]['TYPE']; ?>_<?php echo $sourceList[$i]['LOADINGPERCENT']; ?>"> <?php echo ucfirst($sourceList[$i]['TYPE']); ?>
    <?php $i++;
} ?>
                    </div>
                    <div class="clearfix"></div></div>

					<div class="myPlanformBox myPlanLeft policyRenewal">
                    <label>Policy Start Date <?php echo MANDFIELDS; ?> </label>
                    <div class="inputBox">
                        <div class="inputBoxIn dateBg">
                            <input type="text" name="POLICYSTARTDATE" id="POLICYSTARTDATE" class="txtField Summary_calendarBox"  value="<?php echo $quoteArr[0]['POLICYSTARTDATE']; ?>"/>
                        </div>
                    </div>
                    <div id="error-POLICYSTARTDATE"></div>
                    <div class="clearfix"></div></div>
                    
                    
                <div class="myPlanformBox myPlanLeft policyRenewal">
                    <label>Expiring Insurer<?php echo MANDFIELDS; ?> </label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg">
                            <select id="EXPIRINGINSURER" name="EXPIRINGINSURER">
                                <option value="">Select Insurer</option>
                                <?php
                                $insurer_listId = AccessMaster::getDropdownAccessData($pProductforInputControl, 'Expiring Insurer');
                                $insurer_list = fetchListCond('CRMOAQINSURER', " WHERE STATUS = 'ACTIVE' $insurer_listId order by ID desc");
                                $b = 0;
                                while ($b < count($insurer_list)) {//loop to fetch list
                                    ?>
                                    <option value="<?php echo $insurer_list[$b]['ID']; ?>_<?php echo $insurer_list[$b]['INSURER']; ?>" <?php echo ($quoteArr[0]['EXPIRINGINSURER'] == $insurer_list[$b]['ID'] . '_' . $insurer_list[$b]['INSURER']) ? "selected" : ""; ?>><?php echo $insurer_list[$b]['INSURER']; ?></option>
                                    <?php $b++;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="error-EXPIRINGINSURER"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft policyRenewal">
                    <label>Expiring Premium<?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input type="text" name="PREMIUMAMOUNT" id="PREMIUMAMOUNT" class="txtField" value="<?php echo $quoteArr[0]['PREMIUMAMOUNT']; ?>">
                        </div>
                    </div>
                    <div id="error-PREMIUMAMOUNT"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft policyRenewal">
                        <label>Claim Amount <?php echo MANDFIELDS; ?></label>
                        <div class="inputBox">
                            <div class="inputBoxIn">
                                <input type="text" name="CLAIMAMOUNT" id="CLAIMAMOUNT" class="txtField" value="<?php echo $quoteArr[0]['CLAIMAMOUNT']; ?>">
                            </div>
                        </div>
                        <div id="error-CLAIMAMOUNT"></div>
                        <div class="clearfix"></div></div>                
                    

                    <div class="myPlanformBox myPlanLeft policyRenewal">
                        <label>Claim Date <?php echo MANDFIELDS; ?></label>
                        <div class="inputBox">
                            <div class="inputBoxIn dateBg">
                                <input type="text" name="CLAIMDATE" id="CLAIMDATE" class="txtField"  value="<?php echo $quoteArr[0]['CLAIMDATE']; ?>">
                            </div>
                        </div>
                        <div id="error-CLAIMDATE"></div>
                        <div class="clearfix"></div></div>
                        
                        
                <div class="myPlanformBox myPlanLeft onlyGPA" style="display:none;">
                    <label>SumInsured Type <?php echo MANDFIELDS; ?></label>
                    <div class="radioBox">	
                        &nbsp;&nbsp;<input type="radio" name="SITYPE" id="SITYPE" value="Flat" <?php echo $quoteArr[0]['SITYPE'] != 'Graded' ? 'checked' : ''; ?> onclick="siType('Flat')">
                        Flat&nbsp;&nbsp;<input type="radio" name="SITYPE" id="SITYPE" value="Graded" <?php echo $quoteArr[0]['SITYPE'] == 'Graded' ? 'checked' : ''; ?> onclick="siType('Graded')">&nbsp;&nbsp;Graded
                    </div>
                    <div class="clearfix"></div></div> 
                    
                   <div class="myPlanformBox myPlanLeft gradedSI">
                    <label>Highest Sum Insured <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input name="HIGHESTSI" type="text" class="txtField" id="HIGHESTSI" value="<?php echo $quoteArr[0]['HIGHESTSI']; ?>"/>
                        </div>
                    </div>
                    <div id="error-HIGHESTSI"></div>
                    <div class="clearfix"></div></div>
            
                <div class="myPlanformBox myPlanLeft gradedSI">
                    <label>Total SI <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input name="TOTALSI" type="text" class="txtField" id="TOTALSI" value="<?php echo $quoteArr[0]['TOTALSI']; ?>" />
                        </div>
                    </div>
                    <div id="error-TOTALSI"></div>
                    <div class="clearfix"></div></div>
                    
                <div class="myPlanformBox myPlanLeft gradedSI">
                    <label>Top 50 Lives SI <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input name="TOPFIFTYSI" type="text" class="txtField" id="TOPFIFTYSI" value="<?php echo $quoteArr[0]['TOPFIFTYSI']; ?>" />
                        </div>
                    </div>
                    <div id="error-TOPFIFTYSI"></div>
                    <div class="clearfix"></div></div>




                <div class="myPlanformBox myPlanLeft gradedSI">
                    <label>Grade Basis <?php echo MANDFIELDS; ?></label>
                    <div class="inputBox">
                        <div class="inputBoxIn dropBg">
                            <select name="GRADEBASISID" id="GRADEBASISID">
                                <option value="">Select Grade Basis</option>
                                <?php
                                $gradebasisIds = AccessMaster::getDropdownAccessData(PRODUCT_GPA, 'Grade Basis');
                                $industryList  = fetchListCond('GPAGRADEBASIS', " WHERE STATUS = 'ACTIVE' $gradebasisIds order by GRADEBASIS ASC");
                                $i = 0;
                                while ($i < count($industryList)) {
                                    ?>
                                    <option value="<?php echo $industryList[$i]['GRADEBASISID']; ?>_<?php echo ucfirst($industryList[$i]['GRADEBASIS']); ?>" <?php
                                            if ($industryList[$i]['GRADEBASISID'] == $gradebasisArrs[0]) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo ucfirst($industryList[$i]['GRADEBASIS']); ?></option>
    <?php
    $i++;
}
?>
                            </select>
                        </div>
                    </div>
                    <div id="error-GRADEBASISID"></div>
                    <div class="clearfix"></div></div>


                <div class="myPlanformBox myPlanLeft flatSI">
                    <label>Individual SI <?php echo MANDFIELDS; ?></label> 
                    <div class="inputBox">
                        <div class="inputBoxIn">
                            <input name="FLATSI" type="text" class="txtField" id="FLATSI" value="<?php echo $quoteArr[0]['FLATSI']; ?>" />
                        </div>
                    </div>
                    <div id="error-FLATSI"></div>
                    <div class="clearfix"></div></div>


                        
                        
                <div class="clearfix"></div></div>
               <?php if(isset($_SESSION['quoteform']['CORPORATENAME']) && $_SESSION['quoteform']['CORPORATENAME'] != '' && $_SESSION['fileupload'])
                {                     
                    unset($_SESSION['fileupload']);
                    //include_once('qtp_dns.php'); 
                    include_once('ftp_upload_form.php');//DNS MERGING                        
                } 
               ?>
            
            <div class="myPlanBtn">
                <!--<a class="submit-btn" href="javascript:void(0);" onclick="return check_validation('<?php //echo @$_SESSION['quoteform']['CORPORATENAME']?1:0;?>');">Submit</a>-->
                <a class="submit-btn" href="javascript:void(0);" onclick="return check_validation('<?php echo @$_SESSION['quoteform']['CORPORATENAME']?1:0;?>');">Submit</a>
                <?php  //echo $roleButton;
                    // $roleButton need to be remove from here because its giving the dynamic button which is creating problem in validation check .Now a html hardcoded function has been 
                     // added for form submit so that one can check the file upload validation also
                ?>
                <div class="clearfix"></div>                    
            </div>                
              <input type="hidden" id="totalcount" value="">
        </div>
               
    </form>
    <div class="cl"></div></section>
<script type="text/javascript">

    $(document).ready(function () {        
        $("#SELECTINTERMEDIARY").click(function () {
            if($("#SELECTINTERMEDIARY").val()=='Direct')
			$( "#MANDATETYPE").parent().parent().parent().css( "display", "none" );
			else
          $( "#MANDATETYPE").parent().parent().parent().css( "display", "block" );
        });

    });
</script>
<script type="text/javascript">

    $(document).ready(function () {
//open popup
        $("#pop").click(function () {
            $("#overlay_form").fadeIn(1000);
            positionPopup();
        });

//close popup
        $("#close11").click(function () {
            $("#overlay_form").fadeOut(500);
        });
    });

//position the popup at the center of the page
    function positionPopup() {
        if (!$("#overlay_form").is(':visible')) {
            return;
        }
        $("#overlay_form").css({
            left: ($(window).width() - $('#overlay_form').width()) / 2,
            top: ($(window).width() - $('#overlay_form').width()) / 7,
            position: 'absolute'
        });
    }

//maintain the popup at center of the page when browser resized
    $(window).bind('resize', positionPopup);

</script>

<!--footer start here-->
<div id="pop"></div>
<div id="overlay_form" style="display: none;">		
    <div id="comp_data"></div>
    <a href="javascript:void(0);" id="close11" class="greenTxt">Close</a>
</div>

<?php include_once("inc/ft.php"); ?>

<style type='text/css'>
    #ui-datepicker-div {
        width: 230px!important;
        padding: 5px;
        display: none;
    }

    div .ui-datepicker-new-row  {
        padding: 10px;
    }


    table.ui-datepicker {
        width: 200px;
        border-collapse: collapse;
        margin: 10px 0 0 0;
    }
    .gradedSI,.flatSI{
        display: none;
    }
</style>    
    
<!-- Added new validation - 25/02/2016 17:05 @SHAKTIRANA -->
<script type="text/javascript">
  
  var SILIMIT = <?php echo @$SILIMIT ;?>;
  var HIGHESTSILIMIT = <?php echo $HIGHESTSILIMIT ;?>;
  $(document).ready(function(){

            //added custom validation.
            /*
            $.validator.addMethod("notStartWithNumeric", function(value, element) {                
                    return this.optional(element) || (value.substr(0, 1).match(/[A-Za-z]/) && /^[a-zA-Z0-9](?:[a-zA-Z0-9&-_. ]*[a-zA-Z0-9&-_. ])?$/.test(value));
                }, "Corporate Name can not start with any number/special character.");   
            */    
            $.validator.addMethod("notStartWithNumeric", function(value, element) {
                return this.optional(element) || (value.substr(0, 1).match(/[A-Za-z]/) && /^[a-zA-Z0-9](?:[a-zA-Z0-9&-_. ]*[a-zA-Z0-9&-_. ])?$/.test(value));
            }, function(value, element){ 
                val = $('#'+element.id).val();
                if(val.substr(0, 1).match(/[A-Za-z]/) == null)
                {
                    return "Corporate Name cannot starts with number or any special character.";                                                
                }
                else
                {
                    return "Corporate Name cannot contain any special character.";
                }
            });       
                        
            //No. of lives min criteria. 15/03/2016 16:34 @SHAKTIRANA
            //GHI
            $.validator.addMethod("noOfLivesMinCriteriaGHI", function(value, element) {  
                var minLives = <?php echo @$_SESSION['minLives'];?>;
//                var maxLives = <?php // echo @$_SESSION['maxLives'];?>;
//                return this.optional(element) || ((value >= minLives) && (value <= maxLives));
                return this.optional(element) || (value >= minLives);
                },  
            function()
            {
                var minLives = <?php echo @$_SESSION['minLives'];?>;
//                var maxLives = <?php // echo @$_SESSION['maxLives'];?>;
                return "No. of Lives must be greater than "+ minLives+".";
            }); 
            //GPA
            $.validator.addMethod("noOfLivesMinCriteriaGPA", function(value, element) {  
                var minLives = <?php echo @$_SESSION['gpaMinLives'];?>;
//                var maxLives = <?php // echo @$_SESSION['gpaMaxLives'];?>;
//                return this.optional(element) || ((value >= minLives) && (value <= maxLives));
                  return this.optional(element) || (value >= minLives);
                },  
            function()
            {
                var minLives = <?php echo @$_SESSION['gpaMinLives'];?>;
//                var maxLives = <?php // echo @$_SESSION['gpaMaxLives'];?>;
                return "No. of Lives must be greater than "+ minLives+".";
            });
            //GTI
            $.validator.addMethod("noOfLivesMinCriteriaGTI", function(value, element) {  
                var minLives = 14;
                return this.optional(element) || (value > minLives);
                },  
            function()
            {
                var minLives = 14;
                return "No. of Lives must be greater than "+minLives+".";
            }); 
            //End - No. of lives min criteria.
           
        //onlyFloat. for price.    
        $.validator.addMethod("priceValidation", function(value, element) {
                return this.optional(element) || /^\d+(?:\.\d{1,2})?$/.test(value);
            }, "Not valid Amount.");     

        jQuery.validator.addMethod("email", function (value, element) {
            return this.optional(element) || (/^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test(value) 
                    && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value));
        }, 'Please enter valid email address.');
          
             
      //added custom validation.
      $("#samapping").validate({
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
            "NOOFEMPLOYEE": {
                required: true,
                //noOfLivesMinCriteria: true,                
                
                noOfLivesMinCriteriaGHI: {
                    depends: function() {
                        return $('input[name=PRODUCT]:checked').val() == 'GHI';
                    }
                },
                noOfLivesMinCriteriaGPA: {
                    depends: function() {
                        return $('input[name=PRODUCT]:checked').val() == 'GPA';
                    }
                },
                noOfLivesMinCriteriaGTI: {
                    depends: function() {
                        return $('input[name=PRODUCT]:checked').val() == 'GTI';
                    }
                }
            },
            "EMPLOYEENO": {
                required: {
                    depends: function() {
                        return $('input[name=PRODUCT]:checked').val() == 'GHI';		
                    }
                },
                number: true                
            },
            "PARENTSNO": {
                required: {
                    depends: function() {
                        var familyDef  = $('#FAMILYDEFINITION').val();        
                        var checkRatio = familyDef.split('_');
                        return $('#EMPLOYEENO').val() != '' && checkRatio[1] == 'YES';			
                    }
                },
                number: true
            },
            "INDUSTRYID": {
                required: true
            },
            "LOCATIONID": {
                required: true
            },
            "FAMILYDEFINITION": {
                required: true
            },
            "SELECTINTERMEDIARY": {
                required: true
            },
            "RMEMAIL": {
                required: true,
                email: true
            },
            "MANDATETYPE": {
                required: {
                    depends: function() {
                        return $('#SELECTINTERMEDIARY').val() != 'Direct';			
                    }
                }
            },
            "POLICYSTRUCTURE": {
                required: true
            },
            "POLICYSTARTDATE": {
                required: {
                    depends: function() {
                        return $('input[name=POLICYTYPE]:checked').val() == 'Renewal_1.05';			
                    }
                }
            },
            "EXPIRINGINSURER": {
                required: {
                    depends: function() {
                        return $('input[name=POLICYTYPE]:checked').val() == 'Renewal_1.05';			
                    }
                }
            },
            "PREMIUMAMOUNT": {
                required: {
                    depends: function() {
                        return $('input[name=POLICYTYPE]:checked').val() == 'Renewal_1.05';			
                    }
                },
            priceValidation:true
            },
            "CLAIMAMOUNT": {
                required: {
                    depends: function() {                        
                        return $('input[name=POLICYTYPE]:checked').val() == 'Renewal_1.05';			
                    }
                },
            priceValidation:true
            },
            "CLAIMDATE" : {
                required: {
                    depends: function() {
                        return $('input[name=POLICYTYPE]:checked').val() == 'Renewal_1.05';			
                    }
                }			
            },
            "FLATSI": {
                required: {
                    depends: function() {                        
                        return $('input[name=SITYPE]:checked').val() == 'Flat'&& $('input[name=PRODUCT]:checked').val() == 'GPA';			
                    }
                },
                priceValidation: true
                
            },
            "TOTALSI": {
                required: {
                    depends: function() {                        
                        return $('input[name=SITYPE]:checked').val() == 'Graded'&& $('input[name=PRODUCT]:checked').val() == 'GPA';			
                    }
                },
                priceValidation: true                 
            },
            "TOPFIFTYSI": {
                required: {
                    depends: function() {                        
                        return $('input[name=SITYPE]:checked').val() == 'Graded'&& $('input[name=PRODUCT]:checked').val() == 'GPA';			
                    }
                },
                priceValidation: true
            },
            "HIGHESTSI": {
                required: {
                    depends: function() {                        
                        return $('input[name=SITYPE]:checked').val() == 'Graded'&& $('input[name=PRODUCT]:checked').val() == 'GPA';			
                    }
                },
                priceValidation: true
            },
            "GRADEBASISID": {
                required: {
                    depends: function() {                        
                        return $('input[name=SITYPE]:checked').val() == 'Graded'&& $('input[name=PRODUCT]:checked').val() == 'GPA';			
                    }
                },
            }
        },
        messages: {
            "CORPORATENAME": {
                required: 'Please enter Corporate Name'
            },
            "NOOFEMPLOYEE": {
                required: 'Please enter No. of Lives'
            },
            "EMPLOYEENO": {
                required: 'Please enter No. of Employees'
            },
            "PARENTSNO": {
                required: 'Please enter No. of Parents'
            },
            "INDUSTRYID": {
                required: 'Please select Industry Type'
            },
            "LOCATIONID": {
                required: 'Please select location'
            },
            "FAMILYDEFINITION": {
                required: 'Please select family definition'
            },
            "SELECTINTERMEDIARY": {
                required: 'Please select Intermediary(Broker/Agent/Direct) Name'
            },
            "RMEMAIL": {
                required: 'Please enter RM email',
                email: 'Please enter valid email'
            },
            "MANDATETYPE": {
                required: 'Please select Mandate Type'
            },
            "POLICYSTRUCTURE": {
                required: 'Please select Policy Structure'
            },
            "POLICYSTARTDATE": {
                required: 'Please enter policy start date'
            },
            "EXPIRINGINSURER": {
                required: 'Please enter Expiring Insurer'
            },
            "PREMIUMAMOUNT": {
                required: 'Please enter Expiring premium amount'
            },
            "CLAIMAMOUNT": {
                required: 'Please enter claim amount'
            },
            "CLAIMDATE": {
                required: 'Please enter claim date'
            },
             "FLATSI": {
                required: 'Please enter individual sum-insured'
                //SiLimitCriteria: 'Please enter individual sum-insured lower than ' + SILIMIT
            },
            "TOTALSI": {
                required: 'Please enter total sum-insured'
            },
            "TOPFIFTYSI": {
                required: 'Please enter top fifty sum-insured'
            },
            "HIGHESTSI": {
                required: 'Please enter highest sum-insured'
            },
            "GRADEBASISID": {
                required: 'Please select grade basis.'
            }
        },
        errorElement : 'div',
        //errorLabelContainer: '.errorTxtCustom'

    });
 });
 

</script>    
<!-- Added new validation -->
    
<!-- Added new validation - 09/03/2016 16:14 @SHAKTIRANA -->
<script type="text/javascript">
    function showParents()
    {        
        var familyDef  = $('#FAMILYDEFINITION').val();        
        var checkRatio = familyDef.split('_');
        if(checkRatio[1] == 'YES')
        {
            $('.parentsno').show();
        }
        else
        {
            $('.parentsno').hide();
        }
    }
</script>
<!-- Added new validation -->

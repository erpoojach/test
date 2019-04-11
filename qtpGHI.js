
function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        //Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
function isEmpty(s)
{
	var re = /\s/g; //Match any white space including space, tab, form-feed, etc. 
	var s = s.replace(re, "");
	if (s.length == 0) 
	{
		return true;
	}
	else 
	{
		return false;
	}
} 
$(document).ready(function() {
	/*
	$("#qbox").show();
	$("#slab2").show();
	$("#slab3").show();
	$("#slab4").show();
	*/
	$("#normalmaternitytypeid").hide();	 
	$("#maternitytypeid").hide();	 
	$("#newbornbabyamt").hide();	 
	$("#CORPORATEFLOATERTYPE1").hide();	
	$("#covertypeid").hide(); 
	$("#prepostnatalid").hide(); 
	$(".slab1").livequery('keyup',updateslab1);
	$(".slab2").livequery('keyup',updateslab2);
	$(".slab3").livequery('keyup',updateslab3);
	$(".slab4").livequery('keyup',updateslab4);
	$(".slab5").livequery('keyup',updateslab5);
	$(".slab6").livequery('keyup',updateslab6);
	$("#FAMILYDEFINITION").livequery('change',chkFamilyType);	
	$("#PARENTSNO").attr("disabled", "disabled"); 	
	$("#POLICYSTARTDATE").datepicker({ 
	minDate: -0,
	yearRange: '2000:2025',
	dateFormat: "yy-mm-dd"
	});
	$("#CLAIMDATE").datepicker({ 
	yearRange: '2000:2025',
	dateFormat: "yy-mm-dd"
	});
});
function chkFamilyType(){
	var familyValue		 	= 	$("#FAMILYDEFINITION").val();
	var familyArr			=   familyValue.split("_");
	var familyChkRatio	 	=	familyArr[1];
	var familystruc		 	=	familyArr[2];	
	if(familyValue!=''){
	var familystrucval		=	familystruc.toLowerCase();
	if(familystrucval=='self only') {		
		$("#babycovered").hide();
		$("#newbornbabyamt").hide();
	}	else	{
		$("#babycovered").show();
		var NEWBABY1 = $('input[name=NEWBABY1]:checked', '#samapping').val();
		if(NEWBABY1=='no') {
		$("#newbornbabyamt").hide();
		}	else {
		$("#newbornbabyamt").show();
		}
	}
	}	else {
		$("#babycovered").show();
		var NEWBABY1 = $('input[name=NEWBABY1]:checked', '#samapping').val();
		if(NEWBABY1=='no') {
		$("#newbornbabyamt").hide();
		}	else {
		$("#newbornbabyamt").show();
		}
	}
	if(familyChkRatio=='YES'){
	$("#PARENTSNO").removeAttr("disabled");
	} else {
	$("#PARENTSNO").attr("disabled", "disabled"); 
	}
}
function updateslab1(){
			var prodSubTotal = 0;
			$(".slab1").each(function(){			
				var valString = $(this).val() || 0;
				if(isInteger(valString)){
				prodSubTotal += parseInt(valString);//alert(prodSubTotal);
				} else { 
				var getId		= $(this).attr('id');				
				alert("Please enter only numbers."); 
				$("#"+getId).val('0');
				}
			});
			$("#slab1total").html(prodSubTotal);
}
function updateslab2(){
			var prodSubTotal = 0;
			$(".slab2").each(function(){
				var valString = $(this).val() || 0;//alert(valString);
				if(isInteger(valString)){
				prodSubTotal += parseInt(valString);//alert(prodSubTotal);
				} else { 
				var getId		= $(this).attr('id');				
				alert("Please enter only numbers."); 
				$("#"+getId).val('0');
				}
			});
			$("#slab2total").html(prodSubTotal);
}
function updateslab3(){
			var prodSubTotal = 0;
			$(".slab3").each(function(){
				var valString = $(this).val() || 0;//alert(valString);
				if(isInteger(valString)){
				prodSubTotal += parseInt(valString);//alert(prodSubTotal);
				} else { 
				var getId		= $(this).attr('id');				
				alert("Please enter only numbers."); 
				$("#"+getId).val('0');
				}
			});
			$("#slab3total").html(prodSubTotal);
}
function updateslab4(){
			var prodSubTotal = 0;
			$(".slab4").each(function(){
				var valString = $(this).val() || 0;//alert(valString);
				if(isInteger(valString)){
				prodSubTotal += parseInt(valString);//alert(prodSubTotal);
				} else { 
				var getId		= $(this).attr('id');				
				alert("Please enter only numbers."); 
				$("#"+getId).val('0');
				}
			});
			$("#slab4total").html(prodSubTotal);
}
function updateslab5(){
			var prodSubTotal = 0;
			$(".slab5").each(function(){
				var valString = $(this).val() || 0;//alert(valString);
				if(isInteger(valString)){
				prodSubTotal += parseInt(valString);//alert(prodSubTotal);
				} else { 
				var getId		= $(this).attr('id');				
				alert("Please enter only numbers."); 
				$("#"+getId).val('0');
				}
			});
			$("#slab5total").html(prodSubTotal);
}
function updateslab6(){
			var prodSubTotal = 0;
			$(".slab6").each(function(){
				var valString = $(this).val() || 0;//alert(valString);
				if(isInteger(valString)){
				prodSubTotal += parseInt(valString);//alert(prodSubTotal);
				} else { 
				var getId		= $(this).attr('id');				
				alert("Please enter only numbers."); 
				$("#"+getId).val('0');
				}
			});
			$("#slab6total").html(prodSubTotal);
}
function policyType(type){
	if(type=="Renewal")	{	$(".policyRenewal").show();	}
	if(type=="Fresh")	{	$(".policyRenewal").hide();	}
}
function showHide(type)
{
	if(type=="showquote")
	{			
		$("#qbox").show();
		$("#createq").hide();
		$("#createqhide").show();
	}	
	if(type=="hidequote")
	{			
		$("#qbox").hide();
		$("#createq").show();
		$("#createqhide").hide();
	}
	if(type=="addslab")
	{		
		var slabno = $("#slabNo").val();
		if(slabno<7){
		var incrementSlab = ++slabno;	
		$("#slabNo").val(incrementSlab);	
		$("#slab"+incrementSlab).show();
		if(slabno=='6') { $("#slab").hide(); } else { 	}
		} 
	}	
}
function normalMaternity(slabno,val){
	if(val=='yes') { 	
	$("#normalmaternitytypeid").show();	 
	} else {
	$("#normalmaternitytypeid").hide();	 
	}
}
function maternity(slabno,val){
	if(val=='yes') { 	
	$("#maternitytypeid").show();	 
	} else {
	$("#maternitytypeid").hide();	 
	}
}
function corporateFloater(slabno,val){
	if(val=='yes') { 	
	$("#CORPORATEFLOATERTYPE"+slabno).show();	 
	} else {
	$("#CORPORATEFLOATERTYPE"+slabno).hide();	
	}
}
function bornBaby(slabno,val){
	if(val=='yes') { 	
	$("#newbornbabyamt").show();	 
	} else {
	$("#newbornbabyamt").hide();	 
	}
}
function covertype(slabno,val){
	if(val=='yes') { 	
	$("#covertypeid").show();	 
	} else {
	$("#covertypeid").hide();	 
	}
}
function prepostnatal(slabno,val){
	if(val=='yes') { 	
	$("#prepostnatalid").show();	 
	} else {
	$("#prepostnatalid").hide();	 
	}
}
function waitingPeriod(type){
	if(type=="waveoff"){	$("#WAITINGPERIODTYPE").show();	} else  {	$("#WAITINGPERIODTYPE").hide();	}
}
function pedexclusion(type){
	if(type=="waveoff"){	$("#PEDEXCLUSIONTYPE").show();	} else  {	$("#PEDEXCLUSIONTYPE").hide();	}
}
function validate(){

	var CORPORATENAME = $("#CORPORATENAME").val();
	if(CORPORATENAME==''){	
	alert('Please enter corporate name'); 
	$("#CORPORATENAME").focus();
	return false;	
	}
	var INDUSTRYID = $("#INDUSTRYID").val();
	if(INDUSTRYID==''){	
	alert('Please select industry'); 
	$("#INDUSTRYID").focus();
	return false;	
	}
	var LOCATIONID = $("#LOCATIONID").val();
	if(LOCATIONID==''){	
	alert('Please select location'); 
	$("#LOCATIONID").focus();
	return false;	
	}
	var POLICYSTARTDATE = $("#POLICYSTARTDATE").val();
	if(POLICYSTARTDATE==''){	
	alert('Please enter policy start date'); 
	$("#POLICYSTARTDATE").focus();
	return false;	
	}
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
	var POLICYTYPE = $('input[name=POLICYTYPE]:checked', '#samapping').val();
	var policyTypeArr		=   POLICYTYPE.split("_");
	var POLICYTYPE 			=	policyTypeArr[0];
	if(POLICYTYPE==''){	
	alert('Please select a policy type'); 
	$("#POLICYTYPE").focus();
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
	var NOOFEMPLOYEE = $("#NOOFEMPLOYEE").val();
	if(NOOFEMPLOYEE==''){	
	alert('Please enter number of employees'); 
	$("#NOOFEMPLOYEE").focus();
	return false;	
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
function blocking(divId){	
	$('#'+divId).block({  
    message: '<img src="img/loading.gif">',  
    css: {  border: 'none' ,backgroundColor: '', opacity: '.5' }  
   }); 
}
function unblocking(divId){
	$('#'+divId).unblock();
}
function checkContributory(){
	var CONTRIBUTORYTYPE = $("#CONTRIBUTORYTYPE").val();
	if(CONTRIBUTORYTYPE=='Contributory'){
	alert("Please route the case to U/W team.");
	document.location="quote_list.php"	
	}
}
function SITYPEFUNC(serialno,typeval){
	if(typeval=='Graded') { 
		$("#sityperesult"+serialno).show();
		$("#gradebasisresult"+serialno).show();
	}	else {
		$("#sityperesult"+serialno).hide();
		$("#gradebasisresult"+serialno).hide();
	}	
}
function showSI(){	
	var OPDCOVERAGEID = $("#OPDCOVERAGEID").val();
	var OPDCOVERAGEID = OPDCOVERAGEID.split("_");
	var OPDCOVSHOWSI  = OPDCOVERAGEID[2];
	if(OPDCOVSHOWSI=='no') {
	 	$("#showopdsi").hide();
	}	else	{
		$("#showopdsi").show();
	}
}
function showIntermediary(){	
	var SELECTINTERMEDIARY = $("#SELECTINTERMEDIARY").val();
	if(SELECTINTERMEDIARY=='other') {
		$("#otherintermediary").show();	 	
	}	else	{
		$("#otherintermediary").hide();
	}
}
function hlthchkupfilefunc(){
	$("#hlthchkupfileresult").html('<img src="img/loading.gif" />');
	var HEALTHCHECKUPID = $("#HEALTHCHECKUPID").val();
	var HEALTHCHECKUPID = HEALTHCHECKUPID.split("|");
	var HEALTHCHECKUPFILE  = HEALTHCHECKUPID[3];
	//alert(HEALTHCHECKUPFILE);
	if(HEALTHCHECKUPFILE!='') {		
		var URL = '<a href="file_download.php?fileName='+HEALTHCHECKUPFILE+'" target="_blank" style="cursor:pointer;">Download</a>';
		$("#hlthchkupfileresult").html(URL);
	}	else {
	$("#hlthchkupfileresult").html(' ');	
	}
}
function morecoverage(){
	$(".morecoveragelist").show();
}
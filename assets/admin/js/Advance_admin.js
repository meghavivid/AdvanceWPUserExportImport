jQuery(document).ready(function(){
    if(jQuery("#AdvacneWPUserExport").length > 0)
    {
        jQuery("#AdvanceUsertabs").tabs();
        jQuery("#exportLimitRegisterStartDate").datepicker({ changeYear: true , changeMonth: true });
        jQuery("#exportLimitRegisterEndDate").datepicker({ changeYear: true , changeMonth: true });
    }
});
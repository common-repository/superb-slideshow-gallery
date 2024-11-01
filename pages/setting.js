function ssg_submit()
{
	if(document.ssg_form.ssg_path.value=="")
	{
		alert(ssg_adminscripts.ssg_path);
		document.ssg_form.ssg_path.focus();
		return false;
	}
	else if(document.ssg_form.ssg_link.value=="")
	{
		alert(ssg_adminscripts.ssg_link);
		document.ssg_form.ssg_link.focus();
		return false;
	}
	else if(document.ssg_form.ssg_target.value=="")
	{
		alert(ssg_adminscripts.ssg_target);
		document.ssg_form.ssg_target.focus();
		return false;
	}
	//else if(document.ssg_form.ssg_title.value=="")
//	{
//		alert("Please enter the image title.");
//		document.ssg_form.ssg_title.focus();
//		return false;
//	}
	else if(document.ssg_form.ssg_type.value=="")
	{
		alert(ssg_adminscripts.ssg_type);
		document.ssg_form.ssg_type.focus();
		return false;
	}
	else if(document.ssg_form.ssg_status.value=="")
	{
		alert(ssg_adminscripts.ssg_status);
		document.ssg_form.ssg_status.focus();
		return false;
	}
	else if(document.ssg_form.ssg_order.value=="")
	{
		alert(ssg_adminscripts.ssg_order);
		document.ssg_form.ssg_order.focus();
		return false;
	}
	else if(isNaN(document.ssg_form.ssg_order.value))
	{
		alert(ssg_adminscripts.ssg_order);
		document.ssg_form.ssg_order.focus();
		return false;
	}
}

function ssg_delete(id)
{
	if(confirm(ssg_adminscripts.ssg_delete))
	{
		document.frm_ssg_display.action="options-general.php?page=superb-slideshow-gallery&ac=del&did="+id;
		document.frm_ssg_display.submit();
	}
}	

function ssg_redirect()
{
	window.location = "options-general.php?page=superb-slideshow-gallery";
}

function ssg_help()
{
	window.open("http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/");
}
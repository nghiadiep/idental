function a01(){
	var menu01 = document.form01.REQUEST_DAY_KIND1.selectedIndex;
	if(menu01 == ''){
		document.form01.REQUEST_DAY_KIND2.disabled = true;
		document.form01.REQUEST_TIMEZONE2.disabled = true;
	}else{
		document.form01.REQUEST_DAY_KIND2.disabled = false;
		document.form01.REQUEST_TIMEZONE2.disabled = false;
	}
}
function a02(){
	var menu01 = document.form01.REQUEST_TIMEZONE1.selectedIndex;
	if(menu01 == ''){
		document.form01.REQUEST_DAY_KIND2.disabled = true;
		document.form01.REQUEST_TIMEZONE2.disabled = true;
	}else{
		document.form01.REQUEST_DAY_KIND2.disabled = false;
		document.form01.REQUEST_TIMEZONE2.disabled = false;
	}
}
function b01(){
	var menu02 = document.form01.REQUEST_DAY_KIND2.selectedIndex;
	if(menu02 == ''){
		document.form01.REQUEST_DAY_KIND3.disabled = true;
		document.form01.REQUEST_TIMEZONE3.disabled = true;
	}else{
		document.form01.REQUEST_DAY_KIND3.disabled = false;
		document.form01.REQUEST_TIMEZONE3.disabled = false;
	}
}
function b02(){
	var menu02 = document.form01.REQUEST_TIMEZONE2.selectedIndex;
	if(menu02 == ''){
		document.form01.REQUEST_DAY_KIND3.disabled = true;
		document.form01.REQUEST_TIMEZONE3.disabled = true;
	}else{
		document.form01.REQUEST_DAY_KIND3.disabled = false;
		document.form01.REQUEST_TIMEZONE3.disabled = false;
	}
}

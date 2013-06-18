function DrawImage(ImgD,FitWidth,FitHeight)
{
    var image=new Image();
    image.src=ImgD.src;
    if(image.width>0 && image.height>0)
	{
		if(image.width/image.height>= FitWidth/FitHeight)
        {
        	if(image.width>FitWidth)
            {
            	ImgD.width=FitWidth;
                ImgD.height=(image.height*FitWidth)/image.width;
			}
            else
            {
				ImgD.width=image.width; 
				ImgD.height=image.height;
			}
		}
         else
         {
            if(image.height>FitHeight)
            {
                ImgD.height=FitHeight;
                ImgD.width=(image.width*FitHeight)/image.height;
            }
            else
            {
                ImgD.width=image.width; 
                ImgD.height=image.height;
			} 
		}
	}
 }
var tabToggleRolling = new Array();
function tabToggle(obj,tab,img,tnum,roll) {
	if(tab=='random'){
		var rnum = Math.floor(Math.random() * tnum) + 1;
		tab = rnum;
	}
	if(tab=='rolling'){
		tabToggleRolling[roll] = (!tabToggleRolling[roll])?1:tabToggleRolling[roll]+1;
		if(tabToggleRolling[roll]>tnum) tabToggleRolling[roll] = 1;
		tab = tabToggleRolling[roll];
	}
	if(tnum=='rolling'){
		tabToggleRolling[roll] = tab;
		tab = tabToggleRolling[roll];
	}
	var tab_list = document.getElementById(obj).getElementsByTagName('a');
	for(i=1;i<=tab_list.length;i++){
		(tab==i)?tab_list[i-1].className='on':tab_list[i-1].className='';
		document.getElementById(obj+'_'+i).style.display = (tab==i)?'':'none';
		if(img){
			var imgEl=tab_list[i-1].getElementsByTagName("img").item(0);
			imgEl.src = (tab==i)? imgEl.src.replace("off.gif", "on.gif"):imgEl.src.replace("on.gif", "off.gif");
		}
	}
}
function changeBrand4Header()
{
	var brandSelObj = document.getElementById('brandSelOpt');
	var id = '10024440';
	for(var i = 0; i < brandSelObj.options.length; i++)
	{
        if(brandSelObj.options[i].selected)
        {
			id = brandSelObj.options[i].value;
			break;
        }
    }
	var url = "http://www.feexoo.com/goods_list_brand_"+id+".html";
    if(url != '')
    	top.location.href = url;
}
function gotoUrl(id1, id2, type, formId)
{
	var action = "";
	if(type == 'detail') {
		action = "http://www.feexoo.com/goods_detail_id_"+id1+".html";
	} else if(type == 'brand') {
		action = "http://www.feexoo.com/goods_list_brand_"+id1+".html";
	} else if(type == 'brandseries') {
		action = "http://www.feexoo.com/goods_list_brand_"+id1+"_bsid_"+id2+".html";
	} else if(type == 'brandcategory') {
		action = "http://www.feexoo.com/brand_glist_id_"+id1+"_c_"+id2+".html";
	} else if(type == 'category') {
		action = "http://www.feexoo.com/goods_list_category_"+id1+".html";
	} else if(type == 'commentlist') {
		action = "http://www.feexoo.com/goods_commentlist_goodsid_"+id1+".html";
	} else if(type == 'consultlist') {
		action = "http://www.feexoo.com/goods_consultlist_goodsid_"+id1+".html";
	}
	if(action != '')
	{
		var formObj = document.getElementById(formId);
		formObj.action = action;
		formObj.target = "_blank";
		formObj.submit();
	}
}




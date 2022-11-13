
function mouseOverItem(oMenuItem,sDescrip) 
{
	window.status=sDescrip;
	oMenuItem.className="menuItemMouseOver";
}

function mouseOutItem(oMenuItem) 
{
	window.status="";
	oMenuItem.className="menuItemMouseOut";
}

function clickItem(sPage) 
{
	window.open(sPage,"_self");
}

function clickItemAnotherBrowser(sPage) 
{
	window.open(sPage,"_blank");
}


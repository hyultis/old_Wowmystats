
var page = 0;
var myspe = 0;
var img = new Array(
'img/tip-bg2.png',
'img/db_white.png',
'img/db_black.png',
'img/lf.png',
'img/rf.png',
'img/db_grey.png',
'img/db_marron.png',
'img/db_yellow.png',
'img/db_orange.png',
'img/db_red.png',
'img/db_pink.png',
'img/db_violet.png',
'img/db_blue.png',
'img/db_cyan.png',
'img/db_lightgreen.png',
'img/db_green.png',
'img/db_spe2.png'
);
var color = new Array(
'247,159,87',
'255,255,255',
'0,0,0',
'125,125,125',
'70,33,0',
'255,255,0',
'255,125,0',
'255,0,0',
'255,0,255',
'125,0,255',
'0,0,255',
'0,255,255',
'0,255,0',
'0,125,0'
);


function main(varpage)
{
	page = varpage;
	Statme_init(img,color);
	//Statme('historique',statme_M_historique,page,0); 
	//Statme('stat',statme_M_stat,page,0);
	
	setTimeout("reloadstat("+this["page"]+")",200);
}

function reloadstat(varpage)
{
	// change
	if(myspe==1)
	{
		tempspe1 = $('#spe table.ibutton');
		tempspe2 = $('#spe table.button');
		
		tempspe1.removeClass('ibutton');
		tempspe1.addClass('button');
		tempspe2.removeClass('button');
		tempspe2.addClass('ibutton');
	}

	page = varpage;
	Statme('historique',statme_M_historique,page,0); 
	Statme('stat',statme_M_stat,page,myspe); 
}

function changespe(temp)
{
	if(myspe!=temp)
	{
		myspe = temp;
		pageajax(page);
	}
}

function changepage(page)
{
	myspe=0;
	pageajax(page);
}

function pageajax(page)
{
	Statme_clear();
	$.ajax({
		url: "page.php?p="+page,
		global: false,
		type: "GET",
		cache: false,
		dataType: "text",
		page: page,
		success: function(data)
		{
			$("#body").html(data);
			setTimeout("reloadstat("+this["page"]+")",200);
			$('#menu ul > li').removeClass('activated');
			$('#menu ul > li:eq('+this["page"]+')').addClass('activated');
		},
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
			$("#body").html("<h1>Erreur 404 : page non trouv&eacute;</h1>");
		}
	});
}

function changepage(page)
{
	$("#body").html('<img src="img/loader.gif" alt="loading..." />');
	pageajax(page);
}

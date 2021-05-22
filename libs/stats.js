// modifiable var
var statme_refreshtime = 100;

// system Cvar
var statme_M_historique = 10;
var statme_M_stat = 15;

// system var
var statme_mousex = new Array();
var statme_mousey = new Array();
var statme_mouseclick = new Array();
var statme_ctx = new Array();
var statme_height = new Array();
var statme_width = new Array();
var statme_posx = new Array();
var statme_posy = new Array();
var statme_img = new Array();
var statme_spos = new Array();
var statme_mode = new Array(); // 0=rien, 0>mois<13, 20>semaine<120, 1900>année
var statme_modechange = new Array();
var statme_data = new Array();
var statme_drawdata = new Array();
var statme_icangoright = new Array();
var statme_selecteddata = new Array();
var statme_type = new Array();
var statme_loaded = new Array();
var statme_ready = new Array();
var statme_text = new Array();
var statme_error = new Array();
var statme_color = new Array();
var statme_busy = new Array();
var statme_nbctx = 0;
var statme_intervallaunch = 0;

function create_function (args, code) { 
	try {
		return Function.apply(null, args.split(',').concat(code));
	}
	catch (e) {
		return false;     
	}
}

function Statme_init(img,color)
{
	for(var t=0;t<100;t++)
		statme_img[t]=new Image();
				
	statme_img[0].src = img[0];
	statme_img[1].src = img[1];
	statme_img[2].src = img[2];
	statme_img[3].src = img[3];
	statme_img[4].src = img[4];
	statme_img[22].src = img[5];
	statme_img[23].src = img[6];
	statme_img[24].src = img[7];
	statme_img[25].src = img[8];
	statme_img[26].src = img[9];
	statme_img[27].src = img[10];
	statme_img[28].src = img[11];
	statme_img[29].src = img[12];
	statme_img[30].src = img[13];
	statme_img[31].src = img[14];
	statme_img[32].src = img[15];
	statme_img[33].src = img[16];
	
	statme_color = color;
}

function Statme(idelem,type,nbperso,changespe)
{
	canvas = document.getElementById(idelem);//$('#historique')
	if(canvas == null)
		return false;
	
	if (canvas.getContext && statme_ctx[statme_nbctx] == null)
	{
		statme_ctx[statme_nbctx] = canvas.getContext('2d');
		statme_width[statme_nbctx] = $('#'+idelem).width();
		statme_height[statme_nbctx] = $('#'+idelem).height();
		statme_posx[statme_nbctx] = $('#'+idelem).offset().left;
		statme_posy[statme_nbctx] = $('#'+idelem).offset().top;
		statme_mousex[statme_nbctx] = 0;
		statme_mousey[statme_nbctx] = 0;
		statme_loaded[statme_nbctx] = 0;
		statme_error[statme_nbctx] = 0;
		statme_spos[statme_nbctx] = 0;
		statme_data[statme_nbctx] = new Array();
		statme_drawdata[statme_nbctx] = new Array();
		statme_text[statme_nbctx] = new Array();
		statme_selecteddata[statme_nbctx] = 0;
		statme_icangoright[statme_nbctx] = false;
		statme_modechange[statme_nbctx] = 1;
		statme_mouseclick[statme_nbctx] = 0;
		statme_busy[statme_nbctx] = 0;
		statme_mode[statme_nbctx] = 0; // 0=day ,1=week , 2=month, 3=year
		statme_type[statme_nbctx] = type;		
		
		functionm = create_function("event","statme_mousex["+statme_nbctx+"] = event.pageX;statme_mousey["+statme_nbctx+"] = event.pageY;statme_draw("+statme_nbctx+",true)");
		$('#'+idelem).mousemove(functionm);
		functionc = create_function("event","if(event.button==0){statme_mouseclick["+statme_nbctx+"]=1;}else{statme_mouseclick["+statme_nbctx+"]=0;}statme_draw("+statme_nbctx+",true);");
		$('#'+idelem).mouseup(functionc);
		statme_nbctx = statme_nbctx + 1;
		
		$.ajax({
			url: "s.php?p="+nbperso+"&m="+type+"&s="+changespe,
			global: false,
			type: "GET",
			cache: false,
			dataType: "text",
			nb: statme_nbctx-1,
			success: function(data)
			{
				if(data=='error')
				{
					statme_error[this['nb']]=1;
				}
				else
				{
					temparray = data.split(';');
					statme_loaded[this['nb']] = 1;
				
					for(t=0;t<temparray.length;t++)
					{
						temparray[t] = temparray[t].split(',');
						statme_data[this['nb']][t] = new Array();
						for(x=0;x<temparray[t].length;x++)
						{
							if(isNaN(temparray[t][x]))
								statme_data[this['nb']][t][x] = temparray[t][x];
							else
								statme_data[this['nb']][t][x] = parseInt(temparray[t][x]);
						}
					}
					statme_draw(this['nb']);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				statme_error[this['nb']]=1;
			}
		});
		
		if(statme_intervallaunch == 0)
		{
			statme_draw(statme_nbctx-1,true);
			//statme_intervallaunch = setInterval(statme_draw,statme_refreshtime);
		}
		
		return true;
	}
	
	return false;
}

function Statme_clear()
{
	//clearInterval(statme_intervallaunch);
	statme_mousex = new Array();
	statme_mousey = new Array();
	statme_mouseclick = new Array();
	statme_ctx = new Array();
	statme_height = new Array();
	statme_width = new Array();
	statme_posx = new Array();
	statme_posy = new Array();
	statme_mode = new Array(); // 0=rien, 0>mois<13, 20>semaine<120, 1900>année
	statme_modechange = new Array();
	statme_data = new Array();
	statme_spos = new Array();
	statme_icangoright = new Array();
	statme_drawdata = new Array();
	statme_selecteddata = new Array();
	statme_type = new Array();
	statme_loaded = new Array();
	statme_ready = new Array();
	statme_text = new Array();
	statme_error = new Array();
	statme_busy = new Array();
	statme_nbctx = 0;
	statme_intervallaunch = 0;
}

function statme_draw(t,can_redraw)
{
	if(statme_error[t] == 0 && statme_busy[t]==0)
	{
		statme_busy[t]==1;
		// background
		for(x=0;x<Math.floor(statme_width[t]/112)+1;x++)
		{
			for(y=0;y<Math.floor(statme_height[t]/112)+1;y++)
			{
				statme_ctx[t].drawImage(statme_img[0], x*112, y*112);
			}
		}
		if(statme_type[t]==statme_M_stat)
		{
			for(x=1;x<8;x++)
			{
				brique(statme_ctx[t],20,300-(x*40),statme_width[t]-130,20,0,'0,0,0',0.10);
			}
		}
	
		if(statme_loaded[t] == 1)
		{
			// pregestion des deplacement
			if(statme_spos[t]<0)
					statme_spos[t] = 0;
		
			// traitement des donnée en fonction du mode
			if(statme_mode[t]==2 && statme_modechange[t]==1)
			{
				var tmois = -1;
				var tmois2 = 1;
				var tdata = new Array();
				var tdata2 = new Array();
				statme_drawdata[t] = new Array();
				statme_drawdata[t][0] = statme_data[t][0];
				
				// default date
				var tdate=new Date();
				tdate.setTime(parseInt(statme_data[t][1][0]));
				tmois = tdate.getMonth();
				
			
				for(numdata=1;numdata<statme_data[t].length;numdata++)
				{
					var nextdate=new Date();
					nextdate.setTime(parseInt(statme_data[t][numdata][0]));
					if(tmois != nextdate.getMonth())
					{
						for(xdata=0;xdata<tdata.length;xdata++)
						{
							tdata[xdata] = Math.ceil(tdata[xdata]/tdata2[xdata]);
						}
						
						// fix for seconde spe
						tdata[(tdata.length-1)] = 0;

						statme_drawdata[t][tmois2] = new Array();	
						statme_drawdata[t][tmois2] = tdata;
						
						// reini
						tmois = nextdate.getMonth();
						tmois2 = tmois2 + 1;
						tdata = new Array();
						tdata2 = new Array();
					}
				
					for(xdata=0;xdata<statme_data[t][numdata].length;xdata++)
					{
						if(typeof(tdata[xdata]) != 'undefined')
						{
							tdata[xdata] = parseInt(tdata[xdata]) + parseInt(statme_data[t][numdata][xdata]);
							tdata2[xdata] = tdata2[xdata]  + 1;
						}
						else
						{
							tdata[xdata] = parseInt(statme_data[t][numdata][xdata]);
							tdata2[xdata] = 1;
						}
					}
				}
				
				for(xdata=0;xdata<tdata.length;xdata++)
				{
					tdata[xdata] = Math.ceil(tdata[xdata]/tdata2[xdata]);
				}
						
				// fix for seconde spe
				tdata[(tdata.length-1)] = 0;

				statme_drawdata[t][tmois2] = new Array();	
				statme_drawdata[t][tmois2] = tdata;
			}		
			else if(statme_modechange[t]==1)
			{
				// pre-traitement du deplacement
				datamax = Math.floor((statme_width[t]-120)/20);
				datamax = (datamax>statme_data[t].length)?statme_data[t].length:datamax;
				statme_drawdata[t][0]=statme_data[t][0];
			
				for(x=1;x<datamax;x++)
				{
					statme_drawdata[t][x]=statme_data[t][(statme_spos[t]+x)];
				}
				
				statme_icangoright[t] = ((statme_spos[t] + Math.floor((statme_width[t]-120)/20)) <= statme_data[t].length-1)?true:false;
			}
			statme_modechange[t]=0;
		
			splitpostex = 0;
			semaine = 1;
			mois = 1;
			stat_xold = new Array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1);
			stat_yold = new Array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1);
			stat_min = new Array(99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999,99999);
			stat_max = new Array(100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100,100);
			annee = 1;
			//datamax = Math.floor((statme_width[t]-20)/statme_drawdata[t].length);
			//datanb = ((statme_drawdata[t].length-1)>datamax)?datamax+1:(statme_drawdata[t].length-1);
			
			// precalcule min/max
			for(x=1;x<statme_drawdata[t].length-1;x++)
			{
				if(statme_type[t]==statme_M_stat)
				{
					for(a=1;a<statme_drawdata[t][x].length;a++)
					{
						if(stat_max[a]<(statme_drawdata[t][x][a] +0))
						{
							stat_max[a] = statme_drawdata[t][x][a] + 0;
						}
						if(stat_min[a]>(statme_drawdata[t][x][a] +0))
						{
							stat_min[a] = statme_drawdata[t][x][a] + 0;
						}
					}
				}
			}
			
			
			for(x=1;x<statme_drawdata[t].length-1;x++)
			{
				if(splitpostex == 0)
					splitpostex = 15;
				else if(splitpostex==15)
					splitpostex = 30;
				else
					splitpostex = 0;	
				
				// base image= 0;
				var posadd = 0;
				if(statme_type[t]!=statme_M_stat)
					statme_ctx[t].drawImage(statme_img[2], x*21, 50);
			
				// historique
				selected_data = new Array();
				for(a=0;a<statme_drawdata[t][x].length;a++)
				{
					if(statme_type[t]!=statme_M_stat)
					{
						if(statme_drawdata[t][x][a]==1)
						{
							posadd = posadd + 1;
							if(a==statme_drawdata[t][x].length-1)
								statme_ctx[t].drawImage(statme_img[33], x*21+posadd, 50+posadd);
							else
								statme_ctx[t].drawImage(statme_img[21+a], x*21+posadd, 50+posadd);
							selected_data.push(statme_drawdata[t][0][a]);
						}
					}
					else
					{						
						tta = statme_drawdata[t][x][a]-stat_min[a];
						ttb = stat_max[a]-stat_min[a];
						if(ttb==0)
							tty = 1;
						else
							tty = tta/ttb;
							
						if(statme_selecteddata[t] > 0)
						{
							if(statme_selecteddata[t] == a)
							{
								cercle(statme_ctx[t], x*21+10, Math.floor(290-(tty*250)),stat_xold[a],stat_yold[a],5,1,statme_color[2+a],1.0);
								stat_xold[a] = x*21+10;
								stat_yold[a] = Math.floor(290-(tty*250));
								if(x-1>0)
								{
									if(statme_drawdata[t][x][a] != statme_drawdata[t][x-1][a])
									{
										statme_ctx[t].textAlign = "left";	
										statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
										statme_ctx[t].fillText(statme_drawdata[t][x][a], x*21+15, Math.floor(280-(tty*250)));
									}
								}
								else
								{
									statme_ctx[t].textAlign = "left";	
									statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
									statme_ctx[t].fillText(statme_drawdata[t][x][a], x*21+15, Math.floor(280-(tty*250)));
								}
							}
							else
							{
								cercle(statme_ctx[t], x*21+10, Math.floor(290-(tty*250)),stat_xold[a],stat_yold[a],5,1,statme_color[2+a],0.10);
								stat_xold[a] = x*21+10;
								stat_yold[a] = Math.floor(290-(tty*250));
							}
						}
						else
						{
							cercle(statme_ctx[t], x*21+10, Math.floor(290-(tty*250)),stat_xold[a],stat_yold[a],5,1,statme_color[2+a],0.5);
							stat_xold[a] = x*21+10;
							stat_yold[a] = Math.floor(290-(tty*250));
						}
						
					}
				}
			
				// text
				statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
				statme_ctx[t].textAlign = "center";
				statme_ctx[t].textBaseline = "alphabetic";
				statme_ctx[t].font = "9pt bold Arial";
				statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
				
				// recuperation des date
				var ladate=new Date();
				var nextdate=new Date();
				ladate.setTime(statme_drawdata[t][x][0]);
				if(x+1<statme_drawdata[t].length-1)
					nextdate.setTime(statme_drawdata[t][(x+1)][0]);
				else
					nextdate.setTime(999999999999999);
				
				// affichage des dates
				statme_ctx[t].fillText(ladate.getDate(), x*21+10, 315);
				brique(statme_ctx[t],x*21,300,20,17,0,'0,0,0',0.25);
				//statme_ctx[t].fillText(getWeek(ladate), x*21+100+10, 330);
				if(ladate.getMonth() != nextdate.getMonth())
				{
					statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
					statme_ctx[t].fillText(ladate.getMonth(), (((x-mois)/2)+mois)*21+10, 330);
					brique(statme_ctx[t],mois*21,318,(x-mois+1)*21-1,14,0,'0,0,0',0.25);
					if((statme_mousex[t]-statme_posx[t])>(mois*21) && (statme_mousex[t]-statme_posx[t])<(((x-mois+1)*21-1)+mois*21) && (statme_mousey[t]-statme_posy[t])>318 && (statme_mousey[t]-statme_posy[t])<332)
					{
						brique(statme_ctx[t],mois*21,318,(x-mois+1)*21-1,14,0,'255,255,255',0.25);
						if(statme_mouseclick[t]==1)
						{
							statme_mode[t]=2;
							statme_modechange[t]=1;
							statme_mouseclick[t]=0;
						}
						
					}
					mois = x+1;
				}
				if(ladate.getFullYear() != nextdate.getFullYear())
				{
					statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
					statme_ctx[t].fillText(ladate.getFullYear(), (((x-annee)/2)+annee)*21+10, 345);
					brique(statme_ctx[t],annee*21,333,(x-annee+1)*21-1,14,0,'0,0,0',0.25);
					if((statme_mousex[t]-statme_posx[t])>(annee*21) && (statme_mousex[t]-statme_posx[t])<(((x-annee+1)*21-1)+annee*21) && (statme_mousey[t]-statme_posy[t])>333 && (statme_mousey[t]-statme_posy[t])<347)
					{
						brique(statme_ctx[t],annee*21,333,(x-annee+1)*21-1,14,0,'255,255,255',0.25);
						if(statme_mouseclick[t]==1)
						{
							statme_mode[t]=3;
							statme_modechange[t]=1;
							statme_mouseclick[t]=0;
						}
					}
					annee = x+1;
				}
			
				// survol
				if(statme_type[t]!=statme_M_stat)
					{
				if((statme_mousex[t]-statme_posx[t])>(x*21) && (statme_mousex[t]-statme_posx[t])<(x*21+20) && (statme_mousey[t]-statme_posy[t])>0 && (statme_mousey[t]-statme_posy[t])<315)
				{
					posadd = posadd + 1;
					statme_text[t] = selected_data;
					statme_ctx[t].drawImage(statme_img[1], x*21+posadd-1, 50+posadd);
					brique(statme_ctx[t],x*21,301,20,17,0,'255,255,255',0.25);
					if(statme_mouseclick[t]==1)
					{
						statme_mode[t]=1;
						statme_modechange[t]=1;
						statme_mouseclick[t]=0;
					}
				}
				}
			}			

			// pre-traitement des info
			for(x=0;x<20;x++)
			{
				if(typeof(statme_text[t][x]) == 'undefined')
				statme_text[t][x] = '';
			}
			
			// affichage des infos survolée
			if(statme_type[t]==statme_M_stat)
			{
				tempforselectedstat = false;
				for(x=1;x<statme_drawdata[t][0].length;x++)
				{		
					statme_ctx[t].textAlign = "left";	
					statme_ctx[t].fillStyle = "rgba("+statme_color[x+2]+",1)";
					//statme_ctx[t].fillText(selected_data[x], statme_width[t]-95, 15*x);
					statme_ctx[t].fillText(statme_drawdata[t][0][x], statme_width[t]-95, 15*x);
					if((statme_mousex[t]-statme_posx[t])>statme_width[t]-95 && (statme_mousey[t]-statme_posy[t])>(15*x-15) && (statme_mousey[t]-statme_posy[t])<15*x)
					{
						brique(statme_ctx[t],statme_width[t]-95,15*x-13,95,14,0,'255,0,0',0.25);
						statme_selecteddata[t] = x;
						tempforselectedstat = true;
					}
				}
				if(!tempforselectedstat)
				{
					statme_selecteddata[t] = 0;
				}
			}
			else
			{	
				statme_ctx[t].textAlign = "center";
				statme_ctx[t].textBaseline = "alphabetic";
				statme_ctx[t].font = "10pt bold Arial";
				statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
				statme_ctx[t].fillText(statme_text[t][0], statme_width[t]/2, 10);
				statme_ctx[t].fillText(statme_text[t][1], statme_width[t]/2, 25);
				statme_ctx[t].fillText(statme_text[t][2], statme_width[t]/2, 40);
				statme_ctx[t].fillText(statme_text[t][3], statme_width[t]/2, 55);
				statme_ctx[t].fillText(statme_text[t][4], statme_width[t]/2, 70);
				statme_ctx[t].fillText(statme_text[t][5], statme_width[t]/2, 85);
			}
			
			// deplacement gauche
			if(statme_spos[t]>0)
			{
				if((statme_mousex[t]-statme_posx[t])>0 && (statme_mousex[t]-statme_posx[t])<21 && 
					(statme_mousey[t]-statme_posy[t])>50 && (statme_mousey[t]-statme_posy[t])<317)
				{
					if(statme_mouseclick[t]==1)
					{
							statme_spos[t] = statme_spos[t] - 1;
							statme_mouseclick[t]=0;
							statme_modechange[t]=1;
					}
					brique(statme_ctx[t],0,50,20,267,0,'255,255,255',0.25);
				}
				statme_ctx[t].drawImage(statme_img[3], 0, 250);
			}
			
			// deplacement droit
			if(statme_icangoright[t])
			{
				if((statme_mousex[t]-statme_posx[t])>(statme_width[t]-120) && (statme_mousex[t]-statme_posx[t])<(statme_width[t]-100) && 
					(statme_mousey[t]-statme_posy[t])>50 && (statme_mousey[t]-statme_posy[t])<317)
				{
					if(statme_mouseclick[t]==1)
					{
							statme_spos[t] = statme_spos[t] + 1;
							statme_mouseclick[t]=0;
							statme_modechange[t]=1;
					}
					brique(statme_ctx[t],statme_width[t]-120,50,20,267,0,'255,255,255',0.25);
				}
				statme_ctx[t].drawImage(statme_img[4], statme_width[t]-120, 250);
			}
			
			// text informatif :
			statme_ctx[t].textAlign = "left";
			statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
			statme_ctx[t].fillText(": Jour", (statme_width[t]-100), 315);
			statme_ctx[t].fillText(": Mois", (statme_width[t]-100), 330);
			statme_ctx[t].fillText(": Année", (statme_width[t]-100), 345);
		
			/*statme_ctx[t].fillText("x: "+statme_mousex[t], (statme_width[t]-100), 15);
			statme_ctx[t].fillText("y: "+statme_mousey[t], (statme_width[t]-100), 30);
			statme_ctx[t].fillText("c: "+statme_mouseclick[t], (statme_width[t]-100), 45);
			statme_ctx[t].fillText("m: "+statme_mode[t], (statme_width[t]-100), 60);*/
			
		}
		statme_busy[t]==0;
	}
	else
	{
		brique(statme_ctx[t],0,0,statme_width[t],statme_height[t],1,'255,0,0',0.25);
			
		// affichage des infos
		statme_ctx[t].textAlign = "center";
		statme_ctx[t].textBaseline = "alphabetic";
		statme_ctx[t].font = "10pt bold Arial";
		statme_ctx[t].fillStyle = "rgba(0,0,0,1)";
		statme_ctx[t].fillText("Une erreur est survenue", statme_width[t]/2, (statme_height[t]/2)-10);
		statme_redraw = false;
	}
	
	if(can_redraw)
		statme_draw(t,false);
	
}

function brique(ctx,x,y,width,height,border,color,alpha)
{
	// limitation transparence
	if (alpha<0.0)
		alpha=0.0;
	if (alpha>1.0)
		alpha=1.0;

	// limitation arrondi
		var minimum = 0;
	if(width<height)
		minimum = width;
	else
		minimum = height;

	ctx.fillStyle = "rgba("+color+","+alpha+")";
	ctx.beginPath();
	ctx.fillRect(x, y, width, height);
	if(border>0)
	{
		ctx.fillStyle = "rgba(0,0,0,"+alpha+")";
		ctx.beginPath();
		ctx.moveTo(x,y);
		ctx.lineTo(x,y+height);
		ctx.lineTo(x+width,y+height);
		ctx.lineTo(x+width,y);
		ctx.lineTo(x,y);
		ctx.lineWidth = border;
		ctx.strokeStyle = "rgba(0,0,0,"+alpha+")";
		ctx.stroke();
		ctx.closePath();
	}

}

function cercle(ctx,x,y,xold,yold,range,border,color,alpha)
{
	// limitation transparence
	if (alpha<0.0)
		alpha=0.0;
	if (alpha>1.0)
		alpha=1.0;

	// limitation arrondi
	if(range<1)
		range = 1;

	ctx.fillStyle = "rgba("+color+","+alpha+")";
	ctx.beginPath();
	ctx.arc(x, y, range, 0, Math.PI*2, true);
	ctx.fill();
	if(xold>-1 && yold>-1)
	{
		ctx.beginPath();
		ctx.moveTo(xold,yold);
		ctx.lineTo(x,y);
		ctx.lineWidth = 2;
		ctx.strokeStyle = "rgba("+color+","+alpha+")";
		ctx.stroke();
	}
		
	if(border>0)
	{
		ctx.fillStyle = "rgba(0,0,0,"+alpha+")";
		ctx.beginPath();
		ctx.arc(x, y, range, 0, Math.PI*2, true); 
		ctx.lineWidth = border;
		ctx.strokeStyle = "rgba(0,0,0,"+alpha+")";
		ctx.stroke();
	}

}

function getWeek(uneDate)
{
		var d = uneDate;
		var DoW = d.getDay();
		d.setDate(d.getDate() - (DoW + 6) % 7 + 3); // Nearest Thu
		var ms = d.valueOf(); // GMT
		d.setMonth(0);
		d.setDate(4); // Thu in Week 1
		return Math.round((ms - d.valueOf()) / (7 * 864e5)) + 1;
}






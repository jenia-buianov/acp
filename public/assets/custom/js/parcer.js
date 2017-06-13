var countTeams = 0;
var LINKS = {};
function startParcer(){

	$('#status_').html('STARTED');
	
	var link = $('#link').val();
	post = {
		_token:$('#_token').val(),
		link:link,
		modal:1
	};
	$.ajax({
			url: HOME_URL +'/parcer',
			data: post,
			method: 'POST',
			dataType: "json",
			success: function (data) {
				$('#response').html('');
				for(var k=0;k<data.length;k++){
					$('#response').append('<div style="text-align: left;width:49%;display:inline-block;margin-bottom:1em">'+data[k].title+'</div><div id="team'+k+'" data-link="'+data[k].link+'" style="width:49%;display:inline-block;margin-bottom:1em"><button class="btn btn-default" onclick=parseTeam('+k+')>'+data[k].title+' START</button></div>');
				}
				countTeams = data.length;
				parseTeam(0);
			},
			error: function (response) {
				$('#response').html(response);
			}
		});
}

function parseTeam(i) {
	var link = $('#team'+i).attr('data-link');
	post = {
		_token:$('#_token').val(),
		link:link,
		modal:1
	};
	$.ajax({
		url: HOME_URL +'/parceteam',
		data: post,
		method: 'POST',
		success: function (data) {
			$('#team'+i).html('TEAM Added');
			procents  = parseInt(parseFloat((i+1)/countTeams)*100);
			$('#status_').html('Parsing teams: '+(i+1)+'/'+countTeams+' = '+procents+'%');
			if(i==countTeams-1) parseCalendar(); else parseTeam(i+1);
		},
		error: function (response) {
			$('#response').html(response);
		}
	});
}


function parseCalendar() {
	var link = $('#link').val();
	post = {
		_token:$('#_token').val(),
		link:link,
		modal:1
	};
	$.ajax({
		url: HOME_URL +'/parcecalendar',
		data: post,
		method: 'POST',
		dataType: "json",
		success: function (data) {
			console.log(data);
			LINKS = data;
			//parseRound(1,LINKS);
			$('#status_').html('TEAMS parsed<br>');
		},
		error: function (response) {
			$('#response').html(response);
		}
	});
}

function parseRound(r,LINKS){
	post = {
		_token:$('#_token').val(),
		link:LINKS[r],
		round:r,
		modal:1
	};
	$.ajax({
		url: HOME_URL +'/parceround',
		data: post,
		method: 'POST',
		success: function (data) {
			$('#status_').append('ROUND '+r+' parsed<br>');
			//if(r<LINKS.length) parseRound(r+1,LINKS);
		},
		error: function (response) {
			$('#response').html(response);
		}
	});
}
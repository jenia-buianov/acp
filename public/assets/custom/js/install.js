$(document).ready(function () {
	$('.panel .tabs li').on('click',function (e) {
		next($(this).index());
	});
});

function next(n) {
	$('.panel .tabs .active').removeClass('active');
	$('.panel .tabs li:eq('+n+')').addClass('active');
	$('.panel form text').css('display','none');
	$('.panel form text:eq('+n+')').css('display','block');
}

MAINDB = 1;

function addAnotherDB() {
	count = $('#databases h4').length + 1;
	db = $('#databases h4:eq(0)').html().split('№');
	db = db[0]+'№';
	html = '<h4>'+db+count+'</h4>';
	html+='<div class="form-group">';
	html+='<label class="sr-only">'+$('#databases label:eq(0)').html()+'</label>';	html+='<div class="input-group">		<div class="input-group-addon">		<i class="fa fa-server" aria-hidden="true"></i> </div>';
	html+='<input type="text" class="form-control" name="host[]" placeholder="'+$('#databases label:eq(0)').html()+'"></div></div>';

	html+='<div class="form-group">';
	html+='<label class="sr-only">'+$('#databases label:eq(1)').html()+'</label>';	html+='<div class="input-group">		<div class="input-group-addon">		<i class="fa fa-user" aria-hidden="true"></i> </div>';
	html+='<input type="text" class="form-control" name="user[]" placeholder="'+$('#databases label:eq(1)').html()+'"></div></div>';

	html+='<div class="form-group">';
	html+='<label class="sr-only">'+$('#databases label:eq(2)').html()+'</label>';	html+='<div class="input-group">		<div class="input-group-addon">		<i class="fa fa-key" aria-hidden="true"></i> </div>';
	html+='<input type="password" class="form-control" name="password[]" placeholder="'+$('#databases label:eq(2)').html()+'"></div></div>';

	html+='<div class="form-group">';
	html+='<label class="sr-only">'+$('#databases label:eq(3)').html()+'</label>';	html+='<div class="input-group">		<div class="input-group-addon">		<i class="fa fa-table" aria-hidden="true"></i> </div>';
	html+='<input type="text" class="form-control" name="databases[]" placeholder="'+$('#databases label:eq(3)').html()+'"></div></div>';

	$('#databases').append(html);
	event.preventDefault();
	$('html, body').animate({
		scrollTop: $("#databases h4:eq("+(count-1)+")").offset().top-30
	}, 500);

}

function verifyDB() {
	count = $('#databases h4').length;
	if (count>1)
	{
		var main = prompt(LANG.mainDB+count);
		if (main<1||main>count)
		{
			alert('You entered wrong number. Please try again');
			verifyDB();
		}
		MAINDB = main;
	}

	HOSTS = [];
	USERS = [];
	DB = [];
	PASSWORDS = [];
	alerts = '';

	for(i=0;i<count;i++){
		k = i*4;

		$('#databases .form-group:eq('+k+')').removeClass('has-error');
		$('#databases .form-group:eq('+(k+1)+')').removeClass('has-error');
		$('#databases .form-group:eq('+(k+2)+')').removeClass('has-error');
		$('#databases .form-group:eq('+(k+3)+')').removeClass('has-error');

		if ($('#databases input:eq('+k+')').val().length==0) {
			alerts+= $('#databases input:eq('+k+')').attr('placeholder')+'#'+(i+1)+', ';
			$('#databases .form-group:eq('+k+')').addClass('has-error');
		}
		else HOSTS.push($('#databases input:eq('+k+')').val());


		if ($('#databases input:eq('+(k+1)+')').val().length==0) {
			alerts+= $('#databases input:eq('+(k+1)+')').attr('placeholder')+'#'+(i+1)+', ';
			$('#databases .form-group:eq('+(k+1)+')').addClass('has-error');
		}
		else USERS.push($('#databases input:eq('+(k+1)+')').val());


		if ($('#databases input:eq('+(k+2)+')').val().length==0){
			$('#databases .form-group:eq('+(k+2)+')').addClass('has-error');
			alerts+= $('#databases input:eq('+(k+2)+')').attr('placeholder')+'#'+(i+1)+', ';
		}
		else PASSWORDS.push($('#databases input:eq('+(k+2)+')').val());


		if ($('#databases input:eq('+(k+3)+')').val().length==0) {
			$('#databases .form-group:eq('+(k+3)+')').addClass('has-error');
			alerts+= $('#databases input:eq('+(k+3)+')').attr('placeholder')+'#'+(i+1)+', ';
		}
		else DB.push($('#databases input:eq('+(k+3)+')').val());
	}

	if (alerts.length>1) {
		$('.bg-danger:eq(2)').html(alerts.substr(0,alerts.length-2)+' '+LANG.not_entered);
		$('.bg-danger:eq(2)').css('display','block');
		$('html, body').animate({
			scrollTop: $(".bg-danger:eq(2)").offset().top-30
		}, 500);
		return ;
	}


	post = JSON.stringify({
		hosts:HOSTS,
		users:USERS,
		db:DB,
		pass:PASSWORDS
	});
	APPLICATION.sendRequest({
		controller: "verify",
		post:post
	});


}

function setAdmin(e) {
	tg = $(e).attr('name');
	tag = tg.charAt(0).toUpperCase() + tg.slice(1);
	$('input[name="admin'+tag+'"]').val($(e).val());
}
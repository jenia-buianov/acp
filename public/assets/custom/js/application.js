function App() {
	this.timers = {};
	this.timer = 0;
	this.selectors = ['.ajax_request'];
	this.elements = {};
	this.preloader();
	this.tryLoadPage = 0;
}
App.prototype = {

	removeAttributes: function () {
		var self = this;
		for (var k = 0; k < self.selectors.length; k++)
			for (var i = 0; i < $(self.selectors[k]).length; i++) {
				element = $(self.selectors[k] + ':eq(' + i + ')');
				u = p = '';
				if (element.attr('data-url')) u = element.attr('data-url');
				if (element.attr('data-post')) p = element.attr('data-post');

				if (u.length >0) self.elements['sel'+i]= {controller:u,post:p};
				element.removeAttr('data-url');

				if (u.length > 0&&$(self.selectors[k] + ':eq(' + i + ')').prop('tagName')!=='FORM') element.click(function (event) {
					event.preventDefault();
					index = $(this).index(self.selectors[0]);
					self.sendRequest(self.elements['sel'+index]);
					return false;
				});

				if (u.length > 0&&$(self.selectors[k] + ':eq(' + i + ')').prop('tagName')=='FORM') element.submit(function(event){
					event.preventDefault();
					index = $(this).index(self.selectors[0]);
					self.sendRequest(self.elements['sel'+index]);
					return false;
				});
			}
	},
	sendRequest: function (el) {

		var url = '';
		var self = this;
		var post = {};
		if (el.controller) url += el.controller;
		if (el.post) post = JSON.parse(el.post);
		post._token = $('#_token').val();
		if (url.length == 0) return;
		if (url=='/') url = '';
		$.ajax({
			url: HOME_URL + '/' + url,
			data: post,
			method: 'POST',
			dataType: "json",
			success: function (data) {
				APPLICATION.tryLoadPage = 0;
				if ($('.wrapper_preload').length > 0) {
					$('.wrapper_preload').remove();
					$('body').append(data[0].html);
					self.removeAttributes();
				}

				self.responseJob(data);
			},
			error: function (response) {
				if (APPLICATION.tryLoadPage < 3) {
					APPLICATION.tryLoadPage++;
					setTimeout(function () {
						self.sendRequest(el);
					}, 2000);
				} else if ($('.wrapper_preload').length > 0) location.replace(HOME_URL+'/'+url); else alert('Cannot load page ' + url);
			}
		});
		return false;
	},
	responseJob: function (el) {
		var self = this;

		$.each(el, function (i, v) {
			if (v.action == 'update') self.updateElement(v);
			if (v.action == 'add') self.addElement(v);
			if (v.action == 'hide') self.hideElement(v);
			if (v.action == 'delete') self.deleteElement(v);
			if (v.action == 'reset') self.resetTimer(v);
			if (v.action == 'animate') self.animateElement(v);
			if (v.action == 'css') self.cssElement(v);
			if (v.action == 'load') self.loadPage(v);


			if (i == el.length - 1) {
				self.removeAttributes();
				self.setTimers();
				$.getScript(self.materialize, function (data) {});
			}
		});
	},
	animateElementCSS: function (el) {
		$(el.target).animateCss(el.effect);
	},
	updateElement: function(el){
		$(el.target).html(el.html);
		if (el.effect) $(el.target).animateCss(el.effect);
	},
	addElement: function(el){
		$(el.target).append(el.html);
		if (el.effect) $(el.name).animateCss(el.effect);
	},
	hideElement: function(el){
		$(el.target).hide();
	},
	deleteElement: function(el){
		$(el.target).remove();
	},
	setTimers: function(){
		var self = this;
		for(var i=0;i<$('timer').length;i++){
			element = $('timer:eq('+i+')');
			start = parseInt(element.attr('data-start'));
			if (!start) continue;
			var finish = new Date().addTime(start);
			var nObject = {
				link: element.attr('data-target'),
				action:element.attr('data-action'),
				target:element.attr('data-target'),
				animation:element.attr('data-animation'),
				start:start,
				el: element,
				finish: finish,
				timer: 0
			};
			self.timers[$(element).attr('id')] = nObject;
			element.removeAttr('data-start');
			element.removeAttr('data-target');
			element.removeAttr('data-action');
			if (i==$('timer').length-1) self.timer = setInterval(self.startTimer,1000);
		}
	},
	startTimer: function (){
		var self = this;

		$.each(APPLICATION.timers, function(i,v){
			el = APPLICATION.timers[i];
			time = parseInt((el.finish - new Date)/1000);
			if (time<0) {
				if(el.action=='sendRequest') APPLICATION.sendRequest({controller:el.link});
				if(el.action=='cssElement') {
					console.log(el);
					$(el.link).animateCss(el.animation);
					APPLICATION.resetTimer({element:'#'+$(el.el).attr('id'),start:el.start,target:el.target,action:el.action,animation:el.animation});
				}
				delete APPLICATION.timers[i];
			}else {
				minutes = parseInt(time / 60);
				sec = time - minutes * 60;
				if (sec < 10) sec = '0' + sec;
				el.el.html(minutes + ':' + sec);
			}
		});

	},
	resetTimer:function (el) {
		element = $(el.element);
		start = parseInt(el.start);
		var finish = new Date().addTime(start);
		var nObject = {
			link: el.target,
			action:el.type,
			animation:el.animation,
			target:el.target,
			start:el.start,
			el: element,
			finish: finish,
			timer: 0
		};
		APPLICATION.timers[$(element).attr('id')] = nObject;
	},
	animateElement: function (el) {
		if(el.out){
			$(el.name+' '+el.block).fadeOut(200);
			el.time = parseInt(el.time)+200;
		}
		$(el.name).animate(el.animate,el.time);
		if (el.in&&el.block)	$(el.name+' '+el.block).delay(parseInt(el.time)).fadeIn(200);

	},
	cssElement: function (el) {
		$(el.name).css(el.css);
	},
	cssElement: function (el) {
		$(el.name).css(el.css);
	},
	preloader: function () {
		var self = this;
		self.sendRequest({controller: window.location.pathname});
	},
	loadPage: function (el) {
		var self = this;
		if (el.js) $.getScript(el.js, function (data) {
		});
		$('.content').html(el.html);
	}
};
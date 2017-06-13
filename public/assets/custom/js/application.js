function App() {
	this.timers = [];
	this.timer = 0;
	this.selectors = ['.ajax_request'];
	this.elements = [];
	this.preloader();
	this.tryLoadPage = 0;
}
App.prototype = {

	removeAttributes: function () {
		var self = this;
		for (var k = 0; k < self.selectors.length; k++)
			for (var i = 0; i < $(self.selectors[k]).length; i++) {
				c = m = p = "";
				element = $(self.selectors[k] + ':eq(' + i + ')');
				if (element.attr('data-controller')) c = element.attr('data-controller');
				if (element.attr('data-method')) m = element.attr('data-method');
				if (element.attr('data-post')) p = element.attr('data-post');

				if (c.length > 0 || m.length > 0) self.elements.push({controller: c, method: m, post: p});
				element.removeAttr('data-controller');
				element.removeAttr('data-method');
				element.removeAttr('data-post');
				if (c.length > 0 || m.length > 0) element.click(function (event) {
					event.preventDefault();
					index = $(this).index(self.selectors[0]);
					self.sendRequest(self.elements[index]);
				});
			}
	},
	sendRequest: function (el) {

		var url = '';
		var self = this;
		var post = {};
		if (el.controller) url += el.controller;
		if (el.method) url += '/' + el.method;
		if (el.post) post = JSON.parse(el.post);
		post._token = $('#_token').val();
		if (url.length == 0) return;
		if (url=='/') url = '';
		$.ajax({
			url: HOME_URL + '/' + url,
			data: post,
			method: 'POST',
			dataType: "json",
			xhrFields: {
				onprogress: function (e) {
					if (e.lengthComputable) {
						if ($('.preloader-wrapper').length > 0) $('preloader t').html(e.loaded / e.total * 100 + '%');
					}
				}
			},
			success: function (data) {
				APPLICATION.tryLoadPage = 0;
				if ($('.preloader-wrapper').length > 0) {
					$('.preloader-wrapper').remove();
					$('body').append(data[0].html);
					$('body').append(data[1].html);
					self.removeAttributes();
					$.getScript(self.materialize, function (data) {
						$('.button-collapse').sideNav({'edge': 'left'});
						return false;
					});
				}

				self.responseJob(data);
			},
			error: function (response) {
				if (APPLICATION.tryLoadPage < 3) {
					APPLICATION.tryLoadPage++;
					setTimeout(function () {
						self.sendRequest(el);
					}, 2000);
				} else if ($('.preloader-wrapper').length > 0) location.replace(HOME_URL+'/'+url); else alert('Cannot load page ' + url);
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
	updateElement: function (el) {
		$(el.target).html(el.html);
		if (el.effect) $(el.target).animateCss(el.effect);
	},
	addElement: function (el) {
		$(el.target).append(el.html);
		if (el.effect) $(el.name).animateCss(el.effect);
	},
	hideElement: function (el) {
		$(el.target).hide();
	},
	deleteElement: function (el) {
		$(el.target).remove();
	},
	setTimers: function () {
		var self = this;
		for (var i = 0; i < $('timer').length; i++) {
			element = $('timer:eq(' + i + ')');
			start = parseInt(element.attr('data-start'));
			if (!start) continue;
			var finish = new Date().addTime(start);
			var nObject = {
				link: element.attr('data-target'),
				action: element.attr('data-action'),
				el: element,
				finish: finish,
				timer: 0
			};
			self.timers.push(nObject);
			element.removeAttr('data-start');
			element.removeAttr('data-target');
			element.removeAttr('data-action');
			if (i == $('timer').length - 1)self.timer = setInterval(self.startTimer, 1000);
		}
	},
	startTimer: function () {
		var self = this;
		for (var k = 0; k < APPLICATION.timers.length; k++) {
			el = APPLICATION.timers[k];
			time = parseInt((el.finish - new Date) / 1000);
			if (time < 0) {
				if (el.action == 'sendRequest') APPLICATION.sendRequest({controller: el.link});
				APPLICATIONE.timers.splice(k, 1);
			} else {
				minutes = parseInt(time / 60);
				sec = time - minutes * 60;
				if (sec < 10) sec = '0' + sec;
				el.el.html(minutes + ':' + sec);
			}
		}
	},
	resetTimer: function (el) {
		element = $(el.element);
		start = parseInt(el.start);
		var finish = new Date().addTime(start);
		var nObject = {
			link: el.target,
			action: el.type,
			el: element,
			finish: finish,
			timer: 0
		};
		GAME.timers.push(nObject);
	},
	animateElement: function (el) {
		if (el.out) {
			$(el.name + ' ' + el.block).fadeOut(200);
			el.time = parseInt(el.time) + 200;
		}
		$(el.name).animate(el.animate, el.time);
		if (el.in && el.block)    $(el.name + ' ' + el.block).delay(parseInt(el.time)).fadeIn(200);

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
}
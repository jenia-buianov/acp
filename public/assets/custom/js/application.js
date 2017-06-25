function App() {
	this.timers = {};
	this.timer = 0;
	this.selectors = ['.ajax_request'];
	this.elements = {};
	this.preloader();
	this.tryLoadPage = 0;
    this.notificationTimer = false;
	this.APPS = {}
}
App.prototype = {

	removeAttributes: function () {
		var self = this;
		for (var k = 0; k < self.selectors.length; k++)
			for (var i = 0; i < $(self.selectors[k]).length; i++) {
				element = $(self.selectors[k] + ':eq(' + i + ')');
				u = p =  h ='';
				if (element.attr('data-url')) u = element.attr('data-url');
				if (element.attr('data-post')) p = element.attr('data-post');
				if (element.attr('data-history')) h = element.attr('data-history');

				if (u.length >0) self.elements['sel'+i]= {controller:u,post:p,history:h};
				element.removeAttr('data-url');
				element.removeAttr('data-post');
				element.removeAttr('data-history');

				if (u.length > 0&&$(self.selectors[k] + ':eq(' + i + ')').prop('tagName')!=='FORM') element.click(function (event) {
					event.preventDefault();
					index = $(this).index(self.selectors[0]);
					self.sendRequest(self.elements['sel'+index]);
					return false;
				});

				if (u.length > 0&&$(self.selectors[k] + ':eq(' + i + ')').prop('tagName')=='FORM') element.submit(function(event){
					event.preventDefault();
					index = $(this).index(self.selectors[0]);

					var valuesArray = {};
					var alerts = "";
					$(element).find('input, select, textarea').each(function(e,v)
					{
					    if (!$(v).prop('disabled')&&v.type!=='checkbox'&&v.name.length>0) {
					        $(v).parents('.form-group').removeClass('has-error');
                            if (v.type !== 'radio') {
                                if (v.placeholder == undefined) v.placeholder = $(v).attr('data-placeholder');
                                valuesArray[e] = {
                                    'value': v.value,
                                    'name': v.name,
                                    'must': parseInt($(v).attr('must')),
                                    'title': v.placeholder
                                };

                            }
                            else {
                                if (v.placeholder == undefined) v.placeholder = $(v).attr('data-placeholder');
                                valuesArray[e] = {
                                    'value': $('input[name="' + v.name + '"]:checked'),
                                    'name': v.name,
                                    'must': parseInt($(v).attr('must')),
                                    'title': v.placeholder
                                };
                            }
                            if (parseInt($(v).attr('must')) == 1 && v.value.length == 0) {
                                $(v).parents('.form-group').addClass('has-error');
                                alerts += ", " + v.placeholder;
                            }
                        }

					});
					if (alerts.length>0)
					{
						self.showNotification({title:LANG.not_entered_all,type:"danger",text:alerts.substr(2)+' '+LANG.not_entered});
						return false;
					}
					post = {
						values:valuesArray
					};

					if (self.elements['sel'+index].controller=='install/finish'){
						post['DATABASE'] = DB;
						post['USERS'] = USERS;
						post['HOSTS'] = HOSTS;
						post['PASS'] = PASSWORDS;
						post['MAIN'] = MAINDB;
					}
					self.elements['sel'+index].post = JSON.stringify(post);
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
		url = HOME_URL+'/'+url;
		if (el.history&&el.history==1) window.history.pushState(el, '', url);
		$.ajax({
			url: url,
			data: post,
			method: 'POST',
			dataType: "json",
			success: function (data) {
				APPLICATION.tryLoadPage = 0;
				if ($('.wrapper_preload').length > 0) {
					if ($('#tbar').length>0){
						$('#tbar, #lbar').css('display','block');
					}
					$('.wrapper_preload').remove();
					self.responseJob(data);
					self.rightClickMenu();
				}
				else
				self.responseJob(data);
			},
			error: function (response) {
				if (APPLICATION.tryLoadPage < 3) {
					APPLICATION.tryLoadPage++;
					setTimeout(function () {
						self.sendRequest(el);
					}, 2000);
				} else {
					if ($('.wrapper_preload').length > 0) location.replace(url);
					else if (url !== HOME_URL+'/login') self.showNotification({
						type: "danger",
						"text": LANG.page_load_error + '<br>URL: ' + url
					});
				}
			}
		});
		return false;
	},
	responseJob: function (el) {
		var self = this;

		$.each(el, function (i, v) {
			console.log(v);
            if (v.action=='update') self.updateElement(v);
            if (v.action=='add') self.addElement(v);
            if (v.action=='hide') self.hideElement(v);
            if (v.action=='delete') self.deleteElement(v);
            if (v.action=='reset') self.resetTimer(v);
            if (v.action=='animate') self.animateElement(v);
            if (v.action=='animateCss') self.animateElementCSS(v);
            if (v.action=='css') self.cssElement(v);
            if (v.action=='load') self.loadPage(v);
            if (v.action=='modal') self.showModal(v);
            if (v.action=='notification') self.showNotification(v);
            if (v.action=='addclass') self.aClass(v);
            if (v.action=='setValue') self.setVal(v);
			if (v.action=='redirect') window.location.href = v.href;

			if (i == el.length - 1) {
				self.removeAttributes();
				self.setTimers();
			}
		});
	},
	setVal: function (el) {
		$(el.target).val(el.val);
	},
    aClass: function (el) {
        if (el.rt) $(el.target).removeClass(el.rt);
        $(el.target).addClass(el.class);
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
    showModal: function (el) {
		console.log('HERE');
        var self = this;
        if($('modal').length>0&&self.modalWindowOnly) return ;
        if($('modal').length>0&&el.delPrev) $('modal').remove();
        if(el.onlyThis) self.modalWindowOnly = true;
        if (el.js) $.getScript(el.js, function(data) {});
        html = "<modal";
        if (el.modal&&!el.effect) html+=" style='"+el.modal+"'";
        if (!el.modal&&el.effect) html+=" style='display:inline;'";
        if (el.modal&&el.effect) html+=" style='display:inline;"+el.modal+"'";
        if (el.class) html+=" class='"+el.class+"'";
        html+=">\n";
        if(el.notClosed) html+="<background></background>\n";
        else html+="<background onclick='APPLICATION.removeModal(this)'></background>\n";


        html+="<content";
        if (el.title&&el.style) el.style+= "padding-top:calc(3em + 20px);";
        if (el.title&&!el.style) el.style= "padding-top:calc(3em + 20px);";
        if (el.style) html+=" style='"+el.style+"'";

        html+=">"+el.html;
        html+="</content>\n";
        if(el.title) html+="<top>"+el.title+"</top>\n";
        html+="</modal>";
        $('body').append(html);
        if (el.effect) $('modal:last-child').animateCss(el.effect);
        else $('modal:last-child').fadeIn(300);
        if (el.textEffect) setTimeout(function () {
            $('modal:last-child content').css('display','block');
            $('modal:last-child content').animateCss(el.textEffect);
        },500);
		if(!el.notClosed)self.getEsc();
    },
    showNotification: function (el) {
        var self = this;
        if($('notification').length>0){
            self.deleteElement({target: "notification"});
            clearTimeout(self.notificationTimer);
            self.notificationTimer = 0;
        }

        html = '<notification class="'+el.type+'"';
        if (el.css) html+=' style="'+el.css+'"';
        html+='>';
        if(el.title) html+='<title>'+el.title+'</title>';
        if(el.text) html+='<text>'+el.text+'</text>';
        html+='</notification>';

        $('body').append(html);
        $('notification').animateCss('fadeInRight');
        if (!el.time)  el.time = 4;

        self.notificationTimer = setTimeout(function(){
            clearTimeout(self.notificationTimer);
            self.notificationTimer = 0;
            $('notification').animateCss('fadeOutRight');
            setTimeout(function () {
                self.deleteElement({target: "notification"});
            },500);
        },el.time*1000);

    },
	cssElement: function (el) {
		$(el.target).css(el.css);
	},
	preloader: function () {
		var self = this;
		self.sendRequest({controller: window.location.pathname});
	},
	loadPage: function (el) {
		var self = this;
		if (typeof self.APPS.timers !== 'undefined') {
			for(k=0;k<self.APPS.timers;k++)
				clearInterval(self.APPS.timers[k]);
			delete self.APPS.timers;
		}
		delete self.APPS;
		self.APPS = {};
		if (el.js) $.getScript(el.js, function (data) {
		});
		if (el.title) $('head title').html(el.title);
		if ($(el.target).length==0) {
			$('body').append(el.html);
		}else
		$(el.target).html(el.html);
	},
    removeModal: function (el) {
        $($(el).parents('modal')).remove();
    },
    getEsc: function () {
        $(document).on('keyup keydown',function(e) {
            if (e.keyCode == 27 &&$('modal').length>0) {
                $('modal:last-child').remove();
            }

        });
    },
	rightClickMenu: function () {
		var self = this;
		if (document.addEventListener) {
			document.addEventListener('contextmenu', function (e) {
				if ($('.rightClickMenu').length > 0) {
					self.cssElement({
						target: ".rightClickMenu",
						css: {
							display: "block",
							left: e.x + "px",
							top: e.y + "px"
						}
					});
					e.preventDefault();
				}
			}, false);
		}

		$(document).on('click', function () {
			$('.rightClickMenu').css('display','none');
		});
	}
};

$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});
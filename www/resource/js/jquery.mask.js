$.mask = {
	obj: null,
	showObj: null,
	
	options: {
		popupLayer: null,
		popupLayerClass: 'popupLayer',
		popupLayerId: 'jquery-extend-mask-inner'
	},
	show: function(obj,func) {
		if (obj) {
			this.obj = $(obj);
			this.showObj = this.obj.clone(true);
			this.pop(func);
		}
		//加载遮罩
		this.loadOverlay();
	},
	
	pop: function(func) {
		
		//初始化最外层容器
		this.popupLayer?this.popupLayer.remove():null;
		this.popupLayer = $(document.createElement("div")).addClass(this.options.popupLayerClass).attr('id',this.options.popupLayerId).css({display:'none'});   
		this.popupLayer.append(this.showObj.css({opacity:1}).show()).appendTo($(document.body));
		this.popupLayer.css({position:"absolute",'z-index':99,width:this.showObj.width() + 'px',height:this.showObj.height() + 'px'});
		
		this.popupLayer.fadeIn('fast',func)
		var left = ($(document).width() - this.showObj.width())/2;
		console.log(document.documentElement.clientHeight - this.showObj.height());
		var top = (document.documentElement.clientHeight - this.showObj.height())/2 + $(document).scrollTop();
		this.setPosition(left,top);
	},
	
	close: function(func) {
		func = func ? func : function(){};
		this.popupLayer?this.popupLayer.remove():null;
		if (this.overlay) {
			this.overlay.fadeOut('fast',function(){
				func();
			});
		} else if (func){
			func()
		}
	},
	
	setPosition:function(left,top){          //通过传入的参数值改变弹出层的位置
		this.popupLayer.css({left:left,top:top});
	},
	
	loadOverlay: function(){                //加载遮罩
		pageWidth = ($.browser.version=="6.0")?$(document).width()-21:$(document).width();
		this.overlay?this.overlay.remove():null;
		this.overlay = $(document.createElement("div"));
		
		this.overlay.css({position:"absolute","z-index":98,left:0,top:0,zoom:1,display:"none",width:pageWidth,height:$(document).height()}).appendTo($(document.body)).append("<div style='position:absolute;z-index:2;width:100%;height:100%;left:0;top:0;opacity:0.3;filter:Alpha(opacity=30);background:#000'></div><iframe frameborder='0' border='0' style='width:100%;height:100%;position:absolute;z-index:1;left:0;top:0;filter:Alpha(opacity=0);'></iframe>")
		this.overlay.fadeIn('fast');
	}
	
	
};


$.fn.float = function(obj) {
	var floatObj = $(this);
	var showObj = $(obj);
	var mouseObj;
	floatObj.addClass('js-mask-float-tmp');
	showObj.addClass('js-mask-float-tmp');
	
	showObj.fadeIn('fast');
	if (!window.isMove) {
		$('body').bind('mousemove',function(e){
			mouseObj = $(e.target);
			window.isMove = true;
		});
	}
	var doHide = function() {
		if (!mouseObj || !mouseObj.closest('.js-mask-float-tmp').length) {
			showObj.fadeOut('fast');
			$('body').unbind('mousemove');
			floatObj.removeClass('js-mask-float-tmp');
			showObj.removeClass('js-mask-float-tmp');
			window.isMove = false;
		}
		else {
			setTimeout(function(){
				doHide();
			}, 500)
		}
	}
	
	setTimeout(function(){
		doHide();
	}, 1500)
}


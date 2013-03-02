$.mask = {};
$.mask.id = 'box-mask-show';
$.alert = function(title,content) {
    if (!document.getElementById($.mask.id)) {
        //创建html结构并赋id以及class		
        $.mask.obj = document.createElement("div");


        var headHtml = '<div id="box-mask-show_head" class="Boxheader"><div id="box-mask-showheaderL" class="headerL" style="width: 600px;"><span style="height: 46px;float: left;line-height:46px;font-weight:800;">账号注册</span><span id="box-mask-showcloseBtn" onclick="javascript:$.mask.close();" class="close"></span></div><div class="headerR"></div></div>';
        var obdyHtml = '<div id="box-mask-show_body" class="Boxbody"><div id="box-mask-showBodyL" class="BodyL" style="height: 400px; width: 600px;">'+content+'</div><div id="box-mask-showBodyR" class="BodyR" style="height: 420px;"></div></div>';
        var footer = '<div id="box-mask-show_footer" class="Boxfooter"><div id="box-mask-showFooterL" class="FooterL" style="width: 600px;"><input type="button" id="msg3cancel" class="btn" onclick="javascript:$.mask.close();" alt="Cancel"></div><div class="FooterR"></div></div>';
        $.mask.obj.innerHTML = '<div id="box-mask-content" class="lightBox">' +headHtml + obdyHtml + footer + '</div>';
        
        document.body.appendChild($.mask.obj);
        var W = $(content).width();
        var H = $(content).height();
        var objBodyL = document.getElementById('box-mask-showBodyL');
        var objBodyR = document.getElementById('box-mask-showBodyR');
        var objHead = document.getElementById('box-mask-show_head');
        objBodyL.style.height = H + "px";
        objBodyL.style.width = W + "px";
        document.getElementById('box-mask-showFooterL').style.width = document.getElementById('box-mask-showheaderL').style.width = W + "px";
        objBodyR.style.height = objBodyL.clientHeight + "px";
        $.mask.obj.style.cssText += ";position:absolute;left:50%;top:50%;z-index:900;";
        $.mask.obj.style.marginLeft = -$.mask.obj.scrollWidth / 2 + "px";
        $.mask.obj.style.marginTop = -$.mask.obj.scrollHeight / 2 + "px";
        //document.body.style.cssText += "height:100%;overflow:hidden;";
        var mask = 1;//是否创建遮罩层
        if (mask) {
            $.mask.objMask = document.createElement("div");
            $.mask.objMask.id = "Mask";
            $.mask.objMask.className = "BoxMask";
            document.body.appendChild($.mask.objMask);
            $.mask.objMask.style.cssText += ";position:absolute;z-index:800;";
            $.mask.objMask.style.height = document.documentElement.scrollHeight + document.documentElement.scrollTop + "px";
        }
        //拖动功能
        var w = $.mask.obj.scrollWidth, h = $.mask.obj.scrollHeight;
        var iWidth = document.documentElement.clientWidth;
        var iHeight = document.documentElement.clientHeight;
        var moveX = 0, moveY = 0, moveTop = 0, moveLeft = 0, moveable = false;
        objHead.onmousedown = function(e) {
            moveable = true;
            e = window.event ? window.event : e;
            moveX = e.clientX - $.mask.obj.offsetLeft;
            moveY = e.clientY - $.mask.obj.offsetTop;
            $.mask.obj.style.zIndex++;
            document.onmousemove = function(e) {
                if (moveable) {
                    e = window.event ? window.event : e;
                    var x = e.clientX - moveX;
                    var y = e.clientY - moveY;
                    if (x > 0 && (x + w < iWidth) && y > 0 && (y + h < iHeight)) {
                        $.mask.obj.style.left = x + "px";
                        $.mask.obj.style.top = y + "px";
                        $.mask.obj.style.margin = "auto";
                    }
                }
            }
            document.onmouseup = function() {
                moveable = false;
            };
        }
    } else
        (alert("has been opened!"));
}

$.confirm = function(title,content,fun1,fun2) {
    if (!fun1) {
        fun1 = function() {
            $.mask.close();
        }
    }
    if (!fun2) {
        fun2 = function() {
            $.mask.close();
        }
    }
    if (!document.getElementById($.mask.id)) {
        //创建html结构并赋id以及class
        $.mask.obj = document.createElement("div");


        var headHtml = '<div id="box-mask-show_head" class="Boxheader"><div id="box-mask-showheaderL" class="headerL" style="width: 600px;"><span style="height: 46px;float: left;line-height:46px;font-weight:800;">账号注册</span><span id="box-mask-showcloseBtn" class="close"></span></div><div class="headerR"></div></div>';
        var obdyHtml = '<div id="box-mask-show_body" class="Boxbody"><div id="box-mask-showBodyL" class="BodyL" style="height: 400px; width: 600px;">'+content+'</div><div id="box-mask-showBodyR" class="BodyR" style="height: 420px;"></div></div>';
        var footer = '<div id="box-mask-show_footer" class="Boxfooter"><div id="box-mask-showFooterL" class="FooterL" style="width: 600px;"><input type="button" class="btn" id="box-mask-btn-cancel" alt="Cancel"><input type="button" class="btn confirm" id="box-mask-btn-confirm" alt="Cancel"></div><div class="FooterR"></div></div>';
        $.mask.obj.innerHTML = '<div id="box-mask-content" class="lightBox">' +headHtml + obdyHtml + footer + '</div>';
        document.body.appendChild($.mask.obj);
        $('#box-mask-btn-confirm').click(function(){
            fun1();
        })
        $('#box-mask-btn-cancel').click(function(){
            fun2();
        })

        $('#box-mask-showcloseBtn').click(function(){
            fun2();
        })
        var W = $(content).width();
        var H = $(content).height();
        var objBodyL = document.getElementById('box-mask-showBodyL');
        var objBodyR = document.getElementById('box-mask-showBodyR');
        var objHead = document.getElementById('box-mask-show_head');
        objBodyL.style.height = H + "px";
        objBodyL.style.width = W + "px";
        document.getElementById('box-mask-showFooterL').style.width = document.getElementById('box-mask-showheaderL').style.width = W + "px";
        objBodyR.style.height = objBodyL.clientHeight + "px";
        $.mask.obj.style.cssText += ";position:absolute;left:50%;top:50%;z-index:900;";
        $.mask.obj.style.marginLeft = -$.mask.obj.scrollWidth / 2 + "px";
        $.mask.obj.style.marginTop = -$.mask.obj.scrollHeight / 2 + "px";
        //document.body.style.cssText += "height:100%;overflow:hidden;";
        var mask = 1;//是否创建遮罩层
        if (mask) {
            $.mask.objMask = document.createElement("div");
            $.mask.objMask.id = "Mask";
            $.mask.objMask.className = "BoxMask";
            document.body.appendChild($.mask.objMask);
            $.mask.objMask.style.cssText += ";position:absolute;z-index:800;";
            $.mask.objMask.style.height = document.documentElement.scrollHeight + document.documentElement.scrollTop + "px";
        }
        //拖动功能
        var w = $.mask.obj.scrollWidth, h = $.mask.obj.scrollHeight;
        var iWidth = document.documentElement.clientWidth;
        var iHeight = document.documentElement.clientHeight;
        var moveX = 0, moveY = 0, moveTop = 0, moveLeft = 0, moveable = false;
        objHead.onmousedown = function(e) {
            moveable = true;
            e = window.event ? window.event : e;
            moveX = e.clientX - $.mask.obj.offsetLeft;
            moveY = e.clientY - $.mask.obj.offsetTop;
            $.mask.obj.style.zIndex++;
            document.onmousemove = function(e) {
                if (moveable) {
                    e = window.event ? window.event : e;
                    var x = e.clientX - moveX;
                    var y = e.clientY - moveY;
                    if (x > 0 && (x + w < iWidth) && y > 0 && (y + h < iHeight)) {
                        $.mask.obj.style.left = x + "px";
                        $.mask.obj.style.top = y + "px";
                        $.mask.obj.style.margin = "auto";
                    }
                }
            }
            document.onmouseup = function() {
                moveable = false;
            };
        }
    } else
        (alert("has been opened!"));

}

$.mask.close = function() {
    document.body.removeChild($.mask.obj);
    if ($.mask.objMask) {
        document.body.removeChild($.mask.objMask)
    }
}
$.mask.show = function() {

}
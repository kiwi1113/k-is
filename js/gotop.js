// 回到頂端 gotop
(function($){
    $("body").append("<img id='goTopButton' style='display:none;z-index:5;cursor:pointer;top: 100px;right:100px;position: fixed;' title='回到頂端'>");
    var img="./images/gotop.png",
    location = 9/10,      // 按鈕出現在螢幕的高度
    right = 30,         // 距離右邊的px值
    opacity = 0.6,      // 透明度
    speed = 500,       // 捲動速度
    $button = $("#goTopButton"),
    $body = $(document),    // 網頁內容
    $win = $(window);      // 視窗
    $button.attr("src", img);
    $button.on({
      mouseover: function(){$button.css("opacity",1);},
      mouseout: function(){$button.css("opacity",opacity);},
      click: function(){
        css={"opacity":"0.5","transition":"transform 1s ease 0s"};
        $button.css(css);
        $("html,body").animate({scrollTop:0},speed);}
    })
    $win.on({
      scroll: function(){goTopMove();},
      resize: function(){goTopMove();}
    })
    window.goTopMove = function(){
      var scrollH = $body.scrollTop(),
        winH = $win.height(),
        css = { "top":winH * location +"px","position":"fixed","right": right,"opacity":opacity};
      if (scrollH >20){
        $button.css(css);
        $button.fadeIn("slow");
      } else{
        $button.fadeOut("slow");
        if($button.css("transform")!="none"){
          css = {"transform" :"","transition":""};
          $button.css(css);
        }
      }
    };
  })(jQuery);
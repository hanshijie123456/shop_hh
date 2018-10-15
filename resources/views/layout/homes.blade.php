<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <title>@yield('title')</title>

        <link href="/homes/AmazeUI-2.4.2/assets/css/amazeui.css" rel="stylesheet" type="text/css" />
        <link href="/homes/AmazeUI-2.4.2/assets/css/admin.css" rel="stylesheet" type="text/css" />

        <link href="/homes/basic/css/demo.css" rel="stylesheet" type="text/css" />

        <link href="/homes/css/hmstyle.css" rel="stylesheet" type="text/css"/>
        <link href="/homes/css/skin.css" rel="stylesheet" type="text/css" />
        <script src="/homes/AmazeUI-2.4.2/assets/js/jquery.min.js"></script>
        <script src="/homes/AmazeUI-2.4.2/assets/js/amazeui.min.js"></script>

    </head>

    <body>
        <div class="hmtop">
            <!--顶部导航条 -->
            <div class="am-container header">
                <ul class="message-l">
                    <div class="topMessage">
                        <div class="menu-hd">
                            <a href="#" target="_top" class="h">亲，请登录</a>
                            <a href="#" target="_top">免费注册</a>
                        </div>
                    </div>
                </ul>
                <ul class="message-r">
                    <div class="topMessage home">
                        <div class="menu-hd"><a href="#" target="_top" class="h">商城首页</a></div>
                    </div>
                    <div class="topMessage my-shangcheng">
                        <div class="menu-hd MyShangcheng"><a href="/home/gren" target="_top"><i class="am-icon-user am-icon-fw"></i>个人中心</a></div>
                    </div>
                    <div class="topMessage mini-cart">
                        <div class="menu-hd"><a id="mc-menu-hd" href="#" target="_top"><i class="am-icon-shopping-cart  am-icon-fw"></i><span>购物车</span><strong id="J_MiniCartNum" class="h">0</strong></a></div>
                    </div>
                    <div class="topMessage favorite">
                        <div class="menu-hd"><a href="#" target="_top"><i class="am-icon-heart am-icon-fw"></i><span>收藏夹</span></a></div>
                </ul>
                </div>

                <!--悬浮搜索框-->

                <div class="nav white">
                    <div class="logo"><img src="/homes/images/logo.png" /></div>
                    <div class="logoBig">
                        <li><img src="/homes/images/logobig.png" /></li>
                    </div>

                    <div class="search-bar pr">
                        <a name="index_none_header_sysc" href="#"></a>
                        <form>
                            <input id="searchInput" name="index_none_header_sysc" type="text" placeholder="搜索" autocomplete="off">
                            <input id="ai-topsearch" class="submit am-btn" value="搜索" index="1" type="submit">
                        </form>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
           
            <div class="shopNav">
                <div class="slideall">
                    
                    <div class="long-title"><span class="all-goods">全部分类</span></div>
                    <div class="nav-cont">
                        <ul>
                            <li class="index"><a href="/">首页</a></li>
                            <li class="qc"><a href="#">闪购</a></li>
                            <li class="qc"><a href="#">限时抢</a></li>
                            <li class="qc"><a href="#">团购</a></li>
                            <li class="qc last"><a href="#">大包装</a></li>
                        </ul>
                        <div class="nav-extra">
                            <i class="am-icon-user-secret am-icon-md nav-user"></i><b></b>我的福利
                            <i class="am-icon-angle-right" style="padding-left: 10px;"></i>
                        </div>
                    </div>
                    @section('content')



                 @show                  
        <script>
        /*setTimeout(function(){

            $('.mws-form-message').fadeOut(2000);

        },5000)*/

        $('.info').delay(3000).fadeOut(2000);

        $('.warning').delay(3000).fadeOut(2000);
    </script>


   @section('js')


   @show

</body>
</html>        
                
<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:43:"./template/mobile/new2/goods/goodsInfo.html";i:1503541950;s:41:"./template/mobile/new2/public/header.html";i:1503541953;s:42:"./template/mobile/new2/public/top_nav.html";i:1503541953;s:43:"./template/mobile/new2/public/wx_share.html";i:1503541953;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>商品详情--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="__STATIC__/css/style.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer.js"  type="text/javascript" ></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body class="">

<div class="he_sustain">
    <div class="classreturn loginsignup detail">
        <div class="content">
            <div class="ds-in-bl return">
                <a href="javascript:history.back(-1)"><img src="__STATIC__/images/return.png" alt="返回"></a>
            </div>
            <div class="ds-in-bl search center">
                <span class="sxp">商品</span>
                <span>详情</span>
                <span>评论</span>
            </div>
            <div class="ds-in-bl menu">
                <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
            </div>
        </div>
    </div>
</div>

<!--顶部隐藏菜单-s-->
<div class="flool tpnavf">
    <div class="footer">
        <ul>
            <li>
                <a class="yello" href="<?php echo U('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Cart/cart'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--顶部隐藏菜单-e-->
<!--商品抢购 start-->
<!--商品s-->
<div class="xq_details">
    <div class="banner ban1 detailban">
        <div class="mslide" id="slideTpshop">
            <ul>
                <!--图片-s-->
                <?php if(is_array($goods_images_list) || $goods_images_list instanceof \think\Collection || $goods_images_list instanceof \think\Paginator): if( count($goods_images_list)==0 ) : echo "" ;else: foreach($goods_images_list as $key=>$pic): ?>
                    <li><a href="javascript:void(0)"><img src="<?php echo $pic[image_url]; ?>" alt=""></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <!--图片-e-->
            </ul>
        </div>
    </div>
    <div class="de_font p">
        <div class="thirty">
            <div class="fl">
                <span class="similar-product-text"><?php echo $goods['goods_name']; ?></span>
            </div>
            <div class="keep fr">
                <a href="javascript:collect_goods(<?php echo $goods['goods_id']; ?>);" id="favorite_add">
                    <i class=" <?php if($collect > 0): ?>red<?php endif; ?>"></i>
                    <span>收藏</span>
                </a>
            </div>
            <div class="scunde p">
                <p class="red" id="price">￥<?php echo $goods['shop_price']; ?></p>
                <p>市场价格：<span class="linethr"><?php echo $goods['market_price']; ?></span></p>
                <p>销量：<span><?php echo $goods['sales_sum']; ?></span>
                    <span class="kc">当前库存：<span>
                        <?php if(empty($goods['flash_sale']) || (($goods['flash_sale'] instanceof \think\Collection || $goods['flash_sale'] instanceof \think\Paginator ) && $goods['flash_sale']->isEmpty())): ?><?php echo $goods['store_count']; else: ?><?php echo $goods['flash_sale']['goods_num']-$goods['flash_sale']['buy_num']; endif; ?>
                    </span>
                    </span>
                </p>
            </div>
        </div>
    </div>
    <div class="floor list7 detailsfloo">
        <div class="myorder p">
            <div class="content30">
                <a href="javascript:void(0)" onclick="locationaddress(this);">
                    <script type="text/javascript">
                        function locationaddress(e){
                            $('.container').animate({width: '14.4rem', opacity: 'show'}, 'normal',function(){
                                $('.container').show();
                            });
                            if(!$('.container').is(":hidden")){
                                $('body').css('overflow','hidden')
                                cover();
                                $('.mask-filter-div').css('z-index','9999');
                            }
                        }
                        function closelocation(){
                            var province_div = $('.province-list');
                            var city_div = $('.city-list');
                            var area_div = $('.area-list');
                            if(area_div.is(":hidden") == false){
                                area_div.hide();
                                city_div.show();
                                province_div.hide();
                                return;
                            }
                            if(city_div.is(":hidden") == false){
                                area_div.hide();
                                city_div.hide();
                                province_div.show();
                                return;
                            }
                            if(province_div.is(":hidden") == false){
                                area_div.hide();
                                city_div.hide();
                                $('.container').animate({width: '0', opacity: 'show'}, 'normal',function(){
                                    $('.container').hide();
                                });
                                undercover();
                                $('.mask-filter-div').css('z-index','inherit');
                                return;
                            }
                        }
                    </script>
                    <div class="order">
                        <div class="fl">
                            <span class="firde">所在地区</span>
                            <span id="address"></span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!--配送至-s-->
        <div class="container" >
            <div class="city">
                <div class="screen_wi_loc">
                    <div class="classreturn loginsignup">
                        <div class="content">
                            <div class="ds-in-bl return seac_retu">
                                <a href="javascript:void(0);" onclick="closelocation();"><img src="__STATIC__/images/return.png" alt="返回"></a>
                            </div>
                            <div class="ds-in-bl search center">
                                <span class="sx_jsxz">配送至</span>
                            </div>
                            <div class="ds-in-bl suce_ok">
                                <a href="javascript:void(0);">&nbsp;</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="province-list"></div>
                <div class="city-list" style="display:none"></div>
                <div class="area-list" style="display:none"></div>
            </div>
        </div>
        <!--配送至-e-->

        <!--运费-s-->
        <div class="myorder p">
            <div class="content30">
                <a class="remain" href="javascript:void(0);">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">运费信息</span>
                            <span id="shipping_freight"></span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div id="balance" class="chidno"></div>
        <!--运费-s-->
        <div class="myorder p choise_num">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">已选</span>
                            <span class="sel"></span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="myorder p">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">服务</span>
                            <span>由商城自营发货并提供售后服务</span>
                        </div>
                        <div class="fr">
                            <i class="Mright gt"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="myhearders myorder">
            <div class="scgz descgz">
                <ul>
                    <li>
                        <a href="javascript:void(0);">
                            <img src="__STATIC__/images/hdfk.png">
                            <p>货到付款</p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <img src="__STATIC__/images/qttk.png">
                            <p>七天退款</p>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <img src="__STATIC__/images/ksd.png">
                            <p>极速达</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="myorder p seedeadei">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde red">查看商品详情</span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="myorder p tbv">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">用户评价</span>
                            <span>好评率<i>
                                <?php if(!empty($commentStatistics['c1']) and !empty($commentStatistics['c0'])): ?>
                                 <?php echo round($commentStatistics['c1']/$commentStatistics['c0'],3)*100; ?>%
                                <?php else: ?>0<?php endif; ?>
                            </i></span>
                        </div>
                        <div class="fr">
                            <span><i><?php echo $commentStatistics['c0']; ?></i>人评论</span>
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="recommed p">
        <h2>为您推荐</h2>
        <div class="floor guesslike">
            <div class="likeshop">
                <ul>
                    <!--商品推荐-->
                    <?php
                                   
                                $md5_key = md5("SELECT * FROM __PREFIX__goods WHERE ( is_recommend=1 and is_on_sale=1 ) ORDER BY goods_id DESC LIMIT 0,4 ");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("SELECT * FROM __PREFIX__goods WHERE ( is_recommend=1 and is_on_sale=1 ) ORDER BY goods_id DESC LIMIT 0,4 "); 
                                    S("sql_".$md5_key,$sql_result_v,86400);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
                        <li>
                            <a href="<?php echo U('Goods/goodsInfo',array('id'=>$v[goods_id])); ?>">
                                <div class="similer-product">
                                    <img src="<?php echo goods_thum_images($v['goods_id'],400,400); ?>">
                                    <span class="similar-product-text"><?php echo $v[goods_name]; ?></span>
                                    <span class="similar-product-price">
                                        ¥<span class="big-price"><?php echo $v[shop_price]; ?></span>
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<!--添加购物车JS-->
<script src="__PUBLIC__/js/mobile_common.js" type="text/javascript" charset="utf-8"></script>
</div>
<!--商品-e-->

<!--详情-s-->
    <div class="xq_details" style="display: none;">
    <div class="spxq-ggcs">
        <ul>
            <li class="red">商品详情</li>
            <li>规格参数</li>
        </ul>
    </div>
    <div class="sg">
        <div class="spxq p">
            <?php echo htmlspecialchars_decode($goods['goods_content']); ?>
        </div>
    </div>
    <div class="sg" style="display: none;">
        <div class="spxq p">
            <table class="de_table" border="1" bordercolor="#cbcbcb" style="border-collapse:collapse;">
                <tr>
                    <th colspan="2">主体</th>
                </tr>
                <?php if(is_array($goods_attr_list) || $goods_attr_list instanceof \think\Collection || $goods_attr_list instanceof \think\Paginator): if( count($goods_attr_list)==0 ) : echo "" ;else: foreach($goods_attr_list as $k=>$v): ?>
                    <tr>
                        <td><?php echo $goods_attribute[$v[attr_id]]; ?></td>
                        <td><?php echo $v[attr_value]; ?></td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>
    </div>
</div>
<!--详情-e-->

<!--评论列表-s-->
    <div class="xq_details" >
    <div class="spxq-ggcs comment_de p"  style="display:none;">
        <ul>
            <!--1 全部 2好评 3 中评 4差评-->
            <li class="red">全部评价 <br /><span ctype="1"><?php echo $commentStatistics['c0']; ?></span></li>
            <li>好评 <br /><span ctype="2"><?php echo $commentStatistics['c1']; ?></span></li>
            <li>中评 <br /><span ctype="3"><?php echo $commentStatistics['c2']; ?></span></li>
            <li>差评 <br /><span ctype="4"><?php echo $commentStatistics['c3']; ?></span></li>
            <li>有图 <br /><span ctype="5"><?php echo $commentStatistics['c4']; ?></span></li>
        </ul>
    </div>
    <!--评论列表-->
    <div class="tab-con-wrapper my_comment_list" > </div>
</div>
<!--评论列表-e-->

<!--底部按钮-s-->
    <div class="podee">
    <div class="cart-concert-btm p">
        <div class="fl">
            <ul>
                <li>
                    <!--<a href="tencent://message/?uin=<?php echo $tpshop_config['shop_info_qq']; ?>&Site=TPshop商城&Menu=yes">-->
                    <a href="tel:<?php echo $tpshop_config['shop_info_phone']; ?>">
                        <i></i>
                        <p>客服</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Mobile/Cart/cart'); ?>" >
                        <span id="tp_cart_info"></span>
                        <i class="gwc"></i>
                        <p>购物车</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="fr">
            <ul>
                <li class="o">
                    <a class="pb_plusshopcar button active_button " href="javascript:void(0);" onClick="AjaxAddCart(<?php echo $goods['goods_id']; ?>,1,0);"> 加入购物车</a>
                </li>
                <li class="r">
                    <a style="display:block;" href="javascript:void(0);"  onclick="AjaxAddCart(<?php echo $goods['goods_id']; ?>,1,1);">立即购买</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--底部按钮-e-->

<!--点赞弹窗-s-->
<div class="alert">
    <img src="__STATIC__/images/hh.png"/>
    <p>您已经赞过了！</p>
</div>
<!--点赞弹窗-e-->

<!--选择属性的弹窗-s-->
<form name="buy_goods_form" method="post" id="buy_goods_form" >
    <div class="choose_shop_aready p">
        <!--商品信息-s-->
        <div class="shop-top-under p">
            <div class="maleri30">
                <div class="shopprice">
                    <div class="img_or fl"><img id="zoomimg" src="<?php echo $goods['original_img']; ?>"></div>
                    <div class="fon_or fl">
                        <h2 class="similar-product-text"><?php echo $goods['goods_name']; ?></h2>
                        <input type="hidden" id="goods_name" name="goods_id" value="<?php echo $goods['goods_id']; ?>">
                        <div class="price_or" id="goods_price"><span>￥</span><span><?php echo $goods['shop_price']; ?></span></div>
                        <div class="dqkc_or"><span>剩余库存：</span><span id="store_count"><?php echo $goods['store_count']; ?></span></div>
                    </div>
                    <div class="price_or fr">
                        <i class="xxgro"></i>
                    </div>
                </div>
            </div>
        </div>
        <!--商品信息-e-->
        <div class="shop-top-under p">
            <div class="maleri30">
                <div class="shulges p">
                    <p>数量</p>
                    <!--选择数量-->
                    <div class="plus">
                        <span class="mp_minous" onclick="altergoodsnum(-1)">-</span>
                                <span class="mp_mp">
                        <input type="text" class="num" id="number" residuenum="<?php echo $goods['store_count']; ?>" name="goods_num" value="1" max="" onblur="altergoodsnum(0)">
                                </span>
                        <span class="mp_plus" onclick="altergoodsnum(1)">+</span>
                    </div>
                    <script>
                        $('#number').val(1);
                    </script>
                </div>
                <?php if(empty($goods['flash_sale']) || (($goods['flash_sale'] instanceof \think\Collection || $goods['flash_sale'] instanceof \think\Paginator ) && $goods['flash_sale']->isEmpty())): if($filter_spec != ''): if(is_array($filter_spec) || $filter_spec instanceof \think\Collection || $filter_spec instanceof \think\Paginator): if( count($filter_spec)==0 ) : echo "" ;else: foreach($filter_spec as $key=>$spec): ?>
                            <div class="shulges p choicsel" >
                                <p><?php echo $key; ?></p>
                                <!-------商品属性值-s------->
                                <?php if(is_array($spec) || $spec instanceof \think\Collection || $spec instanceof \think\Paginator): if( count($spec)==0 ) : echo "" ;else: foreach($spec as $k2=>$v2): ?>
                                    <div class="plus choic-sel">
                                        <a  href="javascript:;" title="<?php echo $v2[item]; ?>" onclick="switch_spec(this);<?php if(!empty($v2[src])): ?> $('#zoomimg').attr('src','<?php echo $v2[src]; ?>')<?php endif; ?>"  <?php if($k2 == 0): ?>class="hover"<?php endif; ?>>
                                        <input type="radio" style="display:none;" name="goods_spec[<?php echo $key; ?>]" value="<?php echo $v2[item_id]; ?>" <?php if($k2 == 0): ?>checked="checked"<?php endif; ?>/><?php echo $v2[item]; ?>
                                        </a>
                                    </div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <!-------商品属性值-e-------->
                            </div>
                        <?php endforeach; endif; else: echo "" ;endif; endif; endif; ?>
            </div>
        </div>
        <div class="plusshopcar-buy p">
            <a class="pb_plusshopcar button active_button " href="javascript:void(0);" onClick="AjaxAddCart(<?php echo $goods['goods_id']; ?>,1,0);">加入购物车</a>
            <a class="pb_buy" href="javascript:void(0);"  onclick="AjaxAddCart(<?php echo $goods['goods_id']; ?>,1,1);">立即购买 </a>
        </div>
    </div>
</form>
<!--选择属性的弹窗-e-->

<div class="mask-filter-div" style="display: none;"></div>
<script type="text/javascript" src="__STATIC__/js/mobile-location.js"></script>
<script type="text/javascript">
    /**
     * 点击收藏商品
     */
    function collect_goods(goods_id){
        $.ajax({
            type : "GET",
            dataType: "json",
            url:"/index.php?m=Home&c=goods&a=collect_goods&goods_id="+goods_id,//+tab,
            success: function(data){
                layer.open({content:data.msg, time:2});
                if(data.status == '1'){
                    //收藏点亮
                    $('.de_font .keep').find('i').addClass('red');
                }
            }
        });
    }

    //将选择的属性添加到已选
    function sel(){
        var residuenum = parseInt($('.num').attr('residuenum'));
        var title ='';
        $('.choicsel').find('a').each(function(i,o){   //获取已选择的属性，规格
            if ($(o).hasClass('red')) {
                title += $(o).attr('title')+'&nbsp;&nbsp;';
            }
        })
        var num = $('.num').val();
        if(num > residuenum ){
            layer.open({content:'当前商品最多可购买'+residuenum+'件',time:2})
            num = residuenum;
        }
        var sel = title+'&nbsp;&nbsp;'+num+'件';
        $('.sel').html(sel);
    }

    /**
     * 加减数量
     * n 点击一次要改变多少
     * maxnum 允许的最大数量(库存)
     * number ，input的id
     */
    function altergoodsnum(n){
        var num = parseInt($('#number').val());
        var maxnum = parseInt($('#number').attr('max'));
        num += n;
        num <= 0 ? num = 1 :  num;
        if(num >= maxnum){
            $(this).addClass('no-mins');
            num = maxnum;
        }
        $('#store_count').text(maxnum-num); //更新库存数量
        $('#number').val(num)
    }
    //页面加载后执行
$(document).ready(function(){
        /**
         * ajax请求购物车列表
         */
        var cart_cn = getCookie('cn');
        if(cart_cn == ''){
            $.ajax({
                type : "GET",
                url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
                success: function(data){
                    cart_cn = getCookie('cn');
                }
            });
        }
        $('#tp_cart_info').html(cart_cn);

        /**
         * 查看商品详情
         */
        $('.seedeadei').click(function(){
            $('.xq_details').eq(0).hide();
            $('.xq_details').eq(1).show();
            $('body').animate({ scrollTop: 0 }, 0);
            $('.detail').find('.center').find('span').eq(1).addClass('sxp');
            $('.detail').find('.center').find('span').eq(0).removeClass('sxp');
        })

        /**
         * 评论
         */
        $('.tbv').click(function(){
            $('.xq_details').eq(0).hide();
            $('.xq_details').eq(2).show();
            $('body').animate({ scrollTop: 0 }, 0);
            $('.detail').find('.center').find('span').eq(2).addClass('sxp');
            $('.detail').find('.center').find('span').eq(0).removeClass('sxp');
            $('.gizle').show();
        })

        /**
         * 加载评论
         */
        commentType = 1; // 评论类型
        ajaxComment(1,1);// ajax 加载评价列表

        /**
         * 加载更多评论
         */
        function ajaxComment(commentType,page){
            $.ajax({
                type : "GET",
                url:"/index.php?m=Mobile&c=goods&a=ajaxComment&goods_id=<?php echo $goods['goods_id']; ?>&commentType="+commentType+"&p="+page,//+tab,
                success: function(data){
                    $(".my_comment_list").empty().append(data);
                }
            });
        }

        //点赞
        function hde(){
            setTimeout(function(){
                $('.alert').hide();
            },1200)
        }

        /**
         * 已选
         */
        $('.choise_num').click(function(){
            cover();
            $('.choose_shop_aready').show();
            $('.podee').hide();
        })

        //关闭属性选择
        $('.xxgro').click(function(){
            undercover();
            $('.choose_shop_aready').hide();
            $('.podee').show();
            sel();
        })

        /**
         * 规格选择
         */
        $('.choic-sel a').click(function(){
            //切换选择
            $(this).addClass('red').parent().siblings().find('a').removeClass('red');
        });
        $('#buy_goods_form .choicsel').each(function() {
            // 先默认每组的第一个单选按钮添加样式
            $(this).find('a').first().addClass('red');
            sel();
        });

        /**
         * 顶部导航切换
         */
        $('.detail .search span').click(function(){
            $(this).addClass('sxp').siblings().removeClass('sxp');
            var a = $('.detail .search span').index(this);
            $('.xq_details').eq(a).show().siblings('.xq_details').hide();
            $('.xq_details').eq(2).show();
            if($('.detail .search span').eq(2).hasClass('sxp')){
                $('.comment_de').show();
            }else{
                $('.comment_de').hide();
            }
            if($('.detail .search span').eq(1).hasClass('sxp')){
                $('.tab-con-wrapper').hide();
                $('.comment_con').hide();
            }else{
                $('.tab-con-wrapper').show();
                $('.comment_con').show();
            }
        });

        /**
         * 内部导航切换
         */
        $('.spxq-ggcs ul li').click(function(){
            $(this).addClass('red').siblings().removeClass('red');
            var sg = $('.spxq-ggcs ul li').index(this);
            $('.sg').eq(sg).show().siblings('.sg').hide();
            var $commentType= $(this).children('span').attr('ctype');
            //切换到评论按钮才加载评论列表
            if($('.detail .search span').eq(2).hasClass('sxp')){
                ajaxComment($commentType,1);// ajax 加载评价列表
            }
        });

        /**
         * 内部导航随鼠标滑动显示隐藏
         */
        var h1 = $('.detail').height();
        var h2 = $('.detail').height() + $('.spxq-ggcs').height();
        var ss = $(document).scrollTop();//上一次滚轮的高度
        $(window).scroll(function(){
            var s = $(document).scrollTop();////本次滚轮的高度
            if(s< h1){
                $('.spxq-ggcs').removeClass('po-fi');
            }if(s > h1){
                $('.spxq-ggcs').addClass('po-fi');
            }if(s > h2){
                $('.spxq-ggcs').addClass('gizle');
                if(s > ss){
                    $('.spxq-ggcs').removeClass('sabit');
                }else{
                    $('.spxq-ggcs').addClass('sabit');
                }
                ss = s;
            }
        });

        //在已选栏中显示默认选择属性，数量
        sel();

        /**
         * 更新商品价格
         */
        get_goods_price();

});
//完


    function switch_spec(spec)
    {
        $(spec).siblings().removeClass('hover');
        $(spec).addClass('hover');
        $(spec).siblings().children('input').prop('checked',false);
        $(spec).children('input').prop('checked',true);
        //更新商品价格
        get_goods_price();
    }

    function get_goods_price()
    {
        var goods_price = <?php echo $goods['shop_price']; ?>; // 商品起始价
        var store_count = <?php echo $goods['store_count']; ?>; // 商品起始库存
        var spec_goods_price = <?php echo $spec_goods_price; ?>;  // 规格 对应 价格 库存表   //alert(spec_goods_price['28_100']['price']);
        // 优先显示抢购活动库存
        <?php if(!(empty($goods['flash_sale']) || (($goods['flash_sale'] instanceof \think\Collection || $goods['flash_sale'] instanceof \think\Paginator ) && $goods['flash_sale']->isEmpty()))): ?>
             store_count = <?php echo $goods['flash_sale']['goods_num'] - $goods['flash_sale']['buy_num'] - 1; ?>;
            var flash_sale_price = parseFloat("<?php echo $goods['flash_sale']['price']; ?>");
            (flash_sale_price > 0) && (goods_price = flash_sale_price);
            spec_goods_price = null;
        <?php endif; ?>
        // 如果有属性选择项
        if(spec_goods_price != null && spec_goods_price !='')
        {
            goods_spec_arr = new Array();
            $("input[name^='goods_spec']:checked").each(function(){
                goods_spec_arr.push($(this).val());
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
            goods_price = spec_goods_price[spec_key]['price']; // 找到对应规格的价格
            store_count = spec_goods_price[spec_key]['store_count']; // 找到对应规格的库存
        }
        var goods_num = parseInt($("#goods_num").val());
        // 库存不足的情况
        if(goods_num > store_count)
        {
            goods_num = store_count;
            alert('库存仅剩 '+store_count+' 件');
            $("#goods_num").val(goods_num);
        }
        $('#store_count').html(store_count);    //对应规格库存显示出来
        $('#number').attr('max',store_count); //对应规格最大库存
        $("#goods_price").html('<span>￥</span><span>'+goods_price+'</span>'); // 变动价格显示
        $("#price").html('￥'+goods_price+'元'); // 变动价格显示

    }
    function sortNumber(a,b)
    {
        return a - b;
    }
    //运费
    $(function(){
        $('.remain').click(function(){
            $('#balance').toggle(300);
        })
        $('#balance').on('click','a',function(){
            $('#shipping_freight').text($(this).find('span').text());
            $('#balance').toggle(300);
        })
    })
</script>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript">
<?php if(ACTION_NAME == 'goodsInfo'): ?>
   var ShareLink = "http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Mobile&c=Goods&a=goodsInfo&id=<?php echo $goods[goods_id]; ?>"; //默认分享链接
   var ShareImgUrl = "http://<?php echo $_SERVER[HTTP_HOST]; ?><?php echo goods_thum_images($goods[goods_id],400,400); ?>"; // 分享图标
<?php else: ?>
   var ShareLink = "http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Mobile&c=Index&a=index"; //默认分享链接
   var ShareImgUrl = "http://<?php echo $_SERVER[HTTP_HOST]; ?><?php echo $tpshop_config['shop_info_store_logo']; ?>"; //分享图标
<?php endif; ?>

var is_distribut = getCookie('is_distribut'); // 是否分销代理
var user_id = getCookie('user_id'); // 当前用户id
//alert(is_distribut+'=='+user_id);
// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	ShareLink = ShareLink + "&first_leader="+user_id;									
}

$(function() {
	if(isWeiXin() && parseInt(user_id)>0){
		$.ajax({
			type : "POST",
			url:"/index.php?m=Mobile&c=Index&a=ajaxGetWxConfig&t="+Math.random(),
			data:{'askUrl':encodeURIComponent(location.href.split('#')[0])},		
			dataType:'JSON',
			success: function(res)
			{
				//微信配置
				wx.config({
				    debug: false, 
				    appId: res.appId,
				    timestamp: res.timestamp, 
				    nonceStr: res.nonceStr, 
				    signature: res.signature,
				    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
				});
			},
			error:function(){
				return false;
			}
		}); 

		// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
		wx.ready(function(){
		    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareTimeline({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });

		    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareAppMessage({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo $tpshop_config['shop_info_store_desc']; ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });
			// 分享到QQ
			wx.onMenuShareQQ({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo $tpshop_config['shop_info_store_desc']; ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});	
			// 分享到QQ空间
			wx.onMenuShareQZone({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo $tpshop_config['shop_info_store_desc']; ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});

		   <?php if(CONTROLLER_NAME == 'User'): ?> 
				wx.hideOptionMenu();  // 用户中心 隐藏微信菜单
		   <?php endif; ?>	
		});
	}
});

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
</script>
<!--微信关注提醒 start-->
<?php if(\think\Session::get('subscribe') == 0): endif; ?>
<button class="guide" style="display:none;" onclick="follow_wx()">关注公众号</button>
<style type="text/css">
.guide{width:1rem;height:4rem;text-align: center;border-radius: 0.2rem ;font-size:0.5rem;padding:0.2rem 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 0.1rem;bottom: 10rem;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:0.1rem;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 0.2rem;}
</style>
<script type="text/javascript">
  //关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo $wx_qr; ?>" width="100%">',
		style: ''
	});
}
  
$(function(){
	if(isWeiXin()){
		var subscribe = getCookie('subscribe'); // 是否已经关注了微信公众号		
		if(subscribe == 0)
			$('.guide').show();
	}else{
		$('.guide').hide();
	}
})
 
</script> 

<!--微信关注提醒  end-->
</body>
</html>

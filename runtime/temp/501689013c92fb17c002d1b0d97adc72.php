<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:37:"./template/mobile/new2/cart/cart.html";i:1503541949;s:41:"./template/mobile/new2/public/header.html";i:1503541953;s:45:"./template/mobile/new2/public/header_nav.html";i:1503541953;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>购物车--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>购物车</span>
        </div>
        <div class="ds-in-bl menu">
            <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
        </div>
    </div>
</div>
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
                <!--<a href="shopcar.html">-->
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
<?php if(empty($user['user_id'])): ?>
<!--###用户未登录###-->
    <div class="loginlater">
        <img src="__STATIC__/images/small_car.png"/>
        <span>登录后可同步电脑和手机购物车</span>
        <a href="<?php echo U('Mobile/User/loagin'); ?>">登录</a>
    </div>
    <!--购物车有商品-s-->
    <div class="cart_list">
        <form id="cart_form" name="formCart" action="<?php echo U('Mobile/Cart/ajaxCartList'); ?>" method="post">
            <?php echo token(); ?>
        </form>
    </div>
    <!--购物车有商品-e-->

    <!--看看热卖-start-->
    <div class="hotshop seehotsho">
        <div class="thirdlogin">
            <h4>看看热卖</h4>
        </div>
    </div>
    <div class="floor guesslike">
        <div class="likeshop">
            <ul>
                <?php if(is_array($hot_goods) || $hot_goods instanceof \think\Collection || $hot_goods instanceof \think\Paginator): if( count($hot_goods)==0 ) : echo "" ;else: foreach($hot_goods as $key=>$good): ?>
                    <li>
                        <a href="<?php echo U('Mobile/goods/goodsInfo',array('id'=>$good[goods_id])); ?>">
                            <div class="similer-product">
                                <img src="<?php echo goods_thum_images($good[goods_id],200,200); ?>"/>
                                <span class="similar-product-text"><?php echo getsubstr($good[goods_name],0,20); ?></span>
                                <span class="similar-product-price">
                                    ¥<span class="big-price"><?php echo $good[shop_price]; ?></span>
                                    <!--<span class="small-price">.00</span>-->
                                </span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="add">热卖商品实时更新，常回来看看哟~</div>
    </div>
    <!--看看热卖-end-->

<?php else: ?>
<!--###用户已登录###-->
    <!--购物车有商品-s-->
    <div class="cart_list">
        <form id="cart_form" name="formCart" action="<?php echo U('Mobile/Cart/ajaxCartList'); ?>" method="post">
            <?php echo token(); ?>
        </form>
    </div>
    <!--购物车有商品-e-->
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function(){
        ajax_cart_list(); // ajax 请求获取购物车列表
    });

    /**加载购物车商品列表*/
    var before_request = 1; // 上一次请求是否已经有返回来, 有才可以进行下一次请求
    function ajax_cart_list(){
        if(before_request == 0) // 上一次请求没回来 不进行下一次请求
            return false;
        before_request = 0;
        $.ajax({
            type : "POST",
            url:"<?php echo U('Mobile/Cart/ajaxCartList'); ?>",//+tab,
            data : $('#cart_form').serialize(),// 你的formid
            success: function(data){
                $("#cart_form").html('');
                $("#cart_form").append(data);
                before_request = 1;
            }
        });
    }

    /**
     * 购买商品数量加加减减
     * 购买数量 , 购物车id , 库存数量
     */
    function switch_num(num,cart_id,store_count){
        var num2 = parseInt($("input[name='goods_num["+cart_id+"]']").val());
        //加减数量
        num2 += num;
        if(num2 < 1) num2 = 1;  // 保证购买数量不能少于 1
        if(num2 > store_count) { //保证 不超过库存
            layer.open({content:"库存只有 "+store_count+" 件, 你只能买 "+store_count+" 件",time:2})
            num2 = store_count; // 保证购买数量不能多余库存数量
        }
        $("input[name='goods_num["+cart_id+"]']").val(num2);
        ajax_cart_list();
    }

    //删除商品
    function del_cart_goods(goods_id)
    {
        if(!confirm('确定要删除吗?'))
            return false;
        var chk_value = [];
        chk_value.push(goods_id);
        // ajax调用删除
        if(chk_value.length > 0)
            ajax_del_cart(chk_value.join(','));
    }

    // ajax 删除购物车的商品
    function ajax_del_cart(ids)
    {
        $.ajax({
            type : "POST",
            url:"<?php echo U('Mobile/Cart/ajaxDelCart'); ?>",
            data:{ids:ids},
            dataType:'json',
            success: function(data){
                if(data.status == 1)
                {
                    ajax_cart_list(); //ajax 请求获取购物车列表
                }
            }
        });
    }

    // 批量删除购物车的商品
//    function del_cart_more()
//    {
//        if(!confirm('确定要删除吗?'))
//            return false;
//        // 循环获取复选框选中的值
//        var chk_value = [];
//        $('input[name^="cart_select"]:checked').each(function(){
//            var s_name = $(this).attr('name');
//            var id = s_name.replace('cart_select[','').replace(']','');
//            chk_value.push(id);
//        });
//        // ajax调用删除
//        if(chk_value.length > 0)
//            ajax_del_cart(chk_value.join(','));
//    }
</script>
</body>
</html>




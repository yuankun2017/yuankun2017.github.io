<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:47:"./template/mobile/new2/cart/ajax_cart_list.html";i:1503541949;}*/ ?>
<?php if(empty($cartList) && !empty($user['user_id'])): ?>
    <!--购物车没有商品-s-->
    <div class="nonenothing">
        <img src="__STATIC__/images/nothing.png"/>
        <p>购物车暂无商品</p>
        <a href="<?php echo U('Mobile/Index/index'); ?>">去逛逛</a>
    </div>
    <!--购物车没有商品-e-->
<?php else: if(is_array($cartList) || $cartList instanceof \think\Collection || $cartList instanceof \think\Paginator): if( count($cartList)==0 ) : echo "" ;else: foreach($cartList as $k=>$v): ?>
    <!--店铺列表-s-->
    <!--<div class="allshoporder">-->
        <!--<div class="maleri30">-->
            <!--<div class="logoshopcar fl">-->
                <!--<img src="__STATIC__/images/logo_shopcar.png"/>-->
                <!--&lt;!&ndash;供货商名称&ndash;&gt;-->
                <!--<span>供货商：<?php echo $tpshop_config['shop_info_store_name']; ?></span>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
    <!--店铺列表-e-->
    <div class="orderlistshpop p">
        <div class="maleri30">
            <!--商品列表-s-->
            <div class="sc_list">
                <div class="radio fl ">
                    <!--商品勾选按钮-->
                    <span onClick="checkgood(this)" class="che <?php if($v[selected] == 1): ?>check_t<?php endif; ?>" >
                        <i>
                            <input type="checkbox" autocomplete="off" id="good[<?php echo $v['id']; ?>]" name="cart_select[<?php echo $v['id']; ?>]" <?php if($v[selected] == 1): ?>checked="checked"<?php endif; ?>  style="display:none;" value="1" onclick="ajax_cart_list();">
                        </i>
                    </span>
                </div>
                <div class="shopimg fl">
                    <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>">
                    <!--商品图片-->
                        <img src="<?php echo goods_thum_images($v['goods_id'],200,200); ?>">
                    </a>
                </div>
                <div class="deleshow fr">
                    <div class="deletes">
                        <!--商品名-->
                            <span class="similar-product-text fl">
                                <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>"><?php echo $v[goods_name]; ?></a>
                            </span>
                        <!--删除按钮-->
                        <a href="javascript:void(0);" onclick="del_cart_goods(<?php echo $v['id']; ?>)" class="delescj"><img src="__STATIC__/images/dele.png"/></a>
                    </div>
                    <!--商品属性，规格-->
                    <p class="weight"><?php echo $v[spec_key_name]; ?></p>
                    <div class="prices">
                        <p class="sc_pri fl">
                            <!--商品单价-->
                            <span>￥</span><span><?php echo $v['member_goods_price']; ?></span>
                        </p>
                        <!--加减数量-->
                        <div class="plus fr get_mp">
                            <span class="mp_minous" onclick="switch_num(-1,<?php echo $v['id']; ?>,<?php echo $v['store_count']; ?>)">-</span>
                            <span class="mp_mp">
                            <input id="goods_num[<?php echo $v['id']; ?>]" type="text" onKeyDown='if(event.keyCode == 13) event.returnValue = false' name="goods_num[<?php echo $v['id']; ?>]"  value="<?php echo $v['goods_num']; ?>"  class="input-num"  onblur="switch_num(0,<?php echo $v['id']; ?>,<?php echo $v['store_count']; ?>)"/>
                            </span>
                            <span class="mp_plus" onclick="switch_num(1, <?php echo $v['id']; ?>, <?php echo $v['store_count']; ?>)">+</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--商品列表-e-->
        </div>
    </div>
<?php endforeach; endif; else: echo "" ;endif; ?>
    <!--提交栏-s-->
    <div class="foohi foohiext">
        <div class="payit ma-to-20 payallb">
            <div class="fl alllef">
                <div class="radio fl" onclick="chkAll_onclick()">
                    <span class="che alltoggle">
                        <i></i>
                    </span>
                    <span class="all">全选</span>
                </div>
                <div class="youbia">
                    <p><span class="pmo">总计：</span><span>￥</span><span id="cartsum"><?php echo $total_price['total_fee']; ?></span></p>
                    <p class="lastime"><span>不含运费</span></p>
                </div>
            </div>
            <div class="fr">
                <a href="javascript:void(0);" onclick="return selcart_submit()">去结算</a>
            </div>
        </div>
    </div>
    <!--提交栏-e-->
<?php endif; ?>

<script>
    //点击结算
    function selcart_submit()
    {
        //获取选中的商品个数
        var j=0;
        $('input[name^="cart_select"]:checked').each(function(){
            j++;
        });
        //选择数大于0
        if (j>0){
            //跳转订单页面
            window.location.href="<?php echo U('Mobile/Cart/cart2'); ?>"
        }else {
            layer.open({content:'请选择要结算的商品！',time:2});
            return false;
        }
    }

    //勾选商品
    function checkgood(obj){
        if($(obj).hasClass('check_t')){
            //改变颜色
            $(obj).removeClass('check_t');
            //取消选中
            $(obj).find('input').attr('checked',false);
        }else {
            //改变颜色
            $(obj).addClass('check_t');
            //勾选选中
            $(obj).find('input').attr('checked',true);
        }
        ajax_cart_list();
    }

    //定义变量
    var is_checked = true;
    //判断商品是否选中，未选中返回false
    $('.sc_list .che').each(function(){
        if(!$(this).hasClass('check_t'))
        {
            //只要有没选中返回false
            is_checked = false;
            return false;
        }
    });

    //判断所有商品选择状态，改变全选状态
    if(is_checked){
        $('.alllef .che').addClass('check_t');
    }else
    {
        $('.alllef .che').removeClass('check_t');
    }
    //全选按钮
    function chkAll_onclick()
    {
        //取消全选
        if($('.alllef .che').hasClass('check_t')){
            $('.alllef .che').removeClass('check_t');
            $('.inner .che').removeClass('check_t');
            //全部商品取消checked
            $("input[name^='cart_select']").prop('checked',false);
            is_checked = false;
        }
        //全选
        else{
            $('.alllef .che').addClass('check_t');
            $('.inner .che').addClass('check_t');
            //全部商品添加checked
            $("input[name^='cart_select']").prop('checked',true);
            is_checked = true;
        }
        ajax_cart_list();
    }
</script>
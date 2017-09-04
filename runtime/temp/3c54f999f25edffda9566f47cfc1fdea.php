<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:48:"./template/pc/rainbow/cart/header_cart_list.html";i:1503541960;}*/ ?>
<?php if(count($cartList) == 0): ?>
    <!--为空时-s-->
    <div class="empty-c">
        <span class="ma"><i class="c-i oh"></i>亲，购物车中没有商品哟~</span>
    </div>
    <!--为空时-e-->
<?php else: ?>
    <!--有商品时-s-->
    <div class="mn-c-m oh">
        <?php if(is_array($cartList) || $cartList instanceof \think\Collection || $cartList instanceof \think\Paginator): if( count($cartList)==0 ) : echo "" ;else: foreach($cartList as $k=>$v): ?>
            <div class="mn-c-box J-sdb-cb js_cart_top" style="height: 240px;">
                <dl class="c-store mb15">
                    <dt class="c-store-tt fixed"><a href="#" class="n fl"><?php echo date("Y-m-d H:i:s",$v['add_time']); ?></a></dt>
                    <dd class="c-list">
                        <div class="c-prod">
                            <div class="c-item fixed  js_cart_pro_list">
                                <a href="javascript:void(0);" class="del js_delete" onclick="header_cart_del(<?php echo $v['id']; ?>);"></a>

                                <p class="i fl mr5">
                                    <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>"> <img src="<?php echo goods_thum_images($v['goods_id'],50,50); ?>" height="50" width="50" alt="" title="<?php echo $v[goods_name]; ?>"></a>
                                </p>

                                <p class="n fl">
                                    <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>"><?php echo $v[goods_name]; ?></a>
                                </p>

                                <!--数额加减-->
                                <!--<p class="num fl js_mini_num">-->
                                    <!--<a href="javascript:void(0);" class="reduce reduce_gray fl"></a>-->
                                    <!--<input type="text" autocomplete="off" value="1">-->
                                    <!--<a href="javascript:void(0);" class="add  fr"></a>-->
                                <!--</p>-->
                                <p class="  fl js_mini_num"> * <?php echo $v[goods_num]; ?> 件 </p>
                                <p class="p fr mt5"><em>￥</em><span><?php echo $v[member_goods_price]; ?></span></p>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <div class="mn-c-total">
            <div class="c-t fixed">
                <p class="t-n fl"><span id="total_qty"><?php echo $cart_total_price[num]; ?></span>件</p>
                <p class="t-p fr"><em>￥</em><span id="total_pay"><?php echo $cart_total_price[total_fee]; ?></span></p>
            </div>
            <div class="c-btn">
                <a href="<?php echo U('Home/Cart/cart'); ?>">去购物车结算 &gt;&gt;</a>
            </div>
        </div>
    </div>
    <!--有商品时-e-->
<?php endif; ?>
<script>
   $(".cart_quantity").text('<?php echo $cart_total_price[anum]; ?>'); // 购物车的总数量
</script>
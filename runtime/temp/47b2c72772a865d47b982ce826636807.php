<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:45:"./template/mobile/new2/goods/ajaxComment.html";i:1503541950;}*/ ?>
<?php if($count > 0): ?>
  <div class="assess-flat " id="comList">
     <?php if(is_array($commentlist) || $commentlist instanceof \think\Collection || $commentlist instanceof \think\Paginator): if( count($commentlist)==0 ) : echo "" ;else: foreach($commentlist as $k=>$v): ?>
            <span class="assess-wrapper"  >
                <div class="assess-top">
                    <?php if($v['is_anonymous'] == 1): ?>
                        <span class="user-portrait"><img src="__STATIC__/images/user68.jpg"></span>
                        <span class="user-name">匿名用户</span>
                    <?php else: ?>
                        <span class="user-portrait"><img src="<?php echo (isset($v['head_pic']) && ($v['head_pic'] !== '')?$v['head_pic']:'__STATIC__/images/user68.jpg'); ?>"></span>
                        <span class="user-name"><?php echo $v['username']; ?></span>
                    <?php endif; ?>
                    <span class="assess-date"><?php echo date('Y-m-d H:i',$v['add_time']); ?></span>
                </div>
                <div class="assess-bottom">
                    <span class="comment-item-star">
                        <span class="real-star comment-stars-width<?php echo $v['service_rank']; ?>"></span>
                    </span>
                    <p class="assess-content"><?php echo htmlspecialchars_decode($v['content']); ?></p>
                    <div class="product-img-module">
                        <a class="J_ping" report-eventid="MProductdetail_CommentPictureTab" report-pageparam="1725965683" href="/ware/newCommentDetailPicShow.action?commentId=<?php echo $v['comment_id']; ?>&amp;wareId=1725965683">
                            <ul class="jd-slider-container gallery">
                                <?php if(is_array($v['img']) || $v['img'] instanceof \think\Collection || $v['img'] instanceof \think\Paginator): if( count($v['img'])==0 ) : echo "" ;else: foreach($v['img'] as $key=>$v2): ?>
                                    <li class="jd-slider-item product-imgs-li">
                                        <dd><a href="<?php echo $v2; ?>"><img src="<?php echo $v2; ?>" width="100px" heigth="100px"></a></dd>
                                    </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </a>
                    </div>
                    <!--商家回复-s-->
                    <?php if(is_array($replyList[$v['comment_id']]) || $replyList[$v['comment_id']] instanceof \think\Collection || $replyList[$v['comment_id']] instanceof \think\Paginator): if( count($replyList[$v['comment_id']])==0 ) : echo "" ;else: foreach($replyList[$v['comment_id']] as $k=>$reply): ?>
                            <p class="pay-date"><?php echo $reply['username']; ?>回复：<?php echo $reply['content']; ?></p>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <!--商家回复-e-->
                    <!--<p class="product-type">颜色：ML574VB 型号：38/235MM</p>-->
                </div>
            </span>
             <div class="assess-btns-box">
                 <div class="assess-btns">
                     <a class="assess-like-btn" id="<?php echo $v[comment_id]; ?>" data-comment-id="<?php echo $v['comment_id']; ?>" onclick="zan(this);">
                         <i class="assess-btns-icon btn-like-icon like-grey"></i>
                         <span class="assess-btns-num" id="span_zan_<?php echo $v['comment_id']; ?>" data="0"><?php echo $v['zan_num']; ?></span>
                         <i class="like">+1</i>
                     </a>
                     <a class="assess-reply-btn" id="f135e04a-ca94-4f00-a0db-3a30ac206ceb_0">
                         <i class="no-assess-btns-icon btn-reply-icon"></i>
                         <span class="assess-btns-num" id="comment_id<?php echo $v[comment_id]; ?>">
<?php echo count($replyList[$v['comment_id']]); ?>
                         </span>
                     </a>
                 </div>
             </div>
     <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
<?php else: ?>
     <script>
         ajax_sourch_submit_hide();
     </script>
    <!--没有内容时-s-->
    <div class="comment_con p">
        <div class="none"><img src="__STATIC__/images/none.png"/><br /><br />亲，此处还没有内容哦~</div>
    </div>
    <!--没有内容时-e-->
<?php endif; if(($count > $current_count) AND (count($commentlist) == $page_count)): ?>
     <div class="getmore" style="font-size:.32rem;text-align:center;color:#888;padding:.25rem .24rem .4rem; clear:both">
         <a href="javascript:void(0)" onClick="ajaxSourchSubmit();">点击加载更多</a>
     </div>
     <?php elseif(($count <= $current_count AND $count > 0)): ?>
        <div class="score enkecor">已显示完所有评论</div>
     <?php else: endif; ?>
<link href="__STATIC__/css/photoswipe.css" rel="stylesheet" type="text/css">
<script src="__STATIC__/js/klass.min.js"></script>
<script src="__STATIC__/js/photoswipe.js"></script>
<script type="text/javascript">
    $(".gallery a").photoSwipe({
        enableMouseWheel: false,
        enableKeyboard: false,
        allowUserZoom: false,
        loop:false
    });
     var page = <?php echo $p; ?>;
     function ajaxSourchSubmit() {
         page += 1;
         $.ajax({
             type: "GET",
             url: "<?php echo U('Mobile/Goods/ajaxComment',array('goods_id'=>$goods_id,'commentType'=>$commentType),''); ?>"+"/p/" + page,
             success: function (data) {
                 $('.getmore').hide();
                 if ($.trim(data) != ''){
                     $("#comList").append(data);
                 }
             }
         });
     }
     function  ajax_sourch_submit_hide(){
         $('.getmore').hide();
     }

     //点赞
     function hde(){
         setTimeout(function(){
             $('.alert').hide();
         },1200)
     }

     /**
      * 点赞ajax
      * dyr
      * @param obj
      */
     function zan(obj) {
         var user_id = getCookie('user_id');
         if (user_id == '') {
             layer.open({content:'请先登录',time:2});
             return ;
         }
         var comment_id = $(obj).attr('data-comment-id');
         var zan_num = parseInt($("#span_zan_" + comment_id).text());
         $.ajax({
             type: "POST",
             data: {comment_id: comment_id},
             dataType: 'json',
             url: "/index.php?m=Home&c=User&a=ajaxZan",
             success: function (res) {
                 if (res.success) {
                     $("#span_zan_" + comment_id).text(zan_num + 1);
                     $('#'+comment_id).find('.like').addClass('like_ani'); //显示点赞效果
                     $('#'+comment_id).find('.btn-like-icon').addClass('like-red');
                 } else {
                     $('.alert').show(200);
                     $('.alert').animate({opacity:"1"},600,hde());
                 }
             },
             error : function(res) {
                 if( res.status == "200"){ // 兼容调试时301/302重定向导致触发error的问题
                     layer.open({content:'请先登录!',time:2})
                     return;
                 }
                 layer.open({content:'请求失败!',time:2})
                 return;
             }
         });
     }
//     function clickful(id){
//         if($('#'+id).find('.btn-like-icon').hasClass('like-red')){
//             $('.alert').show(200);
//             $('.alert').animate({opacity:"1"},600,hde());
//             return false;
//         }
//         var likenum =$('#support'+id).text(); //获取当前点赞数
//         ++likenum;     //点赞加1
//         $('#'+id).find('.like').addClass('like_ani'); //显示点赞效果
//         $('#'+id).find('.btn-like-icon').addClass('like-red');
//         $('#support'+id).text(likenum);
//     };
 </script>
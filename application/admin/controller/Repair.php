<?php

namespace app\admin\controller;
use app\admin\logic\GoodsLogic;
use think\Db;
use think\Page;

class Repair extends Base{
	
    //电脑维护订单
	public function index(){
	    //查询所有订单
	    $pc_repair_list = M("repair_pc")
	                       ->alias("rp")
	                       ->join("tp_repair_problems rpb","rpb.problems_id = rp.problems_id")
	                       ->field("rp.*,rpb.name")
	                       ->order("repair_pcid desc")
	                       ->select();
	    
	    $this->assign("pc_repair_list",$pc_repair_list);
	    $this->assign("dataCount",count($pc_repair_list));
        return $this->fetch();
	}	
	
	//电脑维护增改
	public function pc_repair_info()
	{
	    $act = I('GET.act', 'add');
	    $repair_pcid = I('get.repair_pcid');
	    $repair_pc_info = array();
	    if ($repair_pcid) {
	        $repair_pc_info = D('repair_pc')->where('repair_pcid=' . $repair_pcid)->find();
	        $act = 'edit';
	    }
	    //查询有所电脑问题
	    $problems = M("repair_problems")->where("type",1)->select();
	    $this->assign("problems",$problems);
	    $this->assign('info', $repair_pc_info);
	    $this->assign('act', $act);
	    return $this->fetch();
	}
	
	//手机维护订单
	public function mobile_repair(){
	    //查询所有订单
	    $pc_repair_list = M("repair_mobile")
	    ->alias("rm")
	    ->join("tp_repair_problems rpb","rpb.problems_id = rm.problems_id")
	    ->join("tp_repair_mobilebrand rmb","rm.mobile_bid = rmb.mobile_bid")
	    ->join("tp_repair_mobileproduct rmp","rm.mobile_pid = rmp.mobile_pid")
	    ->field("rm.*,rmb.name as brand_name,rmp.name as product_name,rpb.name as problems_name")
	    ->order("repair_mid desc")
	    ->select();
	     
	    $this->assign("pc_repair_list",$pc_repair_list);
	    $this->assign("dataCount",count($pc_repair_list));
	    return $this->fetch();
	}
	
	//手机维护增改
	public function mobile_repair_info()
	{
	    $act = I('GET.act', 'add');
	    $repair_mid = I('get.repair_mid');
	    $repair_mobile_info = array();
	    if ($repair_mid) {
	        $repair_mobile_info = D('repair_mobile')->where('repair_mid=' . $repair_mid)->find();
	        $act = 'edit';
	    }
	    //手机类型
	    $type = $repair_mobile_info['type']?$repair_mobile_info['type']:3;
	    //手机品牌
	    $banrd_list = M("repair_mobilebrand")->where("type",$type)->select();
	    $mobile_bid = $repair_mobile_info['mobile_bid']?$repair_mobile_info['mobile_bid']:$banrd_list[0]['mobile_bid'];
	    //手机型号
	    $product_list = M("repair_mobileproduct")->where("mobile_bid",$mobile_bid)->select();
	    //查询有所手机问题
	    $problems = M("repair_problems")->where("type",2)->select();
	    $this->assign("problems",$problems);
	    $this->assign("banrd_list",$banrd_list);
	    $this->assign("product_list",$product_list);
	    $this->assign('info', $repair_mobile_info);
	    $this->assign('act', $act);
	    return $this->fetch();
	}
	
	public function problems(){
	   //查询所有问题
	   $problems = M("repair_problems")->order("type desc")->select();
	   $this->assign("problems",$problems);
	   $this->assign("dataCount",count($problems));
	   return $this->fetch();
	}
	
	//维修问题增改
	public function problems_repair_info()
	{
	    $act = I('GET.act', 'add');
	    $problems_id = I('get.problems_id');
	    $repair_problems_info = array();
	    if ($problems_id) {
	        $repair_problems_info = D('repair_problems')->where('problems_id=' . $problems_id)->find();
	        $act = 'edit';
	    }
	    $this->assign('info', $repair_problems_info);
	    $this->assign('act', $act);
	    return $this->fetch();
	}
	
	public function brand(){
	
	}
	
	public function product(){
	
	}
	
	//对电脑维护的操作
	public function  pc_repair_handle(){
	    if(IS_AJAX){
	        $act = I("act");
	        switch($act){
	            case "add":
	                $data['type'] = I("post.type")?I("post.type"):2;
	                $data['problems_id'] = I("post.problems_id")?I("post.problems_id"):1;
	                $data['consignee'] = I("post.consignee");
	                $data['mobile'] = I("post.mobile");
	                $data['des'] = I("post.des");
	                $data['address'] = I("post.address");
	                $data['addtime'] = time();
	                $data['status'] = 0;
	                $result = M("repair_pc")->add($data);
	                if($result){
	                    $back['status'] = 1;
	                    $back['msg'] = "操作成功";
	                    $back['data'] = $result;
	                }else{
	                    $back['status'] = 0;
        	            $back['msg'] = "操作失败";
        	            $back['data'] = null;
	                }
	                break;
	            case "edit":
	                $data['repair_pcid'] = I("post.repair_pcid");
	                $data['type'] = I("post.type")?I("post.type"):2;
	                $data['problems_id'] = I("post.problems_id")?I("post.problems_id"):1;
	                $data['consignee'] = I("post.consignee");
	                $data['mobile'] = I("post.mobile");
	                $data['des'] = I("post.des");
	                $data['address'] = I("post.address");
	                $result = M("repair_pc")->where("repair_pcid",$data['repair_pcid'])->save($data);
	                if($result){
	                    $back['status'] = 1;
	                    $back['msg'] = "操作成功";
	                    $back['data'] = $result;
	                }else{
	                    $back['status'] = 0;
	                    $back['msg'] = "操作失败";
	                    $back['data'] = null;
	                }
	                break;
	            case "del":
	                $repair_pcid = I("repair_pcid");
	                $result = M("repair_pc")->where("repair_pcid",$repair_pcid)->delete();
	                break;
	            default:
	                $result = 0;
	                break;
	        }
	        if($result){
	            $back['status'] = 1;
	            $back['msg'] = "操作成功";
	            $back['data'] = $result;
	        }else{
	            $back['status'] = 0;
	            $back['msg'] = "操作失败";
	            $back['data'] = null;
	        }
	        echo json_encode($back);
	    }else{
	        echo "非法访问";
	    }
	    exit();
	}
	
	//对手机维护的操作
	public function  mobile_repair_handle(){
	    if(IS_AJAX){
	        $act = I("act");
	        switch($act){
	            case "add":
	                $data['type'] = I("post.type")?I("post.type"):3;
	                $data['problems_id'] = I("post.problems_id");
	                $data['mobile_bid'] = I("post.mobile_bid");
	                $data['mobile_pid'] = I("post.mobile_pid");
	                $data['consignee'] = I("post.consignee");
	                $data['mobile'] = I("post.mobile");
	                $data['des'] = I("post.des");
	                $data['address'] = I("post.address");
	                $data['addtime'] = time();
	                $data['status'] = 0;
	                $result = M("repair_mobile")->add($data);
	                if($result){
	                    $back['status'] = 1;
	                    $back['msg'] = "操作成功";
	                    $back['data'] = $result;
	                }else{
	                    $back['status'] = 0;
	                    $back['msg'] = "操作失败";
	                    $back['data'] = null;
	                }
	                break;
	            case "edit":
	                $data['repair_mid'] = I("post.repair_mid");
	                $data['type'] = I("post.type")?I("post.type"):3;
	                $data['problems_id'] = I("post.problems_id");
	                $data['mobile_bid'] = I("post.mobile_bid");
	                $data['mobile_pid'] = I("post.mobile_pid");
	                $data['consignee'] = I("post.consignee");
	                $data['mobile'] = I("post.mobile");
	                $data['des'] = I("post.des");
	                $data['address'] = I("post.address");
	                $result = M("repair_mobile")->where("repair_mid",$data['repair_mid'])->save($data);
	                if($result){
	                    $back['status'] = 1;
	                    $back['msg'] = "操作成功";
	                    $back['data'] = $result;
	                }else{
	                    $back['status'] = 0;
	                    $back['msg'] = "操作失败";
	                    $back['data'] = null;
	                }
	                break;
	            case "del":
	                $repair_mid = I("repair_mid");
	                $result = M("repair_mobile")->where("repair_mid",$repair_mid)->delete();
	                break;
	            default:
	                $result = 0;
	                break;
	        }
	        if($result){
	            $back['status'] = 1;
	            $back['msg'] = "操作成功";
	            $back['data'] = $result;
	        }else{
	            $back['status'] = 0;
	            $back['msg'] = "操作失败";
	            $back['data'] = null;
	        }
	        echo json_encode($back);
	    }else{
	        echo "非法访问";
	    }
	    exit();
	}
	
	//查询对应品牌
	public function get_brand() {
	    //手机类型
	    $type = I("type");
	    //手机品牌
	    $brand_list = M("repair_mobilebrand")->where("type",$type)->select();
	    //手机型号
	    $product_list = M("repair_mobileproduct")->where("mobile_bid",$brand_list[0]['mobile_bid'])->select();
	    $data['brand_list'] = $brand_list;
	    $data['product_list'] = $product_list;
	    $back['status'] = 1;
	    $back['msg'] = "查询成功";
	    $back['data'] = $data;
	    echo json_encode($back);
	    exit();
	}
	//查询对应型号
	public function get_product() {
	    //手机品牌
	    $mobile_bid = I("mobile_bid");
	    //手机型号
	    $product_list = M("repair_mobileproduct")->where("mobile_bid",$mobile_bid)->select();
	    $back['status'] = 1;
	    $back['msg'] = "查询成功";
	    $back['data'] = $product_list;
	    echo json_encode($back);
	    exit();
	}
	
	
	//对维修问题的操作
	public function  repair_problems_handle(){
	    if(IS_AJAX){
	        $act = I("act");
	        switch($act){
	            case "add":
	                $data['type'] = I("post.type")?I("post.type"):1;
	                $data['name'] = I("post.problems_name");
	                $data['price'] = I("post.price");
	                $result = M("repair_problems")->add($data);
	                if($result){
	                    $back['status'] = 1;
	                    $back['msg'] = "操作成功";
	                    $back['data'] = $result;
	                }else{
	                    $back['status'] = 0;
	                    $back['msg'] = "操作失败";
	                    $back['data'] = null;
	                }
	                break;
	            case "edit":
	                $data['problems_id'] = I("post.problems_id");
                    $data['type'] = I("post.type")?I("post.type"):1;
	                $data['name'] = I("post.problems_name");
	                $data['price'] = I("post.price");
	                $result = M("repair_problems")->where("problems_id",$data['problems_id'])->save($data);
	                if($result){
	                    $back['status'] = 1;
	                    $back['msg'] = "操作成功";
	                    $back['data'] = $result;
	                }else{
	                    $back['status'] = 0;
	                    $back['msg'] = "操作失败";
	                    $back['data'] = null;
	                }
	                break;
	            case "del":
	                $problems_id = I("problems_id");
	                $result = M("repair_problems")->where("problems_id",$problems_id)->delete();
	                break;
	            default:
	                $result = 0;
	                break;
	        }
	        if($result){
	            $back['status'] = 1;
	            $back['msg'] = "操作成功";
	            $back['data'] = $result;
	        }else{
	            $back['status'] = 0;
	            $back['msg'] = "操作失败";
	            $back['data'] = null;
	        }
	        echo json_encode($back);
	    }else{
	        echo "非法访问";
	    }
	    exit();
	}
}
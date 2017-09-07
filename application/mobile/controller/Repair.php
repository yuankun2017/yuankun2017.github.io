<?php
/**
 * 预约维护控制器
 */ 
namespace app\mobile\controller;
use think\Request;
class Repair extends MobileBase {
    //手机预约维护
	public function mobile_repair() {
	    $type = I("get.type")?I("get.type"):3;
	    $mobile_bid = I("get.mobile_bid"); //品牌
	    $mobile_pid = I("get.mobile_pid"); //型号
	    if($type == 3){
	        $repair_type = array("type"=>"3","name"=>"安卓手机");
	    }else{
	        $repair_type = array("type"=>"4","name"=>"苹果手机");
	    }
	    //查询品牌
	    $mobile_brand_list = M("repair_mobilebrand")->where("type",$type)->select();
	    if(empty($mobile_bid)){
	        $mobile_brand =  $mobile_brand_list[0];
	    }else{
	        $mobile_brand = M("repair_mobilebrand")->where("mobile_bid",$mobile_bid)->find();
	    }
	    //查询型号
	    if(empty($mobile_pid)){
	        $mobile_product = M("repair_mobileproduct")->where("mobile_pid",$mobile_brand['mobile_brand'])->find();
	    }else{
	        $mobile_product = M("repair_mobileproduct")->where("mobile_pid",$mobile_pid)->find();
	    }
	    
	    //查询所有手机问题
	    $problems = M("repair_problems")->where("type",2)->select();
	    $this->assign("problems",$problems);
	    $this->assign("mobile_product",$mobile_product);
	    $this->assign("mobile_brand",$mobile_brand);
	    $this->assign("repair_type",$repair_type);
		return $this->fetch();
	}
	
	//电脑预约维护
	public function pc_repair() {
	    $type = I("get.type")?I("get.type"):2;
	    $problems_id = I("get.problems_id")?I("get.problems_id"):1;
	    if($type == 1){
	        $repair_type = array("type"=>"1","name"=>"台式机");
	    }else{
	        $repair_type = array("type"=>"2","name"=>"笔记本");
	    }
	    $problems = M("repair_problems")->where("problems_id",$problems_id)->find();
	    $this->assign("problems",$problems);
	    $this->assign("repair_type",$repair_type);
		return $this->fetch();
	}
	
	//选择维护类型
	public function  repair_sreach(){
		$action = I("get.type_sreach");
		if($action == "pc"){
			$repair_type = array(
			    array("type"=>"1","name"=>"台式机"),
			    array("type"=>"2","name"=>"笔记本"),
			);
		}else{
			$repair_type = array(
			    array("type"=>"3","name"=>"安卓手机"),
			    array("type"=>"4","name"=>"苹果手机"),
			);
		}
		$this->assign("repair_type",$repair_type);
		$this->assign("action",$action);
		return $this->fetch();
	}
	
	//维护问题
	public function pc_problems(){
	    $type = I("get.type")?I("get.type"):2;
	    //查询所有问题
	    $problems = M("repair_problems")->where("type",1)->select();
	    $this->assign("type",$type);
	    $this->assign("problems",$problems);
	    return $this->fetch();
	}
	
	//添加维护信息
	public function pc_repairs_add() {
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
	        $this->success("预约成功");
	    }else{
	        $this->error("预约失败,请稍后重试");
	    }
	}
	
	//维护手机品牌
	public function mobile_brand() {
	    $type = I("get.type")?I("get.type"):3;
	    //查询所有手机品牌
	    $mobile_brand = M("repair_mobilebrand")->where("type",$type)->select();
	    $this->assign("type",$type);
	    $this->assign("mobile_brand",$mobile_brand);
	    return $this->fetch();
	}
	
	//手机信号
	public function mobile_product(){
	    $type = I("get.type")?I("get.type"):3;
	    $mobile_bid = I("get.mobile_bid");
	    //查询所有手机品牌
	    $mobile_product = M("repair_mobileproduct")->where("mobile_bid",$mobile_bid)->select();
	    $this->assign("type",$type);
	    $this->assign("mobile_bid",$mobile_bid);
	    $this->assign("mobile_product",$mobile_product);
	    return $this->fetch();
	}
	//添加维护信息
	public function  mobile_repairs_add(){
	    $data['type'] = I("post.type")?I("post.type"):3;
	    $data['mobile_bid'] = I("post.mobile_bid");
	    $data['mobile_pid'] = I("post.mobile_pid");
	    $data['problems_id'] = I("post.problems_id")?I("post.problems_id"):1;
	    $data['consignee'] = I("post.consignee");
	    $data['mobile'] = I("post.mobile");
	    $data['des'] = I("post.des");
	    $data['address'] = I("post.address");
	    $data['addtime'] = time();
	    $data['status'] = 0;
	    $result = M("repair_mobile")->add($data);
	    if($result){
	        $this->success("预约成功");
	    }else{
	        $this->error("预约失败,请稍后重试");
	    }
	}
	
}

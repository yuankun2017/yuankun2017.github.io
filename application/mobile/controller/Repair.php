<?php
/**
 * 预约维护控制器
 */ 
namespace app\mobile\controller;
use think\Request;
class Repair extends MobileBase {
    //手机预约维护
	public function mobile_repair() {
	    //查询所有手机维修问题
	    $problems = M("repair_problems")->where("type",2)->select();
	    //查询所有安卓手机品牌
	    $android_brand = M("repair_mobilebrand")->where("type",3)->select();
	    $android_result = array();
	    //组装安卓型号数组
	    foreach ($android_brand as $key=>$value){
	        //查询该品牌下的所有型号
	        $android_model = M("repair_mobileproduct")->where("mobile_bid",$value['mobile_bid'])->select();
	        if($android_model){
	            $android_model_array = array();
	            foreach ($android_model as $k=>$v){
	                $android_model_array[] = array("value"=>$v['mobile_pid'],"text"=>$v['name']);
	            }
	            $android_result[] = array("value"=>$value['mobile_bid'],"text"=>$value['name'],"children"=>$android_model_array);
	        }else{
	            $android_result[] = array("value"=>$value['mobile_bid'],"text"=>$value['name']);
	        }
	    }
	    //查询所有苹果手机品牌
	    $apple_brand = M("repair_mobilebrand")->where("type",4)->select();
	    $apple_result = array();
	    //组装苹果型号数组
	    foreach ($apple_brand as $key=>$value){
	        //查询该品牌下的所有型号
	        $apple_model = M("repair_mobileproduct")->where("mobile_bid",$value['mobile_bid'])->select();
	        if($apple_model){
	            $apple_model_array = array();
	            foreach ($apple_model as $k=>$v){
	                $apple_model_array[] = array("value"=>$v['mobile_pid'],"text"=>$v['name']);
	            }
	            $apple_result[] = array("value"=>$value['mobile_bid'],"text"=>$value['name'],"children"=>$apple_model_array);
	        }else{
	            $apple_result[] = array("value"=>$value['mobile_bid'],"text"=>$value['name']);
	        }
	    }
	    $this->assign("android_result",json_encode($android_result));
	    $this->assign("apple_result",json_encode($apple_result));
	    $this->assign("problems",$problems);
		return $this->fetch();
	}
	
	//电脑预约维护
	public function pc_repair() {
	    //查询所有电脑维修问题
	    $problems = M("repair_problems")->where("type",1)->select();
	    //组装结果
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
	    if (!$data['mobile'] && !$data['address']){
	    	$this->error("预约失败,请稍后重试",U("/mobile/repair/pc_repair"));
	    }
	    $result = M("repair_pc")->add($data);
	    if($result){
	        $this->success("预约成功",U("/mobile/repair/pc_repair"));
	    }else{
	        $this->error("预约失败,请稍后重试",U("/mobile/repair/pc_repair"));
	    }
	}
	
	//添加维护信息
	public function  mobile_repairs_add(){
	    $data['type'] = I("post.type")?I("post.type"):3;
	    $data['mobile_bid'] = I("post.mobile_bid");
	    $data['mobile_pid'] = I("post.mobile_pid");
	    $data['problems_id'] = I("post.problems_id");
	    $data['consignee'] = I("post.consignee");
	    $data['mobile'] = I("post.mobile");
	    $data['des'] = I("post.des");
	    $data['address'] = I("post.address");
	    $data['addtime'] = time();
	    $data['status'] = 0;
	    $result = M("repair_mobile")->add($data);
	    if (!$data['mobile'] && !$data['address']){
	    	$this->error("预约失败,请稍后重试",U("/mobile/repair/mobile_repair"));
	    }
	    if($result){
	        $this->success("预约成功",U("/mobile/repair/mobile_repair"));
	    }else{
	        $this->error("预约失败,请稍后重试",U("/mobile/repair/mobile_repair"));
	    }
	}
	
	//查询维修价格
	public function get_repair_price() {
		if(IS_AJAX){
			$where['type'] = I("post.type");
			$where['problems_id'] = I("post.problems_id");
			if($where['type'] > 2){
				$where['mobile_bid'] = I("post.mobile_bid");
				$where['mobile_pid'] = I("post.mobile_pid");
			}
			$result = M("repair_price")->where($where)->find();
			if($result){
				$back['status'] = 1;
				$back['msg'] = "查询成功";
				$back['data'] = $result['price'];
			}else{
				$back['status'] = 0;
				$back['msg'] = "查询失败";
				$back['data'] = null;
			}
			echo json_encode($back);
		}else{
			echo "非法访问";
		}
		exit();
	}
	
}

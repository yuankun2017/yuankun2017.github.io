<?php
/**
 * 预约维护控制器
 */ 
namespace app\mobile\controller;
use think\Request;
use app\common\util\WechatUtil;
class Repair extends MobileBase {
    
    //手机预约维护
	public function mobile_repair() {
	    //查询所有手机维修问题
	    $problems = M("repair_problems")->where("type",2)->select();
	    //查询所有安卓手机品牌
	    $android_brand = M("repair_mobilebrand")->where("type",3)->order("sort")->select();
	    $android_result = array();
	    //组装安卓型号数组
	    foreach ($android_brand as $key=>$value){
	        //查询该品牌下的所有型号
	        $android_model = M("repair_mobileproduct")->where("mobile_bid",$value['mobile_bid'])->order("sort")->select();
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
	    $apple_brand = M("repair_mobilebrand")->where("type",4)->order("sort")->select();
	    $apple_result = array();
	    //组装苹果型号数组
	    foreach ($apple_brand as $key=>$value){
	        //查询该品牌下的所有型号
	        $apple_model = M("repair_mobileproduct")->where("mobile_bid",$value['mobile_bid'])->order("sort")->select();
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
		$info = json_decode(htmlspecialchars_decode(I('info')),true);
	    
	    $this->assign('system_location',I('system_location'));
	    $this->assign('user_location',I('user_location'));
	    $this->assign('lat',I('lat'));
	    $this->assign('lng',I('lng'));
	    $this->assign('info',$info);
	    $this->assign("android_result",json_encode($android_result));
	    $this->assign("apple_result",json_encode($apple_result));
	    $this->assign("problems",$problems);
		return $this->fetch();
	}
	
	//电脑预约维护
	public function pc_repair() {
		$info = json_decode(htmlspecialchars_decode(I('info')),true);
	    //查询所有电脑维修问题
	    $problems = M("repair_problems")->where("type",1)->select();
	    //组装结果
	    $this->assign('system_location',I('system_location'));
	    $this->assign('user_location',I('user_location'));
	    $this->assign('lat',I('lat'));
	    $this->assign('lng',I('lng'));
	    $this->assign('info',$info);
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
	    $data['lat'] = I("post.lat");
	    $data['lng'] = I("post.lng");
	    $data['address1'] = I("post.address1");
	    $data['address2'] = I("post.address2");
	    $data['addtime'] = time();
        $data['weixiu_no'] = get_weixiu_no("PC");
	    $data['status'] = 0;
	    if (!$data['mobile'] && !$data['address']){
	    	$this->error("预约失败,请稍后重试");
	    }
	    $result = M("repair_pc")->add($data);
	    if($result){
	        $smsLogic = new \app\common\logic\SmsLogic;
	        $sms_admin_phone = M("config")->where(array("name"=>"sms_admin_phone","inc_type"=>"sms"))->find();
	        if($data['type'] == 1){
	        	$type_name="笔记本";
	        }else{
	        	$type_name="台式机";
	        }
	        $address = $data['address'];
	        $phone = $data['mobile'];
	        $param = "{\"type\":\"$type_name\",\"address\":\"$address\",\"phone\":\"$phone\"}";
	        $result = $smsLogic->sendSmsByAliyun($sms_admin_phone['value'],"毅腾科技",$param,"SMS_94690146");
	        $this->success("预约成功");
	    }else{
	        $this->error("预约失败,请稍后重试");
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
	    $data['lat'] = I("post.lat");
	    $data['lng'] = I("post.lng");
	    $data['address1'] = I("post.address1");
	    $data['address2'] = I("post.address2");
	    $data['addtime'] = time();
	    $data['weixiu_no'] = get_weixiu_no("M");
	    $data['status'] = 0;
	    $result = M("repair_mobile")->add($data);
	    if (!$data['mobile'] && !$data['address']){
	    	$this->error("预约失败,请稍后重试");
	    }
	    if($result){
	        //发送短信成功消息
	    	$smsLogic = new \app\common\logic\SmsLogic;
	    	$sms_admin_phone = M("config")->where(array("name"=>"sms_admin_phone","inc_type"=>"sms"))->find();
	    	if($data['type'] == 3){
	    		$type_name="安卓手机";
	    	}else{
	    		$type_name="苹果手机";
	    	}
	    	$address = $data['address'];
	    	$phone = $data['mobile'];
	    	$param = "{\"type\":\"$type_name\",\"address\":\"$address\",\"phone\":\"$phone\"}";
	    	$result = $smsLogic->sendSmsByAliyun($sms_admin_phone['value'],"毅腾科技",$param,"SMS_94690146");
	        $this->success("预约成功");
	    }else{
	        $this->error("预约失败,请稍后重试");
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
	

	//售后查询
	public function order_check(){
		return $this->fetch();
	}
	
	
	//售后查询
	public function order_check_info(){
		$phone = I('post.phone');
		// $order_sn = '201605122147135200';
		$customer_service_info = M('customer_service')->where('phone',$phone)->select();
		if($customer_service_info){
			foreach ($customer_service_info as $key => $value) {
				$customer_service_info[$key]['baoxiu_info'] = json_decode($value['baoxiu_info'],true);
				if($customer_service_info[$key]['baoxiu_info']){
					foreach ($customer_service_info[$key]['baoxiu_info'] as $k => $v) {
						$customer_service_info[$key]['baoxiu_info'][$k]['end_time'] = strtotime("+".$v['baoxiu_value']." month",strtotime(date("Y-m-d",$value['buy_time'])));
					}
				}
			}
		}else{
			$this->error('暂无售后信息','/mobile/repair/order_check');
		}
		$this->assign('customer_service_info',$customer_service_info);
		$this->assign('phone',$phone);
		return $this->fetch();
	}
	

	//选择地图
	public function address_select(){
		$source = I('source','mobile_repair');
		$info = I('info');
		$this->assign('source',$source);
		$this->assign('info',$info);
		return $this->fetch();
	}

	//联系我们
	public function contact(){
		return $this->fetch();
	}


	//手机报价图片展示
	public function mobile_price(){
		$mobile_price = M('config')->where('name','mobile_price')->find();
		$this->assign('mobile_price',$mobile_price['value']);
		return $this->fetch();
	}
}

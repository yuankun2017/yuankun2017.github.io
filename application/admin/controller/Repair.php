<?php

namespace app\admin\controller;
use app\admin\logic\GoodsLogic;
use think\Db;
use think\AjaxPage;
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
	    foreach ($pc_repair_list as $key=>$value){
	    	//查询服务费用
	    	$repair_price = M("repair_price")->where(array("type"=>$value['type'],"problems_id"=>$value['problems_id']))->find();
	    	$pc_repair_list[$key]['price'] = $repair_price['price'];
	    }
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
	    ->join("tp_repair_mobilebrand rmb","rm.mobile_bid = rmb.mobile_bid","left")
	    ->join("tp_repair_mobileproduct rmp","rm.mobile_pid = rmp.mobile_pid","left")
	    ->field("rm.*,rmb.name as brand_name,rmp.name as product_name,rpb.name as problems_name")
	    ->order("repair_mid desc")
	    ->select();
	    foreach ($pc_repair_list as $key=>$value){
	    	//查询服务费用
	    	$repair_price = M("repair_price")->where(array("type"=>$value['type'],"problems_id"=>$value['problems_id'],"mobile_bid"=>$value['mobile_bid'],"mobile_pid"=>$value['mobile_pid']))->find();
	    	$pc_repair_list[$key]['price'] = $repair_price['price'];
	    }
	     
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
		//查询所有手机品牌
		$mobile_brand_list = M("repair_mobilebrand")->order("type desc,sort")->select();
		$this->assign("mobile_brand_list",$mobile_brand_list);
		$this->assign("dataCount",count($mobile_brand_list));
		return $this->fetch();
	}
	
	
	//手机品牌增改
	public function brand_info()
	{
		$act = I('GET.act', 'add');
		$mobile_bid = I('get.mobile_bid');
		$repair_mobilebrand_info = array();
		if ($mobile_bid) {
			$repair_mobilebrand_info = D('repair_mobilebrand')->where('mobile_bid=' . $mobile_bid)->find();
			$act = 'edit';
		}
		$this->assign('info', $repair_mobilebrand_info);
		$this->assign('act', $act);
		return $this->fetch();
	}
	
	public function product(){
		//查询所有手机型号
		$mobile_product_list = M("repair_mobileproduct")
								->alias("rmp")
								->join("tp_repair_mobilebrand rmb","rmp.mobile_bid = rmb.mobile_bid")
								->field("rmp.*,rmb.name as brand_name")
								->order("mobile_bid desc,sort")
								->select();
		$this->assign("mobile_product_list",$mobile_product_list);
		$this->assign("dataCount",count($mobile_product_list));
		return $this->fetch();
	}
	
	//手机型号增改
	public function product_info()
	{
		$act = I('GET.act', 'add');
		$mobile_pid = I('get.mobile_pid');
		$repair_mobileproduct_info = array();
		if ($mobile_pid) {
			$repair_mobileproduct_info = D('repair_mobileproduct')->where('mobile_pid=' . $mobile_pid)->find();
			$act = 'edit';
		}
		//查询所有品牌
		$brand_list = M("repair_mobilebrand")->order("type desc")->select();
		$this->assign("brand_list",$brand_list);
		$this->assign('info', $repair_mobileproduct_info);
		$this->assign('act', $act);
		return $this->fetch();
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
	//查询对应问题
	public function get_problems() {
		//手机品牌
		$type = I("type");
		//手机型号
		$problems_list = M("repair_problems")->where("type",$type)->select();
		$back['status'] = 1;
		$back['msg'] = "查询成功";
		$back['data'] = $problems_list;
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
// 	                $data['price'] = I("post.price");
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
// 	                $data['price'] = I("post.price");
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
	
	
	//对手机品牌的操作
	public function  repair_mobile_brand_handle(){
		if(IS_AJAX){
			$act = I("act");
			switch($act){
				case "add":
					$data['type'] = I("post.type")?I("post.type"):1;
					$data['name'] = I("post.problems_name");
					$data['sort'] = I("post.sort");
					$result = M("repair_mobilebrand")->add($data);
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
					$data['mobile_bid'] = I("post.mobile_bid");
					$data['type'] = I("post.type")?I("post.type"):1;
					$data['name'] = I("post.problems_name");
					$data['sort'] = I("post.sort");
					$result = M("repair_mobilebrand")->where("mobile_bid",$data['mobile_bid'])->save($data);
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
					$mobile_bid = I("mobile_bid");
					$result = M("repair_mobilebrand")->where("mobile_bid",$mobile_bid)->delete();
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
	
	
	//对手机型号的操作
	public function  repair_mobile_product_handle(){
		if(IS_AJAX){
			$act = I("act");
			switch($act){
				case "add":
					$data['mobile_bid'] = I("post.mobile_bid");
					$data['name'] = I("post.product_name");
					$data['sort'] = I("post.sort");
					$result = M("repair_mobileproduct")->add($data);
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
					$data['mobile_pid'] = I("post.mobile_pid");
					$data['mobile_bid'] = I("post.mobile_bid");
					$data['name'] = I("post.product_name");
					$data['sort'] = I("post.sort");
					$result = M("repair_mobileproduct")->where("mobile_pid",$data['mobile_pid'])->save($data);
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
					$mobile_pid = I("mobile_pid");
					$result = M("repair_mobileproduct")->where("mobile_pid",$mobile_pid)->delete();
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
	
	//维修服务价格
	public function repair_price() {
		//查询所有价格
		$repair_price_list = M("repair_price")
							->alias("rp")
							->join("tp_repair_problems rpb","rp.problems_id = rpb.problems_id")
							->join("tp_repair_mobilebrand rmb","rp.mobile_bid = rmb.mobile_bid","left")
							->join("tp_repair_mobileproduct rmp","rp.mobile_pid = rmp.mobile_pid","left")
							->field("rp.*,rpb.name as problems_name,rmb.name as brand_name,rmp.name as product_name")
							->order("type")
							->select();
		$this->assign("repair_price_list",$repair_price_list);
		$this->assign("dataCount",count($repair_price_list));
		return $this->fetch();
	}
	
	
	//对维护价格操作
	public function  repair_price_handle(){
		if(IS_AJAX){
			$act = I("act");
			switch($act){
				case "add":
					$data['type'] = I("post.type");
					$data['problems_id'] = I("post.problems_id");
					$data['price'] = I("post.price");
					if($data['type'] > 2){
						$data['mobile_bid'] = I("post.mobile_bid");
						$data['mobile_pid'] = I("post.mobile_pid");
					}
					$result = M("repair_price")->add($data);
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
					$data['repair_price_id'] = I("post.repair_price_id");
					$data['type'] = I("post.type");
					$data['problems_id'] = I("post.problems_id");
					$data['price'] = I("post.price");
					if($data['type'] > 2){
						$data['mobile_bid'] = I("post.mobile_bid");
						$data['mobile_pid'] = I("post.mobile_pid");
					}
					$result = M("repair_price")->where("repair_price_id",$data['repair_price_id'])->save($data);
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
					$repair_price_id = I("repair_price_id");
					$result = M("repair_price")->where("repair_price_id",$repair_price_id)->delete();
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
	
	//维修费用增改
	public function repair_price_info()
	{
		$act = I('GET.act', 'add');
		$repair_price_id = I('get.repair_price_id');
		$repair_price_info = array();
		if ($repair_price_id) {
			$repair_price_info = M('repair_price')->where('repair_price_id=' . $repair_price_id)->find();
			//查询所有品牌
			$brand_list  = M("repair_mobilebrand")->where("type",$repair_price_info['type'])->select();
			//查询该品牌下的所有型号
			$product_list = M("repair_mobileproduct")->where("mobile_bid",$repair_price_info['mobile_bid'])->select();
			//查询对应问题
			if($repair_price_info['type'] < 3){
				//电脑问题
				$problems = M("repair_problems")->where("type",1)->select();
			}else{//手机问题
				$problems = M("repair_problems")->where("type",2)->select();
			}
			$act = 'edit';
		}else{
			//查询所有品牌
			$brand_list  = M("repair_mobilebrand")->where("type",3)->select();
			//查询第一个品牌下的所有型号
			$product_list = M("repair_mobileproduct")->where("mobile_bid",$brand_list[0]['mobile_bid'])->select();
			//电脑问题
			$problems = M("repair_problems")->where("type",1)->select();
		}
		
		
		$this->assign("product_list",$product_list);
		$this->assign("brand_list",$brand_list);
		$this->assign("problems",$problems);
		$this->assign("brand_list",$brand_list);
		$this->assign('info', $repair_price_info);
		$this->assign('act', $act);
		return $this->fetch();
	}


	//售后服务
	public function customer_service(){
		//查询所有问题
		$count = M("customer_service")->count();
	   	$Page  = new AjaxPage($count,20);
	   	$customer_service_list = M("customer_service")->limit($Page->firstRow.','.$Page->listRows)->order("customer_service_id desc")->select();
	   	foreach ($customer_service_list as $key => $value) {
	   		$baoxiu_info = json_decode($value['baoxiu_info'],true);
	   		$customer_service_list[$key]['customer_service_count'] = count($baoxiu_info);
	   		$min_repair_time = 0;//最早到保时间
	   		if($baoxiu_info){
	   			foreach ($baoxiu_info as $k => $v) {
		   			if(($v['baoxiu_value'] < $min_repair_time) || $min_repair_time==0){
		   				$min_repair_time = $v['baoxiu_value'];
		   			}
		   		}
	   		}

	   		$customer_service_list[$key]['min_repair_time'] = strtotime("+$min_repair_time month",strtotime(date("Y-m-d",$customer_service_list[$key]['buy_time'])));
	   	}

	   	$show = $Page->show();
	   	$this->assign("customer_service_list",$customer_service_list);
	   	$this->assign("dataCount",count($customer_service_list));
	   	$this->assign('page',$show);// 赋值分页输出
       	$this->assign('pager',$Page);
	   	return $this->fetch();
	}

	//对售后服务的操作
	public function  customer_service_handle(){
	        $act = I("act");
	        switch($act){
	            case "add":
	               	$data['phone'] = I("post.phone");
                    $data['name'] = I("post.name");
	                $data['goods_name'] = I("post.goods_name");
	                $data['goods_attr'] = I("post.goods_attr");
	                $data['goods_price'] = I("post.goods_price");
	                $data['buy_time'] = strtotime(I("post.buy_time"));
	                $data['buy_count'] = I("post.buy_count");
	                $baoxiu_name = $_POST['baoxiu_name'];
	                $baoxiu_value = $_POST['baoxiu_value'];
	                $baoxiu_info = array();
	                if($baoxiu_name){
	                	foreach ($baoxiu_name as $key => $value) {
	                		$baoxiu_info[] = array("baoxiu_name"=>$value,'baoxiu_value'=>$baoxiu_value[$key]);
	                	}
	                }
	                $data['baoxiu_info'] = json_encode($baoxiu_info);
	                $data['addtime'] = time();
	                $result = M("customer_service")->add($data);
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
	            	$customer_service_id = I("post.customer_service_id");
	                $data['phone'] = I("post.phone");
                    $data['name'] = I("post.name");
	                $data['goods_name'] = I("post.goods_name");
	                $data['goods_attr'] = I("post.goods_attr");
	                $data['goods_price'] = I("post.goods_price");
	                $data['buy_time'] = strtotime(I("post.buy_time"));
	                $data['buy_count'] = I("post.buy_count");
	                $data['status'] = I("post.status");
	                $baoxiu_name = $_POST['baoxiu_name'];
	                $baoxiu_value = $_POST['baoxiu_value'];
	                $baoxiu_info = array();
	                if($baoxiu_name){
	                	foreach ($baoxiu_name as $key => $value) {
	                		$baoxiu_info[] = array("baoxiu_name"=>$value,'baoxiu_value'=>$baoxiu_value[$key]);
	                	}
	                }
	                $data['baoxiu_info'] = json_encode($baoxiu_info);
	                $result = M("customer_service")->where("customer_service_id",$customer_service_id)->save($data);
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
	                $customer_service_id = I("customer_service_id");
	                $result = M("customer_service")->where("customer_service_id",$customer_service_id)->delete();
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
	}


	public function customer_service_info(){
		$act = I('GET.act', 'add');
	    $customer_service_id = I('get.customer_service_id');
	    $customer_service_info = array();
	    if ($customer_service_id) {
	        $customer_service_info = D('customer_service')->where('customer_service_id=' . $customer_service_id)->find();
	        $customer_service_info['baoxiu_info'] = json_decode($customer_service_info['baoxiu_info'],true);
	        $act = 'edit';
	    }
	    $this->assign('info', $customer_service_info);
	    $this->assign('act', $act);
	    return $this->fetch();
	}
}
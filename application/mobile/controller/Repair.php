<?php
/**
 * 预约维护控制器
 */ 
namespace app\mobile\controller;
use think\Request;
class Repair extends MobileBase {
    //手机预约维护
	public function mobile_repair() {
		return $this->fetch();
	}
	
	//电脑预约维护
	public function pc_repair() {
		return $this->fetch();
	}
	
	
	public function  repair_sreach(){
		$action = I("get.type_sreach");
		if($action == "pc"){
			$type[] = "台式机";
			$type[] = "笔记本";
		}else{
			$type[] = "安卓手机";
			$type[] = "苹果手机";
		}
		$this->assign("type",$type);
		return $this->fetch();
	}
	
}

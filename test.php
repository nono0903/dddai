<?php 
$payinfo['v_mid'] ="20272562"; //商户编号
   $payinfo['v_oid'] =date('ymd').mt_rand(9999,99999); //订单编号
   $payinfo['v_amount'] = 0.11;//订单总金额
   $payinfo['v_moneytype'] = "CNY";//订单币种
   $payinfo['v_url'] = "http//192.168.2.128/payback";//完成后返回值地址
  echo $payinfo['v_md5info'] = strtoupper(md5(implode('',$payinfo) ) );
 ?>
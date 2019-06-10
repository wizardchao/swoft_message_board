<?php
/**
 * Custom global functions
 */

/**
 * [getColorList description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
 function getColorList($id)
 {
     $num=(int)$id%10;
     if (in_array($num, [0,1,5,])) {
         return 'list-group-item list-group-item-success';
     }
     if (in_array($num, [2,6,9,])) {
         return 'list-group-item list-group-item-info';
     }
     if (in_array($num, [3,7,])) {
         return 'list-group-item list-group-item-danger';
     }
     if (in_array($num, [4,8,])) {
         return 'list-group-item list-group-item-warning';
     }
 }


function getPageList($page, $page_size, $total_count, $url)
{
    $page=(int)$page?:1;
    $page_max=ceil($total_count/$page_size);
    if ($page==1 && $page_max==1) {
        return '';
    }

    $page_desc='<div class="page">
            <ul class="pagination">';
    if ($page==1) {
        $page_desc.='<li class="disabled"><span>&laquo;</span></li>';
    } else {
        $page_desc.='<li><a href="$url.($page-1)">&laquo;</a></li>';
    }
    for ($i=1;$i<=$page_max;++$i) {
        if ($page==$i) {
            $page_desc.='<li class="active"><span>'.$i."</span></li>";
        } else {
            $page_desc.="<li><a href=".'"'.$url.$i.'"'.">".$i."</a></li>";
        }
    }

    if ($page==$page_max) {
        $page_desc.='<li class="disabled"><span>&raquo;</span></li>';
    } else {
        $page_desc.="<li><a href=".'"'.$url.++$page.'"'.">&raquo;</a></li>";
    }
    return $page_desc."</ul></div>";
}


/**
 * 远程获取数据，POST模式
 * @param $url 指定URL完整路径地址
 * @param $param 请求的数据
 * return 远程输出的数据
 */
function getHttpResponsePOST($url = '', $param = array()) {
    if (empty($url) || empty($param)) {
        return false;
    }
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    return $data;
}


/**
 * 远程获取数据，GET模式
 * 注意：
 * @param $url 指定URL完整路径地址
 * @param $header 头部
 * return 远程输出的数据
 */
function getHttpResponseGET($url,$header=null) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    if(!empty($header)){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    // echo curl_getinfo($curl);
    curl_close($curl);
    unset($curl);
    return $output;
}

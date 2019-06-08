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

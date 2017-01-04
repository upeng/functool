<?php
/**
 * 分页（基于bootstrap）:
 * @author 		upfriend
 * @since 	    2017-01-03
 * @package		pagination
 */

$query = array('status' => 1);
$page = $_GET['page'];
echo pagination($page, 100000, 20, $query);

/**
 * 
 * @param  [int] $page  当前页
 * @param  [int] $total 总条数
 * @param  [int] $pageSize 页大小
 * @param  [array] $otherQueryArr 其他请求参数（GET）
 * @return [string]	分页html，bootstrap下的外层加上nav标签
 */
function pagination($page, $total, $pageSize, $otherQueryArr = array()) 
{
    $renderPages = '';

    //页面总数
    $maxpage = ceil($total / $pageSize);

    //同时显示的页码数字个数
    $listnum = 5;       

    //其他GET参数拼接
    $otherQueryString = empty($otherQueryArr) ? '' : '&' . http_build_query($otherQueryArr);

    if ($maxpage > 1) 
    {
        $offset = 2;
        if ($maxpage <= $listnum) 
        {
            $from = 1;
            $to = $maxpage;
        } 
        else 
        {
            $from = $page - $offset; 		//起始页
            $to = $from + $listnum - 1;  	//终止页
            if($from < 1) 
            {
                $to = $page + 1 - $from;
                $from = 1;
                if($to - $from < $listnum) 
                {
                    $to = $listnum;
                }
            } 
            elseif($to > $maxpage) 
            {
                $from = $maxpage - $listnum + 1;
                $to = $maxpage;
            }
        }

        //首页、上一页(首页消失的时候，出现上一页) 1 2 3 4 5 下一页、尾页
        $renderPages .= $page - $offset > 1 && $maxpage >= $page ? '<li><a href="?page=1' . $otherQueryString . '" >首页</a></li>' : ''; 

        $renderPages .= $page > 1 ? '<li><a href="?page=' . ($page - 1) . $otherQueryString . '" >上一页</a></li>' : '';

        for($i = $from; $i <= $to; $i++) 
        {
            $renderPages .= $i == $page ? '<li class="active"><a href="?page=' . $i . $otherQueryString . '" >' . $i . '</a></li>' : '<li><a href="?page=' . $i . $otherQueryString . '" >' . $i . '</a></li>';
        }

        $renderPages .= $page < $maxpage ? '<li><a href="?page=' . ($page + 1) . $otherQueryString . '" >下一页</a></li>' : '';

        $renderPages .= $to < $maxpage ? '<li><a href="?page=' . $maxpage . $otherQueryString . '" class="last" >尾页</a></li>' : '';

        //页面跳转
        $renderPages .=  '<li ><a href="#" style="height:34px;padding-top:2px"><input type="text" size="4" onkeydown="if(event.keyCode==13) {self.window.location=\'?page=\'+this.value+\'' . $otherQueryString . '\'; return false;}" ></a></li>';

        $renderPages = $renderPages ? '<ul class="pagination">' . $renderPages . '</ul>' : '';
    }

    return $renderPages;
}

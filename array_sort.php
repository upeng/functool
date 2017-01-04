<?php
/**
 * 按照指定的字段对二维数组排序，很常用
 * @param  [array] $arrays 		待排序的二维数组
 * @param  [string] $sortKey 	按照sortKey字段进行排序
 * @param  [string] $sortOrder	SORT_ASC - 默认按升序排列(A-Z). SORT_DESC - 按降序排列(Z-A).
 * @param  [string] $sortType	指定排序的类型,SORT_REGULAR(默认)、SORT_NUMERIC、SORT_STRING
 * @return [array]	$arrays 	返回排序好的数组
 */
function sortBy($sortKey, $sortOrder = SORT_ASC, $sortType = SORT_REGULAR, $arrays)
{ 
	if (!is_array($arrays)) return false;
	foreach ($arrays as $array)
	{
		if (!is_array($array)) return false;
		$keyArrays[] = $array[$sortKey];
	}

	array_multisort($keyArrays, $sortOrder, $sortType, $arrays);
	return $arrays;
}


//示例：
$student = array(
	array('sid' => 10001, 'name' =>'Lily', 'chinese' => 82, 'sum'=>180),
	array('sid' => 10002, 'name' =>'Green', 'chinese' => 93, 'sum'=>150),
	array('sid' => 10003, 'name' =>'June', 'chinese' => 89, 'sum'=>156),
	array('sid' => 10004, 'name' =>'Taloy', 'chinese' => 96, 'sum'=>190),
	array('sid' => 10005, 'name' =>'Gates', 'chinese' => 84, 'sum'=>200),
);
	
//按照sum值由大到小排列
$sortBySumResult = sortBy('sum', SORT_DESC, SORT_NUMERIC, $student);
//按姓名从小到大排序
$sortByNameResult = sortBy('name', SORT_ASC, SORT_STRING, $student);

print_r($sortBySumResult);
print_r($sortByNameResult);

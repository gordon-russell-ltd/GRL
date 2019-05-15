<?
include $_SERVER['DOCUMENT_ROOT']."/inc/dbconnect.php";

$parentID=(!empty($_REQUEST["parentID"]))?addslashes($_REQUEST["parentID"]):"";
	$array = new StdClass;
if(!empty($parentID))
{
	
	$array->status = '1';
	$array->msg = 'Success';
	
	$sSQL="SELECT files_library_categoryID, title FROM files_library_category WHERE parentID = '".$parentID."' ORDER BY title";
	$result2=mysqli_query($linkDB, $sSQL) or die ("MySQL err: ".mysqli_error($linkDB)."<br>".$sSQL);
	$count = 0;
	while($row2 = mysqli_fetch_array($result2))
	{ 
		$data = new StdClass;

		$data->files_library_categoryID = $row2['files_library_categoryID'];
		$data->title = $row2['title'];

		$array->data[$count] = $data;
		$count++;
	}
}
else
{
	
	$array->status = '1';
	$array->msg = 'No Subcategories found';
}
echo json_encode($array);
?>
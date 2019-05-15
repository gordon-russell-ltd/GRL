<?
include $_SERVER['DOCUMENT_ROOT']."/inc/dbconnect.php";

$files_library_sub_categoryID=(!empty($_REQUEST["files_library_sub_categoryID"]))?addslashes($_REQUEST["files_library_sub_categoryID"]):"";
	$array = new StdClass;
if(!empty($files_library_sub_categoryID))
{
	
	$array->status = '1';
	$array->msg = 'Success';
	
	$sSQL="SELECT files_libraryID, title FROM files_library WHERE files_library_sub_categoryID = '".$files_library_sub_categoryID."' ORDER BY title";
	$result2=mysqli_query($linkDB, $sSQL) or die ("MySQL err: ".mysqli_error($linkDB)."<br>".$sSQL);
	$count = 0;
	while($row2 = mysqli_fetch_array($result2))
	{ 
		$data = new StdClass;

		$data->files_libraryID = $row2['files_libraryID'];
		$data->title = $row2['title'];

		$array->data[$count] = $data;
		$count++;
	}
}
else
{
	
	$array->status = '1';
	$array->msg = 'No Files Found';
}
echo json_encode($array);
?>
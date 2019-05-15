<?
include $_SERVER['DOCUMENT_ROOT']."/inc/dbconnect.php";
header('Content-Type: application/json');
$productsID=(!empty($_REQUEST["productsID"]))?addslashes($_REQUEST["productsID"]):"";
$files_libraryID=(!empty($_REQUEST["files_libraryID"]))?addslashes($_REQUEST["files_libraryID"]):"";
$array = new StdClass;
if(!empty($productsID) && !empty($files_libraryID))
{
	$sSQL="SELECT products_files_libraryID FROM products_files_library
						WHERE productsID = '".$productsID."' AND files_libraryID = '".$files_libraryID."'";
	$result2=mysqli_query($linkDB, $sSQL) or die ("MySQL err: ".mysqli_error($linkDB)."<br>".$sSQL);
	if($row2 = mysqli_fetch_array($result2))
	{ 
		$sSQL="DELETE FROM products_files_library
							WHERE products_files_libraryID = '".$row2["products_files_libraryID"]."' AND productsID = '".$productsID."' AND files_libraryID = '".$files_libraryID."'";
		mysqli_query($linkDB, $sSQL) or die ("MySQL err: ".mysqli_error($linkDB)."<br>".$sSQL);
		$array->status = '1';
		$array->msg = 'File removed from this product';
	}
	else
	{
		$array->status = '0';
		$array->msg = 'File is not assigned.';
	}
}
else
{
	
	$array->status = '0';
	$array->msg = 'Something went worong. Missing file or product.';
}
echo json_encode($array);
?>
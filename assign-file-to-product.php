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
		$array->status = '0';
		$array->msg = 'This file already assigned to this product';
	}
	else
	{
		$sSQL_ins = "INSERT INTO products_files_library (dateCreated, productsID, files_libraryID)
																							VALUES(NOW(), '".$productsID."', '".$files_libraryID."')";
		mysqli_query($linkDB, $sSQL_ins) or die ("MySQL err: ".mysqli_error($linkDB)."<br>".$sSQL_ins);
		
		
		$sSQL2="SELECT products_files_library.products_files_libraryID, files_library.files_libraryID, files_library.title,
										files_library_categoryID, files_library_sub_categoryID, file
							FROM products_files_library
							JOIN files_library USING(files_libraryID)
							WHERE productsID = '".$productsID."' AND files_libraryID = '".$files_libraryID."'";
		$result2=mysqli_query($linkDB, $sSQL2) or die ("MySQL err: ".mysqli_error($linkDB)."<br>".$sSQL2);
		$count = 0;
		if($row2 = mysqli_fetch_array($result2))
		{
			$data = new StdClass;
	
			$data->products_files_libraryID = $row2['products_files_libraryID'];
			$data->files_libraryID = $row2['files_libraryID'];
			$data->title = $row2['title'];
			$data->file_path = $row2['file'];
			$data->files_library_categoryID = $row2['files_library_categoryID'];
			$data->files_library_sub_categoryID = $row2['files_library_sub_categoryID'];
	
			$array->data[$count] = $data;
			$count++;
		}
		$array->status = '1';
		$array->msg = 'File is assigned.';
	}
}
else
{
	
	$array->status = '0';
	$array->msg = 'Something went worong. Missing file or product.';
}
echo json_encode($array);
?>
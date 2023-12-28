<?php
	$name=$_GET['filename'];

	$filePath='./upload/'.$name;
	$fileSize=filesize($filePath);
	$pathParts= pathinfo($filePath);
	$fileName = $pathParts['basename'];
	$extension = $pathParts['extension'];

	header("Pragma: public");
	header("Expires: 0");
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$fileName");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: $filesize");

	ob_clean();
	flush();
	readfile($filePath);
?>
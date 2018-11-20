<?php
	require('../vendor/autoload.php');

	$s3 = Aws\S3\S3Client::factory(array(
		'region' => getenv('BUCKETEER_AWS_REGION'),
		'version' => 'latest',
	    'credentials' => array(
	        'key'    => getenv('BUCKETEER_AWS_ACCESS_KEY_ID'),
	        'secret' => getenv('BUCKETEER_AWS_SECRET_ACCESS_KEY'),
	    )
	));

	$bucket = getenv('BUCKETEER_BUCKET_NAME')?: die('No "S3_BUCKET" config var in found in env!');
	
	$files_uploaded = Array();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_FILES['file1']) && $_FILES['file1']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file1']['tmp_name'])) {
		    try {
		        $upload = $s3->upload($bucket, microtime()."-1-".$_FILES['file1']['name'], fopen($_FILES['file1']['tmp_name'], 'rb'), 'public-read');
				$files_uploaded["file1"] = htmlspecialchars($upload->get('ObjectURL'));
			} catch(Exception $error) {
				$files_uploaded["file1"] = $error;
			}
		}
		
		if(isset($_FILES['file2']) && $_FILES['file2']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file2']['tmp_name'])) {
		    try {
		        $upload = $s3->upload($bucket, microtime()."-2-".$_FILES['file2']['name'], fopen($_FILES['file2']['tmp_name'], 'rb'), 'public-read');
				$files_uploaded["file2"] = htmlspecialchars($upload->get('ObjectURL'));
			} catch(Exception $error) {
				$files_uploaded["file2"] = $error;
			}
		}
		
		if(isset($_FILES['file3']) && $_FILES['file3']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file3']['tmp_name'])) {
		    try {
		        $upload = $s3->upload($bucket, microtime()."-3-".$_FILES['file3']['name'], fopen($_FILES['file3']['tmp_name'], 'rb'), 'public-read');
				$files_uploaded["file3"] = htmlspecialchars($upload->get('ObjectURL'));
			} catch(Exception $error) {
				$files_uploaded["file3"] = $error;
			}
		}
	}
	
	echo json_encode($files_uploaded);
?>
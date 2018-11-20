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
	
	if(	$_SERVER['REQUEST_METHOD'] == 'POST' &&
		isset($_FILES['file1']) &&
		$_FILES['file1']['error'] == UPLOAD_ERR_OK &&
		is_uploaded_file($_FILES['file1']['tmp_name'])
	) {
	    try {
	        $upload = $s3->upload($bucket, microtime().$_FILES['file1']['name'], fopen($_FILES['file1']['tmp_name'], 'rb'), 'public-read');
			echo htmlspecialchars($upload->get('ObjectURL'));
		} catch(Exception $error) {
			echo $error;
		}
	}
?>
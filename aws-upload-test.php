<?php
require('vendor/autoload.php');

$s3 = Aws\S3\S3Client::factory(array(
	'region' => getenv('BUCKETEER_AWS_REGION'),
	'version' => 'latest',
    'credentials' => array(
        'key'    => getenv('BUCKETEER_AWS_ACCESS_KEY_ID'),
        'secret' => getenv('BUCKETEER_AWS_SECRET_ACCESS_KEY'),
    )
));

$bucket = getenv('BUCKETEER_BUCKET_NAME')?: die('No "S3_BUCKET" config var in found in env!');
?>
<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <h1>S3 upload example</h1>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    // FIXME: add more validation, e.g. using ext/fileinfo
    try {
        // FIXME: do not use 'name' for upload (that's the original filename from the user's computer)
        $upload = $s3->upload($bucket, $_FILES['userfile']['name'], fopen($_FILES['userfile']['tmp_name'], 'rb'), array('contentType' => 'image/jpeg', 'ACL' => 'public-read'));
?>
        <p>Upload <a href="<?=htmlspecialchars($upload->get('ObjectURL'))?>">successful</a> :)</p>
<?php } catch(Exception $e) { ?>
        <p>Upload error: <?php echo $e; ?></p>
<?php } } ?>
        <h2>Upload a file</h2>
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input name="userfile" type="file"><input type="submit" value="Upload">
        </form>
    </body>
</html>
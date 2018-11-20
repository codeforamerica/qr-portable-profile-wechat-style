<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <h1>S3 upload example</h1>
        <h2>Upload a file</h2>
        <form enctype="multipart/form-data" action="controllers/upload-file.php" method="POST">
            <input name="userfile" type="file"><input type="submit" value="Upload">
        </form>
    </body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>Excel file in database</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">	
</head>
<body>
<div class="container">

    <?php include('config.php'); ?>
    <?php
    if(isset($_POST['uploadBtn'])){
        $fileName = $_FILES['myFile']['name'];
        $fileTmpName = $_FILES['myFile']['tmp_name'];
        //the extension of the file
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        //what is the extension
        //echo $fileExtention;
        //define the allowed extension
        $allowedType = array('csv');
        if(!in_array($fileExtension, $allowedType)){?>
           <div class="alert alert-danger">
               Invalid File Extension
           </div>
    <?php } else {
            //upload your file
            $handle = fopen($fileTmpName, 'r'); //read
            while (($myData = fgetcsv($handle,1000,',')) !== False) {

                $name = $myData[0];
                $prenom = $myData[1];
                $age = $myData[2];
                $fonction = $myData[3];
                $email = $myData[4];
                $adresse = $myData[5];
                $Tel = $myData[6];

                $query = "insert into excel_table(nom,prenom,age,fonction,email,adresse,telephone) values ('".$name."','".$prenom."','".$age."','".$fonction."','".$email."','".$adresse."','".$Tel."') ";
                $run = mysqli_query($connection, $query);
            }
            if (!$run){
                die("error in uploading file".mysqli_error());
            } else{?>
                <div class="alert alert-success">
                    File uploaded Succesfully !!
                </div>
            <?php }
    }
    }
    ?>
	<form action="" method="POST" enctype="multipart/form-data">
        <h3 class="text-center">
            Upload Your File
        </h3><hr/>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="file" name="myFile" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="submit" name="uploadBtn" class="btn btn-info">
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
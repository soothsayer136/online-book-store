<?php session_start();
include_once('includes/config.php');
if(strlen( $_SESSION["aid"])==0)
{   
header('location:logout.php');
} else {
//For Adding Products
if(isset($_POST['submit']))
{
$currentimage=$_POST['currentimage'];
$imagepath="productimages"."/".$currentimage;
$bookimage1=$_FILES["bookimage1"]["name"];
$extension1 = substr($bookimage1,strlen($bookimage1)-4,strlen($bookimage1));
//Renaming the  image file
$imgnewfile=md5($bookimage1.time()).$extension1;
move_uploaded_file($_FILES["bookimage1"]["tmp_name"],"productimages/".$imgnewfile);
$updatedby=$_SESSION['aid'];
$pid=intval($_GET['id']);
$sql=mysqli_query($con,"update tblbooks set BookImage1='$imgnewfile', lastUpdatedBy='$updatedby' where id='$pid'");
unlink($imagepath);
echo "<script>alert('Book image updated successfully');</script>";
echo "<script>window.location.href='manage-books.php'</script>";
}








?>

<!DOCTYPE html>
<html lang="en">
    <head>
       
        <title>Muna Madan Bookstore | Update Image</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/all.min.js" crossorigin="anonymous"></script>
        <script src="js/jquery-3.5.1.min.js"></script>   

    </head>
    <body>
   <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
   <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Update Image</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Image</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">


<?php 
$pid=intval($_GET['id']);
$query=mysqli_query($con,"select tblbooks.BookImage1,tblbooks.BookName from tblbooks  where  tblbooks.id='$pid' ");
while($row=mysqli_fetch_array($query))
{
?>                                 
<form  method="post" enctype="multipart/form-data">                                

<input type="hidden" name="currentimage" value="<?php echo htmlentities($row['BookImage1']);?>">
<div class="row" style="margin-top:1%;">
<div class="col-2">Book Name</div>
<div class="col-4"><input type="text"    name="BookName"  value="<?php echo htmlentities($row['BookName']);?>" class="form-control" required>
</select>
</div>
</div>



<div class="row" style="margin-top:1%;">
<div class="col-2">Book Featured Image</div>
<div class="col-4"><img src="productimages/<?php echo htmlentities($row['BookImage1']);?>" width="250"><br />
</div>
</div>

<div class="row" style="margin-top:1%;">
<div class="col-2">Book Featured Image</div>
<div class="col-4"><input type="file" name="bookimage1" id="bookimage1"  class="form-control" accept="image/*" title="Accept images only" required>
</div>
</div>


<div class="row">
<div class="col-2"><button type="submit" name="submit" class="btn btn-primary">Update</button></div>
</div>

</form>
      
      <?php } ?>                      </div>
                        </div>
                    </div>
                </main>
          <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>

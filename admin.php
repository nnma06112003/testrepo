<?php 
session_start();
if(isset($_SESSION['iduser']) && isset($_SESSION['username']) && isset($_SESSION['password']))
{
	include ("myclass/clslogin.php");
	$p=new login();
	$p->confirmLogin($_SESSION['iduser'],$_SESSION['username'],$_SESSION['password']);
}
else
{
	header("location: login.php");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Nguyen Ngoc Minh Anh</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="container">
	<div class="banner">
    	<a href="index.php"> Trang chu </a>
    	<a href="admin.php"> Quan ly </a>
        <a href="login.php"> Dang nhap </a>
    </div>
    <div class="main" align="center">
	<a href="?idcty">Quan ly danh muc</a><br>
    <a href="?idsp">Quan ly san pham</a><br>
    <a href="?iduser">Quan ly khach hang</a><br>
      <?php
	  include ("myclass/clsadmin.php");
	  $p=new admin();
	  if(isset($_REQUEST['idcty']))
	  {
		$p->formCate();
		echo '<br><br>';
		$p->listCate("select * from congty order by idcty asc");
	  }
	  if(isset($_REQUEST['idsp']))
	  {
		$p->formProd();
		echo '<br><br>';
		$p->listProd("select * from sanpham order by idsp asc");
		switch($_REQUEST['btn'])
		{
			case 'Them':
			{
				$file=$_FILES['file'];
				$tmp_name=$file['tmp_name'];
				$name=$file['name'];
				$name=time().'-'.$name;
				$tensp=$_REQUEST['txtTensp'];
				$gia=$_REQUEST['txtGia'];
				$mota=$_REQUEST['txtMota'];
				$giamgia=$_REQUEST['txtGiamgia'];
				$idcty=$_REQUEST['danhmuc'];
				if($p->uploadImg($name,$tmp_name,'img'))
				{
					if($p->crud("INSERT INTO sanpham (tensp ,gia ,mota ,hinh ,giamgia ,idcty) VALUES ('$tensp', '$gia', '$mota', 		                     '$name', '$giamgia', '$idcty')"))
					{
						echo "Them san pham thanh cong!";
						header('Refresh:0');
					}
					else
					{
						echo "Them san pham that bai!";
					}
					
				}
				else
				{
					echo"upload anh khong thanh cong!";
				}
				break;
			}
			case 'Xoa':
			{
				$idDel=$_REQUEST['idsp'];
				$hinh=$p->getRow("select hinh from sanpham where idsp='$idDel'");
				if($p->crud("delete from sanpham where idsp='$idDel'"))
				{
					unlink("img/$hinh");
					header("Refresh:0");
				}
				else
				{
					echo "Xoa khong thanh cong!";
				}
				break;
			}
			case 'Sua':
			{
				$file=$_FILES['file'];
				$tmp_name=$file['tmp_name'];
				$name=$file['name'];
				$name=time().'-'.$name;
				$tensp=$_REQUEST['txtTensp'];
				$gia=$_REQUEST['txtGia'];
				$mota=$_REQUEST['txtMota'];
				$giamgia=$_REQUEST['txtGiamgia'];
				$idcty=$_REQUEST['danhmuc'];
				if($p->uploadImg($name,$tmp_name,'img'))
				{
					if($p->crud("update sanpham set tensp='$tensp', gia='$gia', mota='$mota', giamgia='$giamgia', idcty='$idcty'"))
					{
						echo "Sua thanh cong!";
						header("Refresh:0");
					}
					else
					{
						echo "Sua that bai!";
					}
				}
				break;
			}
		}
	  }
	  ?>
    </div>
    <div class="footer"></div>
</div>
</body>
</html>
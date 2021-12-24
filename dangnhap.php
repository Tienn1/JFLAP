<?php
require 'site.php';
load_top();
load_header();
load_menu();
?>
<html>
<head>Hãy đăng nhập</head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<link rel="stylesheet" href="style.css"/> 
</head> 
<body> 
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="dangnhap" method='POST'> 
Tên đăng nhập : <input type='text' name='username' /> 
Mật khẩu : <input type='password' name='password' /> 
<a href='xemdiem.php'/><input type='submit' class='button' name='dangnhap' value='Đăng nhập' /> 
<h><br><br></h>
</form>
</body>
<?php
if (isset($_POST['username']) && isset($_POST['password']))
{
	
	//1. Lấy dữ liệu từ form lên.
	$tendangnhap = $_POST["username"];
	$matkhaudn = $_POST["password"];
		
		
	//2. Kết nối dữ liệu 
	$conn = mysqli_connect("localhost", "root", "", "sinhvien") or die("Kết nối không thành công");
	
	//3. Thiết lập bảng mã cho kết nối
	mysqli_query($conn, "set name 'utf8'");
	
	//4. Xây dựng câu lệnh sql
	// Kiểm tra nếu người dùng đã ân nút đăng nhập thì mới xử lý
	if (isset($_POST["dangnhap"])) {
		//làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
		//mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
		$tendangnhap = strip_tags($tendangnhap);
		$tendangnhap = addslashes($tendangnhap);
		$matkhaudn = strip_tags($matkhaudn);
		$matkhaudn = addslashes($matkhaudn);
		if ($tendangnhap == "" || $matkhaudn =="") 
		{
			echo "Tên đăng nhập hoặc mật khẩu bạn không được để trống!";
		}
		else
		{
			$sql = "select * from taikhoan where tendn = '".$tendangnhap."' and password = '".$matkhaudn."' ";
			$query = mysqli_query($conn,$sql);
			$num_rows = mysqli_num_rows($query);
			if ($num_rows==0) {
				echo "Tên đăng nhập hoặc mật khẩu không đúng !";
			}
			else
			{
				//tiến hành lưu tên đăng nhập vào session để tiện xử lý sau này
				$_SESSION['dn'] = $tendangnhap;
				echo "Xin chào <b>" .$tendangnhap . "</b>. Bạn đã đăng nhập thành công. <a href=''>Thoát</a>";
				die();
                // Thực thi hành động sau khi lưu thông tin vào session
                // ở đây mình tiến hành chuyển hướng trang web tới một trang  vd gọi là index.php
			}
		}
	}
	//5.Đóng kết nối
	mysqli_close($conn);
}
?>
</html>
<?php
load_footer();
?>
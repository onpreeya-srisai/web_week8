<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    h1 {
        /* border: 2px solid #dddddd; */
        font-family: arial, sans-serif;
        text-align: center;
        padding-top: 50px;
        padding-bottom: 20px;
        /* font-size: 20px; */
    }
    h4 {
        /* border: 2px solid #dddddd; */
        font-family: arial, sans-serif;
        text-align: center;
        /* font-size: 20px; */
    }
    th,td {
        border: 2px solid #dddddd;
        text-align: center;
        font-size: 20px;
        padding: 8px;
    }
    tr:hover {
        background-color: #f5ebe0;
    }
</style>

<body>
<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "shop";
    $per_page=10;

    if(isset($_GET["page"])) $start_page=$_GET["page"]*$per_page;
    else $start_page=0;
    
    $con=mysqli_connect($servername,$username,$password,$dbname);
    if(!$con) die("Connnect mysql database fail!!".mysqli_connect_error());
    // echo "Connect mysql successfully!";
    echo "<h1>Welcome to CANOTWAIT_</h1>";
    $sql="SELECT * FROM product";
    $result=mysqli_query($con,$sql);
    $numrow=mysqli_num_rows($result);
    // echo "<br>".$numrow." Records<br>";
    
    // echo $_GET["page"]."<br>";
    $pageNow = $_GET["page"];
    $n_pages =$pageNow+1;
    $p_pages =$pageNow-1;
    // echo ceil($numrow/$per_page)."<br>";
    echo "<p style='text-align:center;font-family: arial, sans-serif;'>";
    if($pageNow>0){
        echo "<a href='show_product.php?page=$p_pages'>PREVIOUS</a>";
    }

    for($i=0;$i<ceil($numrow/$per_page);$i++){
        echo "<a href='show_product.php?page=$i'>[".($i+1)."]</a>";
    }

    if($n_pages<ceil($numrow/$per_page)){
        echo "<a href='show_product.php?page=$n_pages'>NEXT</a>";
    }
    echo "</p>";
    echo "<p style='text-align:center;font-family: arial, sans-serif;'>page ".($pageNow+1)."</p>";

    $sql="SELECT * FROM product LIMIT $start_page,$per_page";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)>0){
        
        echo "<table border=1><tr><th>id</th><th>name</th><th>description</th><th>price</th><th>picture</th><th></th></tr>";
        while($row=mysqli_fetch_assoc($result)){
        echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>";
        echo $row["description"]."</td><td>".$row["price"]."</td><td>";
        echo "<img src='".$row["picture"]."' width=200></td><td>";
        echo "<a href='add_product.php?id=".$row["id"]."'>ใส่ตระกร้า</a></td></tr>";
        }
        echo "</table>";
    }else{
        echo "0 results";
    }
    if(isset($_SESSION["cart"])){
    $total=0;
    echo "<h1>ตระกร้าสินค้า</h1>";
    echo "<table><tr><th>ลำดับ</th><th>id</th><th>name</th><th>description</th><th>price</th></tr>";
        for($i=0;$i<count($_SESSION["cart"]);$i++)
        {
            $item=$_SESSION["cart"][$i];
            echo "<tr><td>".($i+1)."</td>";
            echo "<td>".$item['id']."</td>";
            echo "<td>".$item['name']."</td>";
            echo "<td>".$item['description']."</td>";
            echo "<td>".$item['price']."</td></tr>";
            echo "<td><a href='del_cart.php?i=".$i.">'";
            echo "<font color='red'>x</font></a></td></tr>";
            $total+=$item['price'];
        }
    echo "</table>";
    echo "<h1>ราคาสินค้า $total บาท</h1>";
    }
    echo "<p style='text-align:center;font-family: arial, sans-serif;'>";
    if($pageNow>0){
        echo "<a href='show_product.php?page=$p_pages'>PREVIOUS</a>";
    }

    for($i=0;$i<ceil($numrow/$per_page);$i++){
        echo "<a href='show_product.php?page=$i'>[".($i+1)."]</a>";
    }

    if($n_pages<ceil($numrow/$per_page)){
        echo "<a href='show_product.php?page=$n_pages'>NEXT</a>";
    }
    echo "</p>";
    echo "<p style='text-align:center;font-family: arial, sans-serif;'>page ".($pageNow+1)."</p>";
    mysqli_close($con);
?>
</body>
</html>
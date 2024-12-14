<?php include "displayTable.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/dashboard-style.css">
</head>
<body>
    <div class="half-circle"></div>
    <div class="headerwrapper">
        <div class="header">
            <nav class="dash-nav">
                <a class="button-menu-href" href="dashboard.php"><img class="button-menu" src="src/svg/icon-homeicon.svg" alt=""></a>
                <a class="button-profile-href" href="login.html"><img class="button-profile" src="src/svg/profile-icon.svg" alt="">logout</a>
            </nav>
        </div>
        <div class="section">
            <div class="wrapper">
                <div class="profile-container">
                    <span class="profile-container-span">
                        <img class="profile-picture" src="src/img/profile-sample.jpeg" alt="">
                        <span class="profile-text-box">
                            <h1>User list</h1>
                            <p>Click on any row to edit or delete.</p>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="message-alert-container">
        <div class="table-container">
            <form class="searchbar-container">
                <p>Search: <input type="text" placeholder="Username, Email" name="searchbar" value="<?php echo isset($_GET['searchbar']) ? htmlspecialchars($_GET['searchbar'], ENT_QUOTES) : '';?>"></p>
            </form>
            <table class="php-table">
                <tr>
                    <th>Fingerpint Index</th>
                    <th>Name</th>
                </tr>
                <?php 
                $count = 0;
                while($row = $result->fetch_assoc()){ ?>

                    <tr onclick="window.location='http://localhost/ProjectDashboard/editUser.php?email=<?php echo $row["name"] ?>';" id="rows-table"  <?php if ($count % 2 == 0) echo 'class="even-color"';?>>
                    <input type="hidden" name="username" value=<?php echo $row['name'];?>>
                    <!-- lists specific columns -->
                        <td><?php echo $row['indexFingerprint'];?></td>
                        <td><?php echo $row['name'];?></td>
                    </tr>

                <?php $count++; }?>
            </table>
            <div class="pagehere">
                <div class="page-info">
                    <?php 
                        if(!isset($_GET['page-nr'])){
                            $_GET['page-nr'] = 1;
                            $page = 1;
                        }else{
                            $page = $_GET['page-nr'];
                        }
                    ?>
                    Showing <?php echo $page ?> of <?php echo $pages ?>
                </div>
                <div class="pagination">
                    <!-- first page -->
                     <?php if(isset($_GET['searchbar'])){?>
                        <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=1">First</a>
                    <?php } else{?>
                        <a href="?page-nr=1">First</a>
                    <?php }?>

                    <!-- previous page -->

                    <?php if(isset($_GET['page-nr']) && $_GET['page-nr'] > 1){ 
                        if(isset($_GET['searchbar'])){?>
                            <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a>
                        <?php } else{ ?>
                            <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a>
                        <?php } }
                        else{
                        ?>
                            <a href="">Previous</a>
                        <?php } ?>

                    <!-- output the page numbers -->
                    <div class="page-numbers">

                        <?php 
                            for($i = 1; $i <= $pageVisible; $i++){
                                
                                if ( $_GET['page-nr'] > $pageMiddle && $_GET['page-nr'] < $pages-1 ){?> 
                                    <a class="page<?php echo $_GET['page-nr']-$pageMiddle + $i ?>" href="?page-nr=<?php echo $_GET['page-nr']-$pageMiddle + $i ?>"><?php echo $_GET['page-nr']-$pageMiddle + $i ?></a> <?php ; continue; }
                                if( $_GET['page-nr'] <= $pageMiddle ){?> 
                                    <a class="page<?php echo $i ?>" href="?page-nr=<?php echo $i ?>"><?php echo $i ?></a> <?php ; continue; }
                                if( $_GET['page-nr'] >= $pages-1 ){?>
                                    <a class="page<?php echo $pages - $pageVisible + $i ?>" href="?page-nr=<?php echo $pages - $pageVisible + $i ?>"><?php echo $pages - $pageVisible + $i ?></a> <?php ; continue; }
                                ?>
                        <?php }?>

                    </div>

                    <!-- next page -->
                    <?php 
                    
                        if(!isset($_GET['page-nr'])){ 
                            if(isset($_GET['searchbar'])){ ?>
                                <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=2">Next</a>
                            <?php } else{?>
                                <a href="?page-nr=2">Next</a>
                            <?php }?>
                     <?php }else{
                        if($_GET['page-nr'] >= $pages){  ?>
                            <a href="">Next</a>
                        

                    <?php }else{
                        if(isset($_GET['searchbar'])){ ?>
                                <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=<?php echo $_GET['page-nr'] + 1 ?>">Next</a>
                            <?php } else{?>
                                <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>">Next</a>
                            <?php }?>
                    <?php } } ?> 

                    <!-- last page -->
                    <?php if(isset($_GET['searchbar'])){ ?>
                                <a href="?searchbar=<?php echo $_GET['searchbar']?>&page-nr=<?php echo $pages?>">Last</a>
                            <?php } else{?>
                                <a href="?page-nr=<?php echo $pages?>">Last</a>
                            <?php }?>
                </div>
            </div>
        </div>
        
    </div>
     <script>
        let links = document.querySelectorAll('.page<?php echo $_GET['page-nr']?>');
        links[0].classList.add("active");
     </script>                   
</body>
</html>
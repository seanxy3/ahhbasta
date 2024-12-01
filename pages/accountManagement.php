<?php
  include("../phpFiles/dbConnect.php");
  include("../pages/login.php");
  
  $searchKeyword = isset($_GET['searchKeyword']) ? $_GET['searchKeyword'] : '';

  $recordPerPage = 13;  
    
    if (isset($_GET["page"])) {    
        $page = $_GET["page"];    
    }    
    else {    
        $page = 1;    
    }    

  $startPage = ($page-1) * $recordPerPage;

  //normal function
  $sql = "SELECT accountID, accFirstName, accLastName, accEmail,  accPassword, accRole FROM accounts";
          
  //search if search not empty
  if (!empty($searchKeyword)) {
      $sql .= " WHERE accFirstName LIKE '%$searchKeyword%' OR accLastName LIKE '%$searchKeyword%' OR accEmail LIKE '%$searchKeyword%' OR accPassword LIKE '%$searchKeyword%' OR accRole LIKE '%$searchKeyword%'";
  }

  $sql .= " LIMIT $startPage, $recordPerPage;";

  $result = $conn->query($sql);
  $totalRecords = mysqli_num_rows($result);

  if (!$result) {
      die("Error in SQL query: " . $conn->error);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include("../pages/header.php");?>
    <link rel="stylesheet" href="../styles/transaction.css">
</head>
<body>
    <div class="container">
        <?php include('adminSidebar.php'); ?>    
        <main>
          <h1>Account Management</h1>
          <div class="main-content">
            <div class="contain">
            <div class="button">
                        <a href="addAccount.php"><i class="fa-solid fa-plus"></i></a>
                    </div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="search">
                <input type="text" name="searchKeyword" value="<?php echo $searchKeyword; ?>" placeholder="  Search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </form>
            </div>
            <?php
              echo "<table>";
              echo "<tr><th>Account ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Role</th><th>Action</th>";
              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["accountID"] . "</td>";
                    echo "<td>" . $row["accFirstName"] . "</td>";
                    echo "<td>" . $row["accLastName"] . "</td>";
                    echo "<td>" . $row["accEmail"] . "</td>";
                    echo "<td>" . $row["accPassword"] . "</td>";
                    echo "<td>" . $row["accRole"] . "</td>";
  
                    echo "</td>";
  
                    echo "<td>
                            <div class='action-buttons'>
                                <button class='edit'><a href='./editAccount.php?accountID=$row[accountID]'><i class='fas fa-edit'></i></a></button>
                                <button class='delete' onclick = 'return confirm(\"Are you sure you want to delete this account?\");'><a href='./deleteAccount.php?accountID=$row[accountID]'><i class='fa-solid fa-trash'></i></a></button>
                          </td>";
                    echo "</tr>";
                    
                  }
                  echo "</div>";
                  echo "</table><br>";
              } else {
                  echo "<tr><td colspan = '7' id = 'noRes'>No Results</td></tr>";
                  echo "</table><br>";
              }
            ?>
          </div>
          <div class = "paginationCont">
              <div class = "paginationMain">
                  <?php
                      $query = "SELECT COUNT(*) FROM accounts";
                      $baseUrl = "accountManagement.php";
                      if (!empty($searchKeyword)) {
                          $query .= " WHERE accFirstName LIKE '%$searchKeyword%' OR accLastName LIKE '%$searchKeyword%' OR accEmail LIKE '%$searchKeyword%' OR accPassword LIKE '%$searchKeyword%' OR accRole LIKE '%$searchKeyword%'";
                          $baseUrl .= "?searchKeyword=$searchKeyword";
                      }else{
                          $baseUrl .= "?";
                      }
                      include("../pages/pagination.php");
                  ?>    
              </div>
          </div>
        </main> 
  </div>

</body>
</html>
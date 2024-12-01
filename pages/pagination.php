<?php
include("../phpFiles/dbConnect.php");

$query .= ";";  
$countRes = mysqli_query($conn, $query);     
$row = mysqli_fetch_row($countRes);     
$totalRecords = $row[0];   

$totalPages = ceil($totalRecords / $recordPerPage);      

$start = max(1, $page - 2);
$end = min($start + 4, $totalPages);

    if($end > $totalPages){
        $end = $totalPages;
    }

    if ($totalPages - $page < 4) {
        $start = max(1, $totalPages - 4);
        $end = $totalPages;
    }

    if($page>=2){
        echo "<a class = 'notActive' href='$baseUrl&page=1'> << </a>";
        echo "<a class = 'notActive' href='$baseUrl&page=".($page-1)."'> < </a>";   
        
    }       
            
    for ($i=$start; $i<=$end; $i++) {   
        if ($i == $page) {   
            $status = 'active';
        }               
        else {   
            $status = 'notActive';
        }
        echo "<a class = '$status' href='$baseUrl&page=".$i."'><p>".$i."</p></a>";
    }    

    if($page<$totalPages){
        echo "<a class = 'notActive' href='$baseUrl&page=".($page+1)."'> > </a>"; 
        echo "<a class = 'notActive' href='$baseUrl&page=$totalPages'> >> </a>";   
    }
?>
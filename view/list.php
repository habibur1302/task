<?php  session_start();;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />    
    <link rel="stylesheet" href="~/../libs/bootstrap.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="~/../libs/jquery.min.js"></script>
    <script src="~/../libs/bootstrap.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style type="text/css">
        .wrapper{
            width: 100%;
            margin: 0 auto;
        }
        .mt{
            margin-left: 40px;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $( "#datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
            $( "#datepicker2" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <a href="index.php" class="btn btn-success pull-left">Home</a>
                        <h2 class="pull-left mt">Buyer Details</h2>
                        <a href="view/insert.php" class="btn btn-success pull-right">Add New Buyer</a>
                    </div>
                    <form class="form-inline" action="./index.php?act=list" method="get">
                        <div class="form-group mb-2">
                            <label for="date_from">Date From:</label>
                            <input type="text" name="date_from" value="<?php echo isset($_SESSION['date_from']) ? $_SESSION['date_from'] : ''?>" class="form-control-plaintext" autocomplete="off" id="datepicker">
                        </div>
                        <div class="form-group mb-2">
                            <label for="date_to">Date TO:</label>
                            <input type="text" name="date_to" value="<?php echo isset($_SESSION['date_to']) ? $_SESSION['date_to'] : ''?>" class="form-control-plaintext" autocomplete="off" id="datepicker2">
                        </div>
                        <div class="form-group mb-2">
                            <label for="date_to">User ID:</label>
                            <input type="number" name="id" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''?>" class="form-control-plaintext" autocomplete="off" id="datepicker2">
                        </div>
                        <button type="submit" class="btn btn-primary">search</button>
                    </form>
                    <?php
                        if($result->num_rows > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Amount</th>";
                                        echo "<th>Buyer</th>";
                                        echo "<th>Receipt ID</th>";
                                        echo "<th>Items</th>";
                                        echo "<th>Buyer Email</th>";
                                        echo "<th>Buyer IP</th>";
                                        echo "<th>Note</th>";
                                        echo "<th>City</th>";
                                        echo "<th>Phone</th>";
                                        echo "<th>Entry At</th>";
                                        echo "<th>Entry By</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                //$i = 0;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "<td>" . $row['buyer'] . "</td>";
                                        echo "<td>" . $row['receipt_id'] . "</td>";
                                        echo "<td>" . $row['items'] . "</td>";
                                        echo "<td>" . $row['buyer_email'] . "</td>";
                                        echo "<td>" . $row['buyer_ip'] . "</td>";
                                        echo "<td>" . $row['note'] . "</td>";
                                        echo "<td>" . $row['city'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['entry_at'] . "</td>";
                                        echo "<td>" . $row['entry_by'] . "</td>";
                                        //echo "<td>";
                                        //echo "<a href='index.php?act=update&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";
                                        //echo "<a href='index.php?act=delete&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><i class='fa fa-trash'></i></a>";
                                        //echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
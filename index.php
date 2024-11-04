<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        .search-box{
            margin-bottom: 15px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            
            // Функция фильтрации
            function filterTable() {
                let nameInput = $('#nameSearch').val().toLowerCase();
                let descInput = $('#descSearch').val().toLowerCase();
                let salaryInput = $('#salarySearch').val().toLowerCase();

                $('#dataTable tbody tr').filter(function() {
                    $(this).toggle(
                        ($(this).find("td:eq(1)").text().toLowerCase().indexOf(nameInput) > -1) &&
                        ($(this).find("td:eq(2)").text().toLowerCase().indexOf(descInput) > -1) &&
                        ($(this).find("td:eq(3)").text().toLowerCase().indexOf(salaryInput) > -1)
                    );
                });
            }

            // Привязываем событие ввода к полям поиска
            $('#nameSearch, #descSearch, #salarySearch').on('keyup', filterTable);
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Descriptions Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Description</a>
                    </div>
                    <!-- Поля поиска -->
                    <div class="search-box">
                        <div class="form-group">
                            <input type="text" id="nameSearch" class="form-control" placeholder="Search by Name">
                        </div>
                        <div class="form-group">
                            <input type="text" id="descSearch" class="form-control" placeholder="Search by Description">
                        </div>
                        <div class="form-group">
                            <input type="text" id="salarySearch" class="form-control" placeholder="Search by Salary">
                        </div>
                    </div>

                    <?php
                    // Подключение к конфигурации
                    require_once "config.php";
                    
                    // Запрос к базе данных
                    $sql = "SELECT * FROM things";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table id="dataTable" class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Salary</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Закрываем соединение
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

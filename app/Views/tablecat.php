<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <table id="catdataa" class="table table-hover table-bordered border-dark ">
                    <tr>
                        <?php
                        foreach ($tablehead as $tablehead) {
                        ?> <th scope="col">
                                <?php

                                echo $tablehead['COLUMN_NAME'];
                                ?>
                            </th>

                        <?php
                        }
                        ?>
                    </tr>
                    <?php

                    foreach ($finalres as $finalres) {
                    ?>
                        <tr>
                            <?php
                            for ($i = 0; $i < count($finalres); $i++) {
                                // echo" this is ID->". $i . "<br>";
                            ?><td style="word-break:break-all;" scope="row">
                                    <?php echo (string) htmlentities($finalres[$i], ENT_QUOTES);  ?>
                                </td><?php
                                        // echo 
                                        // echo "<br>";
                                    }
                                        ?>
                        </tr>
                    <?php
                        // echo "------------------------------<br>";
                    }

                    ?>
                </table>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <script>
        var myTable = document.querySelector("#catdataa");
        var dataTable = new DataTable("#catdataa", {
	searchable: true,
	fixedHeight: true,
});
    </script>
</body>

</html>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="../js/jquery-3.6.0.min.js">
    <title>Transaction Report</title>
</head>

<body style="background-color:beige;">

    <nav class="navbar navbar-dark bg-dark">
        <div>
            <a class="navbar-brand" href="#">
                <img src="../images/wallet.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                EasyPay
            </a>
        </div>
    </nav>
    <div style="margin: 10px 10px 10px 10px;">
        <p><b> Select Date:</b> </p>
        <form method="post" action="">
            <div>
                <label for="from">From</label>
                <input type="text" id="from" name="from" required>
                <label for="to">to</label>
                <input type="text" id="to" name="to" required>
                <input type="submit" id="submit" name="SUBMIT">
                <button type="button" class="btn btn-primary" style="margin-left: 900px;" onclick="window.print();">Print</button>

            </div>
        </form>
    </div>
    <!-- php code for display data after getting date input -->

    <div class="card-body" style="font-size:25px;font-family:calibri">
        <div class="table-responsive">
            <table class="table" class="text-center">
                <thead class="thead-dark" class="text-center">
                    <tr class="text-center">
                        <th scope="col">Date & Time</th>
                        <th scope="col">Transferred</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require('../php/database.php');
                    require('../php/functions.php');
                    $sub_sql = "";
                    if (isset($_POST['SUBMIT'])) {
                        $from = $_POST['from'];
                        $fromarr = explode("/", $from);
                        $from = $fromarr['2'] . '-' . $fromarr['1'] . '-' . $fromarr[0];
                        $from = $from . " 00:00:00";
                        $to = $_POST['to'];
                        $toarr = explode("/", $to);
                        $to = $toarr['2'] . '-' . $toarr['1'] . '-' . $toarr[0];
                        $to = $to . " 23:59:59";
                        $sub_sql = " where created_at > '$from' && created_at<='$to'";
                    }
                    $query1 = mysqli_query($db, "select * from trans $sub_sql");

                    while ($row = mysqli_fetch_array($query1)) {
                    ?>
                        <tr>
                            <td class="text-center"><?php echo  $row['created_at']; ?></td>
                            <td class="text-center">
                                <?php if ($row['from_user_id'] == 121) {
                                    echo "From Bank ";
                                } else {
                                    echo "To ", getUserName($row['to_user_id'])['full_name'];
                                }
                                ?></td>
                            </td>
                            <td class="text-center"><?php if ($row['from_user_id'] == 121) {
                                                        echo '<i style="color:green;font-size:30px;font-family:calibri ;">
                                                         + </i> ';
                                                    } else {
                                                        echo '<i style="color:red;font-size:30px;font-family:calibri ;">
                                                         - </i> ';
                                                    }
                                                    echo $row['amount']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Java script code -->
    <script>
        $(function() {
            var dateFormat = "dd/mm/yy",
                from = $("#from")
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: "dd/mm/yy"
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = $("#to").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: "dd/mm/yy"
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
        });
    </script>
</body>

</html>
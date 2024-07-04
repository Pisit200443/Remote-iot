<?php
    session_start();
    require_once('server.php');

    if (isset($_SESSION['user_id'])) {
        if (isset($_GET['device_id'])) {
            $check_devices = $conn->prepare("SELECT * FROM device JOIN user ON device.user_id = user.user_id WHERE device_id = :device_id");
            $check_devices->bindParam(":device_id", $_GET['device_id']);
            $check_devices->execute();
            $devices = $check_devices->fetch(PDO::FETCH_ASSOC);
        }
    } else {
        $_SESSION['error'] = 'Please log in!';
        header('location: Login/login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Remote</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/remote_control.css">
    <link rel="stylesheet" href="CSS/calendar.css">
    <script src="Script_JS/fetch_button_remote.js"></script>
    <script src="Script_JS/calendar.js"></script>
</head>
<body>

<?php include 'navbar_user.php'; ?>
<div class="remote-control">

    <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger error-message" role="alert">
        <?php $_SESSION['error_message'] ?>
    </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="container-1">
        <div class="container-remote">
            <h1> Remote </h1>
            <p><?php echo $devices['device_name']; ?></p>
            <div class="body-remote">
                <div class="button-top">
                    <button type="button" class="toggle-btn-power" id="button_power" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-power"></i></button>
                </div>
                <div class="button-sound">
                    <button type="button" class="toggle-btn" id="button_plus" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-plus-lg"></i></button>
                    <button type="button" class="toggle-btn" id="button_reduce" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-dash-lg"></i></button>
                </div>
                <div class="button-move">
                    <button type="button" class="toggle-btn" id="button_moveUp" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-chevron-up"></i></button>
                    <button type="button" class="toggle-btn" id="button_moveDown" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-chevron-down"></i></button>
                </div>
                <div class="button-control">
                    <div class="btn-up">
                        <center>
                            <button type="button" class="toggle-btn" id="button_up" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-chevron-up"></i></button>
                        </center>
                    </div>
                    <div class="btn-row">
                        <button type="button" class="toggle-btn" id="button_left" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-chevron-left"></i></button>
                        <button type="button" class="toggle-btn" id="button_ok" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)">OK</button>
                        <button type="button" class="toggle-btn" id="button_right" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-chevron-right"></i></button>
                    </div>            
                    <div class="btn-down">
                        <center>
                            <button type="button" class="toggle-btn" id="button_down" data-device-id="<?php echo $devices['device_id']?>" onclick="GetButtonRemote(this.id)"><i class="bi bi-chevron-down"></i></button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-2">
        <div class="container-calendar">
            <div class="month-year">
                <select  class="form-select" aria-label="Default select example" id="monthDropdown">
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option> 
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                
                <select  class="form-select" aria-label="Default select example" id="yearDropdown">
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option> 
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>
                    <option value="2035">2035</option>
                    <option value="2036">2036</option>
                    <option value="2037">2037</option> 
                    <option value="2038">2038</option>
                    <option value="2039">2039</option>
                    <option value="2040">2040</option>
                </select>
            </div>

            <div class="calendar">
                <!-- display calendar -->
            </div>

            <!-- model set the time -->
            <div class="modal" id="model-set-time" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalCenteredScrollableTitle">Set the time</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="calendarTitle">
                                <!-- display date data -->
                            </div>
                            <br>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">All Time</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Add Time</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <br>
                                    <!-- display time and button -->
                                </div>
                                
                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                    <form action="Fetch_data_php/set_buttontime.php" method="post" >
                                        <div class="mb-3">
                                            <label class="form-label">Time</label>
                                            <input type="time" class="form-control" id="Time" name="time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Remote Button</label>
                                            <br>
                                            <select class="form-select" name="remote_button" id="RemoteButton">
                                                <option disabled selected>Select a button</option>
                                                <option value="power">Power</option>
                                                <option value="moveUp">Move up</option>
                                                <option value="moveDown">Move down</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="device_id" id="DeviceId" value="<?php echo $devices['device_id']; ?>">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-3" onclick="insertDate(event)">Save</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <script>
            // Display calenda
            document.addEventListener("DOMContentLoaded", function () {
            const calendar = new Calendar();
            const calendarContainer = document.querySelector('.calendar');

            const today = new Date();
            document.getElementById('monthDropdown').value = ('0' + (today.getMonth() + 1)).slice(-2);
            document.getElementById('yearDropdown').value = today.getFullYear().toString();

            updateCalendar();

            document.getElementById('monthDropdown').addEventListener('change', updateCalendar);
            document.getElementById('yearDropdown').addEventListener('change', updateCalendar);

            function updateCalendar() {
                const today = new Date();
                const selectedDay = today.getDate();
                const selectedMonth = document.getElementById('monthDropdown').value;
                const selectedYear = document.getElementById('yearDropdown').value;

                calendar.selectMonthYear(selectedYear, selectedMonth, selectedDay);

                const calendarHtml = calendar.generateCalendar();
                calendarContainer.innerHTML = calendarHtml;
            }
            });

            // Display date
            let DateData;
            function ShowDataDate (date) {
                let monthtext = "";
                switch(document.getElementById('monthDropdown').value) {
                    case "01": monthtext = "January"; break;
                    case "02": monthtext = "February"; break;
                    case "03": monthtext = "March"; break;
                    case "04": monthtext = "April"; break;
                    case "05": monthtext = "May"; break;
                    case "06": monthtext = "June"; break;
                    case "07": monthtext = "July"; break;
                    case "08": monthtext = "August"; break;
                    case "09": monthtext = "September"; break;
                    case "10": monthtext = "October"; break;
                    case "11": monthtext = "November"; break;
                    case "12": monthtext = "December"; break;
                    default: console.log("switch"); break;
                }

                let year = document.getElementById('yearDropdown').value;
                let month = document.getElementById('monthDropdown').value;
                let day = date;

                DateData = `${year}-${month}-${day}`;

                let DateTitle = date + ' ' + monthtext + ' ' + year;
                
                var DateTitleId = document.getElementById('calendarTitle');
                DateTitleId.innerHTML = DateTitle;

                // Fetch time
                let deviceId = document.getElementById('DeviceId').value;

                fetch("Fetch_data_php/get_time_column.php", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                    },
                    body: JSON.stringify({
                        device_id: deviceId,
                        date: DateData,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        const timeToDay = document.getElementById('home-tab-pane');
                        timeToDay.innerHTML = "";

                        data.forEach(time => {
                            timeToDay.innerHTML += `Time: ${time[0]} Button: ${time[1]} <br>`
                        });
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                    });
            }

            // Insert date
            function insertDate (event) {
                let dataDate = DateData;
                let timeSet = document.getElementById('Time').value += ':00';
                let ButtonSet = document.getElementById('RemoteButton').value;
                let deviceId = document.getElementById('DeviceId').value;

                fetch("Fetch_data_php/set_buttontime.php", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                    },
                    body: JSON.stringify({
                        date: dataDate,
                        time: timeSet,
                        remote_button: ButtonSet,
                        device_id: deviceId,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    try {
                        const response = JSON.parse(JSON.stringify(data));
                        if (response.status === 'error') {
                            alert(response.message);
                        } else {
                            console.log("Response from server:", response);
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                })
            }
        </script>
            
        </div>
    </div>
</div>


</body>
</html>

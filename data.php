<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "weather_forcast";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["temperature"]) && isset($_POST["humidity"]) && isset($_POST["pressure"]) && isset($_POST["rain"])) {
    $temperature = $_POST["temperature"];
    $humidity = $_POST["humidity"];
    $pressure = $_POST["pressure"];
    $rain = $_POST["rain"];

    $sql = "INSERT INTO sensordata (Temperature, Humidity, Pressure, Rain) VALUES ($temperature, $humidity, $pressure, $rain)";

    if ($conn->query($sql) === TRUE) {
        echo "Sensor data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM sensordata ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $latest_temperature = $row["Temperature"];
    $latest_humidity = $row["Humidity"];
    $latest_pressure = $row["Pressure"];
    $latest_rain = $row["Rain"];
} else {
    $latest_temperature = "N/A";
    $latest_humidity = "N/A";
    $latest_pressure = "N/A";
    $latest_rain = "N/A";
}

$conn->close();

function predictWeather($sensor_data) {
    // Implement your weather prediction algorithm here
    // This is a placeholder function
    
    // Example: Assume the weather prediction model returns an array of predicted weather conditions for the next 4 days
    $predicted_weather = array(
        "Day 1" => "Sunny",
        "Day 2" => "Partly Cloudy",
        "Day 3" => "Rainy",
        "Day 4" => "Cloudy"
    );
    
    return $predicted_weather;
}

// Example sensor data (replace this with actual sensor data)
$sensor_data = array(
    "temperature" => 25, // Example temperature data
    "humidity" => 70, // Example humidity data
    "pressure" => 1015, // Example pressure data
    "rain" => 0 // Example rain data
);

// Predict weather based on sensor data
$predicted_weather = predictWeather($sensor_data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Weather Forecast</title>
<link rel="stylesheet" href="styles.css">
<script>
    function setDynamicBackground() {
        var currentDate = new Date();
        var currentHour = currentDate.getHours();
        var body = document.body;
        if (currentHour >= 6 && currentHour < 18) {
            // Daytime background
            body.classList.remove("night");
            body.classList.add("day");
        } else {
            // Nighttime background
            body.classList.remove("day");
            body.classList.add("night");
        }
    }
    window.onload = setDynamicBackground;
</script>
</head>
<body>
<div class="weather-container">
    <div class="mob_inner">
    <div class="location">
    <p><img src="images/location-pin.png" alt="locaion"> LOCATION</p>
    </div>
            <div class="sec1">
            <div class="weather-icon">
             <?php
              $current_hour = date('H');
              if ($current_hour >= 6 && $current_hour < 18) {
            // Daytime
              echo '<img src="images/moon.png" alt="Sun">';
              } else {
            // Nighttime
              echo '<img src="images/moon.png" alt="Moon">';
              }
             ?>
             </div>
            </div>
  <div class="current-weather">
    <div class="temperature">
        <?php echo $latest_temperature; ?><span class="celsius"> &#8451;</span>
    </div>
    <div>Mostly cloudy 24°/32°</div>
    <div>Air quality: 93 - Moderate</div>
    <div>Low pollen count</div>
  </div>

  <div class="fancy">
  <div class="box humidity-box">
    <div class="subtitle1">
        <span><img src="images/humidity.png" alt="Humidity"> Humidity</span>
    </div>
    <div class="temp_num">
        <div>
            <span class="wob_t" id="out_humidity"><?php echo $latest_humidity; ?></span><span class="wob_per" aria-label="" aria-disabled="true" role="button">%</span>
        </div>
    </div>
    </div>
    <div class="box pressure-box">
    <div class="subtitle2">
        <span><img src="images/air.png" alt="Pressure">Pressure</span>
    </div>
    <div class="temp_num3">
        <div>
            <span class="wob_t" id="in_pressure"><?php echo $latest_pressure; ?></span><span class="wob_per" aria-label="" aria-disabled="true" role="button">hPa</span>
        </div>
    </div>
    </div>
</div>
<div class="clr"></div>

  </div>
</div>
</body>
</html>

<?php
// Function to convert English day to Indonesian day
function hari_ina($englishDay)
{
  $days = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu'
  ];
  return $days[$englishDay] ?? '';
}

// Database connection
$connection = new mysqli('localhost', 'username', 'password', 'database');

// Check connection
if ($connection->connect_error) {
  die("Connection failed: " . $connection->connect_error);
}

$today = hari_ina(date("l"));
$now = date("H:i:s");

// Prepare and execute queries
$stmt = $connection->prepare("SELECT idh FROM hari WHERE hari = ?");
$stmt->bind_param('s', $today);
$stmt->execute();
$id_hari = $stmt->get_result()->fetch_assoc();

if ($id_hari) {
  $id_hari = $id_hari['idh'];

  // Update jadwal table based on current time
  $stmt = $connection->prepare("
        UPDATE jadwal 
        SET aktif = CASE 
            WHEN idh = ? AND jam_mulai <= ? AND jam_selesai >= ? THEN 1
            ELSE 0
        END
    ");
  $stmt->bind_param('iss', $id_hari, $now, $now);
  $stmt->execute();

  // Deactivate schedules that do not match the current day
  $stmt = $connection->prepare("UPDATE jadwal SET aktif = 0 WHERE idh <> ?");
  $stmt->bind_param('i', $id_hari);
  $stmt->execute();

  // Deactivate schedules that are out of the current time range
  $stmt = $connection->prepare("
        UPDATE jadwal 
        SET aktif = 0 
        WHERE idh = ? AND (jam_mulai >= ? OR jam_selesai <= ?)
    ");
  $stmt->bind_param('iss', $id_hari, $now, $now);
  $stmt->execute();

  // Check if the current schedule is active
  $idj = $_GET['idj'];
  $stmt = $connection->prepare("SELECT aktif FROM jadwal WHERE idj = ?");
  $stmt->bind_param('i', $idj);
  $stmt->execute();
  $aktifgak = $stmt->get_result()->fetch_assoc();

  if ($aktifgak['aktif'] == 1) {
    include "input_absen.php";
  } else {
    echo "<center><br><h3>Maaf, Anda tidak bisa mengabsen siswa diluar jam pelajaran.</h3>
        <a href='media.php?module=jadwal_mengajar'><b>Kembali</b></a></center>";
  }
} else {
  echo "Error: Day not found.";
}

// Close connection
$connection->close();

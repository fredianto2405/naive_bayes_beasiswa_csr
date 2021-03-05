<?php

// data train set
$connect = mysqli_connect("localhost", "root", "", "bayes"); // database connection
$sql = "SELECT * FROM beasiswa";
$query = mysqli_query($connect, $sql);

$x_train = [];
$y_train = [];
while($row = mysqli_fetch_array($query)){
  $temp = [$row["penghasilan_ortu"], $row["yatim_piatu"], $row["kondisi_rumah"], $row["penerima_pkh"], $row['beasiswa_smp']];
  array_push($x_train, $temp);
  array_push($y_train, $row["label"]);
}

/*
parameter description:
1. $x = data test set
2. $c = class
3. $_x = data train set
*/

// count class prior probability
function class_prior_prob($c)
{
  $count_yes = 0;
  $count_no = 0;

  for($i = 0; $i < count($c); $i++){
    if($c[$i] == "Ya"){
      $count_yes += 1;
    }else{
      $count_no += 1;
    }
  }

  $yes = $count_yes / count($c);
  $no = $count_no / count($c);

  return [$yes, $no];
}

// count likelihood
function likelihood($x, $c, $_x){
  $penghasilan_ortu_yes = 0;
  $yatim_piatu_yes = 0;
  $kondisi_rumah_yes = 0;
  $penerima_pkh_yes = 0;
  $beasiswa_smp_yes = 0;

  $penghasilan_ortu_no = 0;
  $yatim_piatu_no = 0;
  $kondisi_rumah_no = 0;
  $penerima_pkh_no = 0;
  $beasiswa_smp_no = 0;

  $count_yes = 0;
  $count_no = 0;

  for($i = 0; $i < count($c); $i++){
    if($c[$i] == "Ya"){
      $count_yes += 1;
    }else{
      $count_no += 1;
    }
  }

  for($i = 0; $i < count($_x); $i++){
    for($j = 0; $j < count($_x[0]); $j++){
      if($_x[$i][$j] == $x[$j]){
        if($c[$i] == "Ya"){
          if($j == 0){
            $penghasilan_ortu_yes += 1;
          }elseif($j == 1){
            $yatim_piatu_yes += 1;
          }elseif($j == 2){
            $kondisi_rumah_yes += 1;
          }elseif($j == 3){
            $penerima_pkh_yes += 1;
          }else{
            $beasiswa_smp_yes += 1;
          }
        }else{
          if($j == 0){
            $penghasilan_ortu_no += 1;
          }elseif($j == 1){
            $yatim_piatu_no += 1;
          }elseif($j == 2){
            $kondisi_rumah_no += 1;
          }elseif($j == 3){
            $penerima_pkh_no += 1;
          }else{
            $beasiswa_smp_no += 1;
          }
        }
      }
    }
  }

  $penghasilan_ortu_yes = $penghasilan_ortu_yes / $count_yes;
  $yatim_piatu_yes = $yatim_piatu_yes / $count_yes;
  $kondisi_rumah_yes = $kondisi_rumah_yes / $count_yes;
  $penerima_pkh_yes = $penerima_pkh_yes / $count_yes;
  $beasiswa_smp_yes = $beasiswa_smp_yes / $count_yes;

  $penghasilan_ortu_no = $penghasilan_ortu_no / $count_no;
  $yatim_piatu_no = $yatim_piatu_no / $count_no;
  $kondisi_rumah_no = $kondisi_rumah_no / $count_no;
  $penerima_pkh_no = $penerima_pkh_no / $count_no;
  $beasiswa_smp_no = $beasiswa_smp_no / $count_no;

  $yes = $penghasilan_ortu_yes * $yatim_piatu_yes * $kondisi_rumah_yes * $penerima_pkh_yes * $beasiswa_smp_yes;
  $no = $penghasilan_ortu_no * $yatim_piatu_no * $kondisi_rumah_no * $penerima_pkh_no * $beasiswa_smp_no;

  return [$yes, $no];
}

// count posterior probability
function posterior_prob($x, $c, $_x){
  $prior = class_prior_prob($c);
  $lklhood = likelihood($_x, $c, $x);

  $yes = $prior[0] * $lklhood[0];
  $no = $prior[1] * $lklhood[1];

  if($yes > $no){
    return "Ya";
  }else{
    return "Tidak";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Naive Bayes | Beasiswa CSR</title>
</head>
<body>
  <h3>Naive Bayes | Beasiswa CSR</h3>
  <form action="index.php" method="POST">
    <table cellpadding="5">
      <tr>
        <td>Penghasilan Orang Tua</td>
        <td>:</td>
        <td>
          <select name="penghasilan_ortu" required>
            <option value="">Pilih Penghasilan Orang Tua</option>
            <option value="< 500.000">< 500.000</option>
            <option value="500.000 - 1.000.000">500.000 - 1.000.000</option>
            <option value="> 1.000.000">> 1.000.000</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Status Yatim Piatu</td>
        <td>:</td>
        <td>
          <select name="yatim_piatu" required>
            <option value="">Pilih Status Yatim Piatu</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Kondisi Rumah</td>
        <td>:</td>
        <td>
          <select name="kondisi_rumah" required>
            <option value="">Pilih Kondisi Rumah</option>
            <option value="Layak">Layak</option>
            <option value="Cukup">Cukup</option>
            <option value="Kurang">Kurang</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Status Penerima PKH</td>
        <td>:</td>
        <td>
          <select name="penerima_pkh" required>
            <option value="">Pilih Status Penerima PKH</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Status Beasiswa SMP</td>
        <td>:</td>
        <td>
          <select name="beasiswa_smp" required>
            <option value="">Pilih Status Beasiswa SMP</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td><input type="submit" name="btn_predict" value="Start Predict"></td>
      </tr>
    </table>
  </form>
</body>
</html>

<?php 

// get form data
if(@$_POST["btn_predict"]){
  $x_test = [$_POST["penghasilan_ortu"], $_POST["yatim_piatu"], $_POST["kondisi_rumah"], $_POST["penerima_pkh"], $_POST['beasiswa_smp']];
  $result = posterior_prob($x_train, $y_train, $x_test);
  echo "<p><strong>Label = $result</strong></p>";
}

// get data train accuracy
// $right = 0;
// for($i = 0; $i < count($y_train); $i++){
//   $x_test = [$x_train[$i][0], $x_train[$i][1], $x_train[$i][2], $x_train[$i][3], $x_train[$i][4]];
//   $result = posterior_prob($x_train, $y_train, $x_test);
//   if($result == $y_train[$i]){
//     $right += 1;
//   }
// }
// $wrong = count($y_train) - $right;
// $accuracy = $right / count($y_train);
// echo "<p><strong>Right = $right</strong></p>";
// echo "<p><strong>Wrong = $wrong</strong></p>";
// echo "<p><strong>Accuracy = $accuracy</strong></p>";

?>
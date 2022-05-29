<?php
date_default_timezone_set('Europe/Istanbul');
require_once 'dbconfig.php';

class Crud
{
  private $db;
  private $db_host = DB_HOST;
  private $db_user = DB_USER;
  private $db_pass = DB_PASS;
  private $db_name = DB_NAME;

  function __construct()
  {
    try {
      $this->db = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name . ';charset=utf8', $this->db_user, $this->db_pass);
      // echo "Connected";
    } catch (Exception $e) {

      die('Connection failed: ' . $e->getMessage());
    }
  }


  public function addValue($args)
  {
    $values = implode(',', array_map(function ($item) {
      return $item . '=?';
    }, array_keys($args)));
    return $values;
  }


  public function insert($table, $values, $options = [])
  {
    try {
      // echo "<pre>";
      // print_r($values);
      // exit;

      if (isset($options['slug'])) {

        if (empty($values[$options['slug']])) {
          $values[$options['slug']] = $this->seo($values[$options['title']]);
        } else {
          $values[$options['slug']] = $this->seo($values[$options['slug']]);
        }
      }

      if (!empty(@$_FILES[$options['fileName']]['name'])) {

        $name_y = $this->imageUpload(
          $_FILES[$options['fileName']]['name'],
          $_FILES[$options['fileName']]['size'],
          $_FILES[$options['fileName']]['tmp_name'],
          $options['dir'],

        );

        $values += [$options['fileName'] => $name_y];
      }

      // md5 pass
      if (isset($options['pass'])) {
        $values[$options['pass']] = md5($values[$options['pass']]);
      }

      unset($values[$options['formName']]);

      $stmt = $this->db->prepare("INSERT INTO $table SET {$this->addValue($values)}");
      $stmt->execute(array_values($values));
      return ['status' => true];
    } catch (Exception $e) {
      return ['status' => false, 'error' => $e->getMessage()];
    }
  }

  public function update($table, $values, $options = [])
  {
    try {


      if (isset($options['slug'])) {

        if (empty($values[$options['slug']])) {
          $values[$options['slug']] = $this->seo($values[$options['title']]);
        } else {
          $values[$options['slug']] = $this->seo($values[$options['slug']]);
        }
      }

      if (!empty(@$_FILES[$options['fileName']]['name'])) {
        $name_y = $this->imageUpload(
          $_FILES[$options['fileName']]['name'],
          $_FILES[$options['fileName']]['size'],
          $_FILES[$options['fileName']]['tmp_name'],
          $options['dir'],
          $values[$options['fileDelete']]
        );

        $values += [$options['fileName'] => $name_y];
      }

      unset($values[@$options['fileDelete']]);



      $columnsId = $values[$options['columns']];
      unset($values[$options['formName']]);
      unset($values[$options['columns']]);
      $valuesExecute = $values;
      $valuesExecute += [$options['columns'] =>  $columnsId];

      // echo "<pre>";
      // print_r($valuesExecute);


      $stmt = $this->db->prepare("UPDATE $table SET {$this->addValue($values)} WHERE {$options['columns']} = ?");
      $stmt->execute(array_values($valuesExecute));
      return ['status' => true];
    } catch (Exception $e) {
      return ['status' => false, 'error' => $e->getMessage()];
    }
  }

  public function delete($table, $columns, $values, $fileName = null)
  {
    try {

      if (!empty($fileName)) {
        unlink("dimg/$table/" . $fileName);
      }


      $stmt = $this->db->prepare("DELETE FROM $table WHERE $columns = ?");
      $stmt->execute([htmlspecialchars($values)]);
      return ['status' => true];
    } catch (Exception $e) {
      return ['status' => false, 'error' => $e->getMessage()];
    }
  }

  // public function slugify($name, $size, $tmp_name, $dir, $fileDelete = null)
  // {
  // }

  public function imageUpload($name, $size, $tmp_name, $dir, $fileDelete = null)
  {
    try {

      $extensions = [
        'jpg',
        'jpeg',
        'png',
        'ico'
      ];
      $ext = strtolower(substr($name, strrpos($name, '.') + 1));

      if (in_array($ext, $extensions) === false) {
        throw new Exception('Geçersiz uzantı.');
      }

      if ($size > 1048576) {
        throw new Exception('Dosya boyutu çok büyük.');
      }


      $name_y = uniqid() . '.' . $ext;

      if (!@move_uploaded_file($tmp_name, "dimg/$dir/$name_y")) {
        throw new Exception('Fotoğraf yüklenemedi.');
      }

      // if ($fileDelete != 'default.png') {
      //   unlink("dimg/$dir/" . $fileDelete);
      // }

      if (!empty($fileDelete)) {
        unlink("dimg/$dir/$fileDelete");

        if (strstr($dir, 'admin')) {
          $_SESSION['admin']['adminFile'] = $name_y;
        }
      }
      return $name_y;
    } catch (Exception $e) {
      return ['status' => false, 'error' => $e->getMessage()];
    }
  }


  public function adminLogin($adminUsername, $adminPass, $rememberMe)
  {

    try {

      $stmt = $this->db->prepare("SELECT * FROM admin WHERE adminUsername = ? AND adminPass = ?");

      if (isset($_COOKIE['adminLogin'])) {
        $stmt->execute([$adminUsername, md5(openssl_decrypt($adminPass, 'AES-128-ECB', 'adminsolve'))]);
      } else {
        $stmt->execute([$adminUsername, md5($adminPass)]);
      }

      if ($stmt->rowCount() == 1) {

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['adminStatus'] == 0) {
          return ['status' => false];
          exit;
        }

        $_SESSION['admin'] = [
          'adminUsername' => $adminUsername,
          'adminName' => $row['adminName'],
          'adminSurname' => $row['adminSurname'],
          'adminFile' => $row['adminFile'],
          'adminId' => $row['adminId']
        ];

        if (!empty($rememberMe) and empty($_COOKIE['adminLogin'])) {
          $admin = [
            'adminUsername' => $adminUsername,
            'adminPass' => openssl_encrypt($adminPass, 'AES-128-ECB', 'adminsolve')

          ];

          setcookie('adminLogin', json_encode($admin), strtotime("+30 days"), "/");
        } else if (empty($rememberMe)) {
          setcookie('adminLogin', "", strtotime("-2 days"), "/");
        }

        return ['status' => true];
      } else {

        return ['status' => false];
      }
    } catch (Exception $e) {

      return ['status' => false, 'hata' => $e->getMessage()];
    }
  }

  public function read($table, $options = [])
  {


    try {

      if (isset($options['columnsName']) && empty($options['limit'])) {
        $stmt = $this->db->prepare("SELECT * FROM $table order by {$options['columnsName']} {$options['columnsSort']}");
      } else if (isset($options['columnsName']) && isset($options['limit'])) {
        $stmt = $this->db->prepare("SELECT * FROM $table order by {$options['columnsName']} {$options['columnsSort']} limit {$options['limit']}");
      } else {
        $stmt = $this->db->prepare("SELECT * FROM $table");
      }


      $stmt->execute();

      return $stmt;
    } catch (Exception $e) {
      return ['status' => false, 'error' => $e->getMessage()];
    }
  }

  public function wread($table, $columns, $values, $options = [])
  {
    try {

      $stmt = $this->db->prepare("SELECT * FROM $table WHERE $columns = ?");
      $stmt->execute([htmlspecialchars($values)]);
      return $stmt;
    } catch (Exception $e) {
      return ['status' => false, 'error' => $e->getMessage()];
    }
  }


  public function qSql($sql, $options = [])
  {
    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute();
      return $stmt;
    } catch (Exception $e) {
      return ['status' => false, 'error' => $e->getMessage()];
    }
  }


  public function orderUpdate($table, $values, $columns, $orderId)
  {

    try {

      foreach ($values as $key => $value) {

        $stmt = $this->db->prepare("UPDATE $table SET $columns=? WHERE $orderId=?");
        $stmt->execute([$key, $value]);
      }

      return ['status' => TRUE];
    } catch (Exception $e) {
      echo $e->getMessage();
      return ['status' => FALSE, 'error' => $e->getMessage()];
    }
  }


  // public function tDate($date, $options = [])
  // {

  //   $arg = explode(' ', $date);
  //   $date = explode(' ', $arg[0]);
  //   $time = $arg[1];

  //   if (isset($options['date'])) {
  //     return @$date[2] . @$date[1] .   @$date[0];

  //   } elseif (isset($options['time'])) {
  //     return @$time;

  //   } elseif (isset($options['dateTime'])) {
  //     return @$date[2] . @$date[1] .  @$date[0] ." ".  $time;
  //   }
  // }

  function tDate($format, $datetime = 'now')
  {
    $z = date("$format", strtotime($datetime));
    $day = [
      'Monday'    => 'Pazartesi',
      'Tuesday'   => 'Salı',
      'Wednesday' => 'Çarşamba',
      'Thursday'  => 'Perşembe',
      'Friday'    => 'Cuma',
      'Saturday'  => 'Cumartesi',
      'Sunday'    => 'Pazar',
      'January'   => 'Ocak',
      'February'  => 'Şubat',
      'March'     => 'Mart',
      'April'     => 'Nisan',
      'May'       => 'Mayıs',
      'June'      => 'Haziran',
      'July'      => 'Temmuz',
      'August'    => 'Ağustos',
      'September' => 'Eylül',
      'October'   => 'Ekim',
      'November'  => 'Kasım',
      'December'  => 'Aralık',
      'Mon'       => 'Pts',
      'Tue'       => 'Sal',
      'Wed'       => 'Çar',
      'Thu'       => 'Per',
      'Fri'       => 'Cum',
      'Sat'       => 'Cts',
      'Sun'       => 'Paz',
      'Jan'       => 'Oca',
      'Feb'       => 'Şub',
      'Mar'       => 'Mar',
      'Apr'       => 'Nis',
      'Jun'       => 'Haz',
      'Jul'       => 'Tem',
      'Aug'       => 'Ağu',
      'Sep'       => 'Eyl',
      'Oct'       => 'Eki',
      'Nov'       => 'Kas',
      'Dec'       => 'Ara',
    ];
    foreach ($day as $en => $tr) {
      $z = str_replace($en, $tr, $z);
    }
    // if (strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
  }

  function seo($s)
  {
    $tr = array('ş', 'Ş', 'ı', 'I', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'Ç', 'ç', '(', ')', '/', ':', ',');
    $eng = array('s', 's', 'i', 'i', 'i', 'g', 'g', 'u', 'u', 'o', 'o', 'c', 'c', '', '', '-', '-', '');
    $s = str_replace($tr, $eng, $s);
    $s = strtolower($s);
    $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
    $s = preg_replace('/\s+/', '-', $s);
    $s = preg_replace('|-+|', '-', $s);
    $s = preg_replace('/#/', '', $s);
    $s = str_replace('.', '', $s);
    $s = trim($s, '-');
    return $s;
  }


  public function slugRead($table) {
      try {
       //          $table"."Slug"." ----> ornek : aboutSlug, blogSlug, contactSlug....
          $stmt = $this->db->prepare("SELECT * FROM $table ORDER BY $table"."Slug"." ASC");
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          echo $row[$table."Slug"];

      } catch (Exception $e) {
          return ['status' => false, 'error' => $e->getMessage()];
      }

  }




}

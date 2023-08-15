<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Путь для сохранения загруженного файла
    $path_to_file = 'cheque/' . basename($_FILES['file']['name']);
  
    // Проверка типа файла
    $valid_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['file']['type'], $valid_types)) {
      echo "<script language='javascript'>alert('Ошибка: Недопустимый тип файла.')</script>";
      return;
    }
  
    // Перемещение загруженного файла в папку uploads
    if (move_uploaded_file($_FILES['file']['tmp_name'], $path_to_file)) {
      // Успешно загружено, выполнение обработки
  
      // Пример обработки: изменение размера изображения
      $new_size = 300;
  
      list($width, $height) = getimagesize($valid_types);
      $coefficient_of_scale = min($new_size / $width, $new_size / $height);
      $new_width = intval($width * $coefficient_of_scale);
      $new_height = intval($height * $coefficient_of_scale);
  
      $picture = imagecreatetruecolor($new_width, $new_height);
      $initial_picture = imagecreatefromjpeg($path_to_file);
  
      imagecopyresampled($picture, $initial_picture, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
  
      // Сохранение обработанного изображения
      $path_to_processed_file = 'uploads/processed' . basename($_FILES['file']['name']);
      imagejpeg($picture, $path_to_processed_file);
  
      // Освобождение ресурсов памяти
      imagedestroy($picture);
      imagedestroy($initial_picture);
  
      echo "<script language='javascript'>alert('Фото успешно загружено и обработано.')</script>";
    } else {
      {
      echo "<script language='javascript'>alert('Ошибка при загрузке файла.')</script>";
      }
      } else {
      echo "<script language='javascript'>alert('Ошибка: Неверный метод запроса.')</script>";
      }?>
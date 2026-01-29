<?php

session_start();
include_once "../config/database.php";
$errors = [];
$old = [];
if(isset($_POST['submit'])) {
    $name = trim($_POST['name'] ?? '');
    $old['name'] = $name;
    
    if(empty($name)) {
        $errors['name'] = "Name is required";
    }elseif(!preg_match("/^[a-zA-Z\s]+$/",$name)) {
        $errors['name'] = "Name must be contain only letters";
    }
    
    $age = trim($_POST['age'] ?? '');
    $old['age'] = $age;
    if(empty($age)) {
        $errors['age'] = "Age is required";
    }elseif(!is_numeric($age)) {
        $errors = "Age must be a number";
    }elseif($age < 18) {
        $errors = "Age must be 18 or above";
    }

    $email = trim($_POST['email'] ?? '');
    $old['email'] = $email;
    if(empty($email)) {
         $errors['email'] = "Email is required";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid Email format";
    }else{
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        if($checkEmail->rowCount() > 0) {
            $errors['email'] = "Email already exists";
        }
    }
    
    $mobile = trim($_POST['mobile'] ?? '');
    $old['mobile'] = $mobile;

    if(empty($mobile)) {
        $errors['mobile'] = 'Mobile is required';
    }elseif(!preg_match("/^[6-9]\d{9}$/",$mobile)) {
        $errors['mobile'] = "Enter a valid 10-digit mobile number";
    }

    $address = trim($_POST['address'] ?? '');
    $old['address'] = $address;
    if(empty($address)) {
        $errors['address'] = 'Address is required';
    }

 

    
     $newImageName = null;
     
     if(!empty($_FILES['image']['name'])) {
    $imageName = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];

    $ext = strtolower(pathinfo($imageName,PATHINFO_EXTENSION));
    
    if (!in_array($ext, ['jpg','jpeg','png'])) {
            $errors['image'] = "Only JPG, JPEG, PNG allowed";
        } elseif ($fileSize > 2 * 1024 * 1024) {
            $errors['image'] = "Image size must be less than 2MB";
        } else {
            $newImageName = time() . '_' . $imageName;
        }
}



   if(!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
    header("Location:/phpCrud/?create=true");
    exit;
   }

 if($newImageName) {
    move_uploaded_file($tmp_name,__DIR__."/../uploads/$newImageName");
   }

   $status = trim($_POST['stauts'] ?? 'active');

   $sql = $conn->prepare("INSERT INTO users(name,age,email,mobile,address,image,status) VALUES(?,?,?,?,?,?,?)");
   $result = $sql->execute([$name,$age,$email,$mobile,$address,$newImageName,$status]);

   if($result) {
    $_SESSION['error'] = "User Successfully Created";
     header("Location:/phpCrud");
   }else{
     $_SESSION['error'] = "User Not Created";
     header("Location:/phpCrud/?create=true");
   }
   


}elseif(isset($_POST['update'])) {
  $eid = $_POST['eid'];

  $name = trim($_POST['name'] ?? '');
    $old['name'] = $name;
    
    if(empty($name)) {
        $errors['name'] = "Name is required";
    }elseif(!preg_match("/^[a-zA-Z\s]+$/",$name)) {
        $errors['name'] = "Name must be contain only letters";
    }
    
    $age = trim($_POST['age'] ?? '');
    $old['age'] = $age;
    if(empty($age)) {
        $errors['age'] = "Age is required";
    }elseif(!is_numeric($age)) {
        $errors = "Age must be a number";
    }elseif($age < 18) {
        $errors = "Age must be 18 or above";
    }

    $email = trim($_POST['email'] ?? '');
    $old['email'] = $email;
    if(empty($email)) {
         $errors['email'] = "Email is required";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid Email format";
    }else{
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $checkEmail->execute([$email,$eid]);
        if($checkEmail->rowCount() > 0) {
            $errors['email'] = "Email already exists";
        }
    }
    
    $mobile = trim($_POST['mobile'] ?? '');
    $old['mobile'] = $mobile;

    if(empty($mobile)) {
        $errors['mobile'] = 'Mobile is required';
    }elseif(!preg_match("/^[6-9]\d{9}$/",$mobile)) {
        $errors['mobile'] = "Enter a valid 10-digit mobile number";
    }

    $address = trim($_POST['address'] ?? '');
    $old['address'] = $address;
    if(empty($address)) {
        $errors['address'] = 'Address is required';
    }

       // get old image

    $getImage = $conn->prepare("SELECT image FROM users WHERE id = ?");
    $getImage->execute([$eid]);
    $oldImage = $getImage->fetch(PDO::FETCH_ASSOC)['image'];

     $newImageName = $oldImage;
     
    if(!empty($_FILES['image']['name'])) {
    $imageName = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];

    $ext = strtolower(pathinfo($imageName,PATHINFO_EXTENSION));
    
    if (!in_array($ext, ['jpg','jpeg','png'])) {
            $errors['image'] = "Only JPG, JPEG, PNG allowed";
        } elseif ($fileSize > 2 * 1024 * 1024) {
            $errors['image'] = "Image size must be less than 2MB";
        } else {
            $newImageName = time() . '_' . $imageName;
        }
}



   if(!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
    header("Location:/phpCrud/?e-id=$eid");
    exit;
   }

  

       // upload image
    if(!empty($_FILES['image']['name'])) {

       if($oldImage && file_exists(__DIR__."/../uploads/".$oldImage)){
            unlink(__DIR__."/../uploads/".$oldImage);
        }
      
         move_uploaded_file($tmp_name,__DIR__."/../uploads/$newImageName");

        
    }
 
 

   $status = trim($_POST['status'] ?? 'active');

   $sql = $conn->prepare("UPDATE users SET name =?,age=?,email=?,mobile=?,address=?,image=?,status=? WHERE id =? ");
   $result = $sql->execute([$name,$age,$email,$mobile,$address,$newImageName,$status,$eid]);

   if($result) {
    $_SESSION['success'] = "User Successfully Updated";
     header("Location:/phpCrud");
   }else{
     $_SESSION['error'] = "User Not Updated";
     header("Location:/phpCrud/?e-id=$eid");
   }

  
}elseif(isset($_POST['deleted'])) {
    // delete users
$id = $_POST['user_id'];
$getImage = $conn->prepare("SELECT image FROM users WHERE id = ?");
$getImage->execute([$id]);
$userImage = $getImage->fetch(PDO::FETCH_ASSOC);

// image safely deleted
if(!empty($userImage['image'])) {
    $imagePath = __DIR__."/../uploads/".$userImage['image'];
    if(file_exists($imagePath)) {
        unlink($imagePath);
    }
}

$deleteUser = $conn->prepare("DELETE FROM users WHERE id = ?");
$deleteUser->execute([$id]);

if($deleteUser->rowCount() > 0) {
  header("Location:/phpCrud/");
   $_SESSION['success'] ="User successfully deleted"; 
   exit;
}else{
  
    header("Location:/phpCrud/"); 
     $_SESSION['error'] ="User Not deleted"; 
     exit;
}
}


?>
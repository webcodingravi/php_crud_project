<?php 
 $errors = $_SESSION['errors'] ?? '';

 unset($_SESSION['errors']);

 include_once "config/database.php";

 $eid = $_GET['e-id'];
 $sql = $conn->prepare("SELECT * FROM users WHERE id=?");
 $sql->execute([$eid]);
 $user = $sql->fetch(PDO::FETCH_ASSOC);
?>

<div class="bg-white p-4 rounded w-8/12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold">Edit User</h1>
        <div>
            <a href="/phpCrud"
                class="bg-rose-600 px-6 py-3 active:scale-90 duration-300 transition-all text-white rounded block font-semibold text-md">Back</a>
        </div>
    </div>
    <hr class="text-slate-100 my-4">

    <form action="./server/request.php" class="w-full flex flex-col gap-8" method="post" enctype="multipart/form-data">
        <input type="text" name="eid" value=<?= $eid ?> hidden>
        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Name</label>
            <input type="text" value="<?= $user['name'] ?>" name=" name"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Name...">
            <p class="text-rose-600"><?= $errors['name'] ?? ''  ?></p>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Age</label>
            <input type="text" value="<?= $user['age'] ?>" name="age"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Age...">
            <p class="text-rose-600"><?= $errors['age'] ?? ''  ?></p>
        </div>


        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Email</label>
            <input type="text" name="email" value="<?= $user['email'] ?>"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Email...">
            <p class="text-rose-600"><?= $errors['email'] ?? ''  ?></p>
        </div>



        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Mobile</label>
            <input type="text" name="mobile" value="<?= $user['mobile'] ?>"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Mobile...">
            <p class="text-rose-600"><?= $errors['mobile'] ?? ''  ?></p>
        </div>



        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Address</label>
            <input type="text" name="address" value="<?= $user['address'] ?>"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Address...">
            <p class="text-rose-600"><?= $errors['address'] ?? ''  ?></p>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium ">Image</label>
            <input type="file" name="image" accept="image/*"
                class="border border-slate-200 rounded p-4 focus:outline-none cursor-pointer">
            <p class="text-rose-600"><?= $errors['image'] ?? ''  ?></p>

            <div>
                <img src="uploads/<?= $user['image'] ?>" alt="" height="200" width="200" class="cursor-pointer">
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium ">Status</label>
            <select name="status" class="border border-slate-200 rounded p-4 focus:outline-none cursor-pointer">
                <option value="active" <?= ($user['status'] === 'active') ? 'selected' : '' ?>>Active</option>
                <option value=" deactive" <?=($user['status'] === 'deactive') ? 'selected' : '' ?>>Deactive</option>
            </select>
            <!-- <p class=" text-rose-600"><?= $errors['status'] ?? ''  ?></p> -->
        </div>
        <div>
            <button type="submit" name="update"
                class="px-4 py-2 text-white font-medium bg-indigo-500 rounded cursor-pointer active:scale-90 duration-300 transition-all">Update</button>
        </div>
    </form>

</div>
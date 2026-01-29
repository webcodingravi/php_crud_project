<?php 
 $errors = $_SESSION['errors'] ?? '';
 $old = $_SESSION['old'] ?? '';

 unset($_SESSION['errors'],$_SESSION['old']);
?>

<div class="bg-white p-4 rounded w-8/12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold">Add User</h1>
        <div>
            <a href="/phpCrud"
                class="bg-rose-600 px-6 py-3 active:scale-90 duration-300 transition-all text-white rounded block font-semibold text-md">Back</a>
        </div>
    </div>
    <hr class="text-slate-100 my-4">

    <form action="./server/request.php" class="w-full flex flex-col gap-8" method="post" enctype="multipart/form-data">
        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Name</label>
            <input type="text" value="<?= $old['name'] ?? '' ?>" name="name"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Name...">
            <p class="text-rose-600"><?= $errors['name'] ?? ''  ?></p>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Age</label>
            <input type="text" value="<?= $old['age'] ?? '' ?>" name="age"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Age...">
            <p class="text-rose-600"><?= $errors['age'] ?? ''  ?></p>
        </div>


        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Email</label>
            <input type="text" name="email" value="<?= $old['email'] ?? '' ?>"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Email...">
            <p class="text-rose-600"><?= $errors['email'] ?? ''  ?></p>
        </div>



        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Mobile</label>
            <input type="text" name="mobile" value="<?= $old['mobile'] ?? '' ?>"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Mobile...">
            <p class="text-rose-600"><?= $errors['mobile'] ?? ''  ?></p>
        </div>



        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium">Address</label>
            <input type="text" name="address" value="<?= $old['address'] ?? '' ?>"
                class="border border-slate-200 rounded p-4 focus:outline-none" placeholder="Enter Your Address...">
            <p class="text-rose-600"><?= $errors['address'] ?? ''  ?></p>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium ">Image</label>
            <input type="file" name="image" accept="image/*"
                class="border border-slate-200 rounded p-4 focus:outline-none cursor-pointer">
            <p class="text-rose-600"><?= $errors['image'] ?? ''  ?></p>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-slate-800 font-medium ">Status</label>
            <select name="status" class="border border-slate-200 rounded p-4 focus:outline-none cursor-pointer">
                <option value="active">Active</option>
                <option value="deactive">Deactive</option>
            </select>
            <p class="text-rose-600"><?= $errors['status'] ?? ''  ?></p>
        </div>
        <div>
            <button type="submit" name="submit"
                class="px-4 py-2 text-white font-medium bg-indigo-500 rounded cursor-pointer active:scale-90 duration-300 transition-all">Submit</button>
        </div>
    </form>

</div>
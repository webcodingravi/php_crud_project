<?php
$successMessage = $_SESSION['success'] ?? '';
$errorMessage = $_SESSION['error'] ?? '';


unset($_SESSION['success'],$_SESSION['error']);

include_once "config/database.php";


$search = trim($_GET['search'] ?? '');

// Pagination basics
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit  = 5;
$offset = ($page - 1) * $limit;

/* =========================
   TOTAL RECORDS COUNT
========================= */
if (!empty($search)) {

    $like = "%$search%";

    $countSql = $conn->prepare(
        "SELECT COUNT(*) FROM users 
         WHERE name LIKE ? OR email LIKE ? OR mobile LIKE ?"
    );
    $countSql->execute([$like, $like, $like]);

} else {

    $countSql = $conn->prepare("SELECT COUNT(*) FROM users");
    $countSql->execute();
}

$totalRecords = $countSql->fetchColumn();
$totalPages   = ceil($totalRecords / $limit);

/* =========================
   FETCH DATA
========================= */
if (!empty($search)) {

    $sql = $conn->prepare(
        "SELECT * FROM users
         WHERE name LIKE ? OR email LIKE ? OR mobile LIKE ?
         ORDER BY id DESC
         LIMIT ? OFFSET ?"
    );

    $sql->bindValue(1, $like, PDO::PARAM_STR);
    $sql->bindValue(2, $like, PDO::PARAM_STR);
    $sql->bindValue(3, $like, PDO::PARAM_STR);
    $sql->bindValue(4, $limit, PDO::PARAM_INT);
    $sql->bindValue(5, $offset, PDO::PARAM_INT);

    $sql->execute();

} else {

    $sql = $conn->prepare(
        "SELECT * FROM users
         ORDER BY id DESC
         LIMIT ? OFFSET ?"
    );

    $sql->bindValue(1, $limit, PDO::PARAM_INT);
    $sql->bindValue(2, $offset, PDO::PARAM_INT);
    $sql->execute();
}

$users = $sql->fetchAll(PDO::FETCH_ASSOC);


?>


<div class="bg-white p-4 rounded w-8/12">
    <?php
       include "alertMessage.php";
    ?>
    <div class="flex justify-end items-center mb-4 space-x-7">
        <form action="" method="get">
            <input type="text" name="search" class="border border-slate-200 rounded px-6 py-3 focus:outline-none"
                placeholder="Search...">
            <button type="submit"
                class="px-6 py-3 bg-indigo-600 active:scale-90 duration-300 transition-all text-white cursor-pointer">Search</button>
        </form>

        <div>
            <a href="?create=true"
                class="bg-green-600 px-6 py-3 active:scale-90 duration-300 transition-all text-white rounded block font-semibold text-md">+
                Add
                User</a>
        </div>
    </div>
    <table class="w-full">
        <tr class="bg-indigo-400 text-left text-white">
            <th class="p-4">S.NO.</th>
            <th>Image</th>
            <th>Name</th>
            <th>Age</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <tbody>

            <?php
              foreach($users as $key=>$user) {
            
            ?>
            <tr class="text-slate-700 font-medium border-b border-slate-100">
                <td class="p-4"> <?= ++$key ?></td>
                <td>
                    <?php
              if(!empty($user['image'])) : ?>
                    <img src="uploads/<?= $user['image'] ?>" width="60" class="rounded-full my-4">
                    <?php else: ?>
                    No Image
                    <?php endif; ?>
                </td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['age'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['mobile'] ?></td>
                <td><?= $user['address'] ?></td>
                <td>

                    <?php
                if($user['status'] == 'active') {
                    echo "<span class='px-4 py-2 text-green-800 bg-green-100 rounded-xl'>Active</span>";
                }else{
                    echo "<span class='px-4 py-2 text-rose-800 bg-rose-100 rounded-xl'>Deactive</span>"; 
                }

                ?>

                </td>
                <td class="flex gap-2 mt-6">
                    <a href="?e-id=<?= $user['id'] ?>"
                        class="block active:scale-90 duration-300 transition-all bg-indigo-400 rounded px-4 py-2 text-white">Edit</a>

                    <form method="post" action="./server/request.php"
                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <button name="deleted"
                            class="block active:scale-90 duration-300 transition-all bg-rose-400 rounded px-4 py-2 text-white">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>

            <?php
                }

            
            ?>
        </tbody>
    </table>
    <div class="flex items-center justify-center mt-6 gap-1">
        <!-- Previous -->
        <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>"
            class="px-4 py-2 text-sm rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
            Prev
        </a>
        <?php else: ?>
        <span class="px-4 py-2 text-sm rounded-md bg-gray-100 border border-gray-200 text-gray-400 cursor-not-allowed">
            Prev
        </span>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>" class="px-4 py-2 text-sm rounded-md border transition
           <?= $i == $page
               ? 'bg-blue-600 border-blue-600 text-white'
               : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-100' ?>">
            <?= $i ?>
        </a>
        <?php endfor; ?>

        <!-- Next -->
        <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>"
            class="px-4 py-2 text-sm rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
            Next
        </a>
        <?php else: ?>
        <span class="px-4 py-2 text-sm rounded-md bg-gray-100 border border-gray-200 text-gray-400 cursor-not-allowed">
            Next
        </span>
        <?php endif; ?>

    </div>

</div>
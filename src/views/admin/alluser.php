<?php

// Redirect to login if user_id is not set
if (!isset($_SESSION['admin_id'])) {
  header('Location: /iods/login');
  exit();
}

$title = "មន្រ្តីទាំងអស់";
include('src/includes/header.php');
?>

<div class="col-12">
  <div class="card">
    <div class="table-responsive">
      <table class="table table-vcenter card-table table-striped">
        <thead>
          <tr>
            <th>ល.រ</th>
            <th>Name</th>
            <th>permission</th>
            <th></th>
            <th></th>
            <th>សកម្មភាព</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $cnt = 1; // Initialize $cnt outside the loop
          foreach ($allUsers['data'] as $index => $user): ?>
            <tr>
              <td class="text-sm font-weight-bold mb-0"><b><?= htmlspecialchars($cnt); ?></b></td>
              <td><?= htmlspecialchars($user['firstNameKh'] ?? 'N/A') ?></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                  <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                  <path d="M16 5l3 3" />
                </svg>
              </td>
            </tr>
            <?php
            $cnt++; // Increment $cnt
          endforeach; ?>
        </tbody>

      </table>
    </div>
  </div>
</div>





<?php include('src/includes/footer.php'); ?>
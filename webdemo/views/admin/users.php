<?php include __DIR__ . '/../layout/header.php'; ?>

<h2 class="text-center text-primary mb-4">👤 Quản lý người dùng</h2>

<div class="container">
  <div class="card shadow-sm rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Tên</th>
              <th scope="col">Ngày tạo</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once __DIR__ . '/../../models/User.php';
            $userModel = new User();
            $users = $userModel->getAll();

            foreach ($users as $user) {
                echo "<tr>
                    <td>{$user['id']}</td>
                    <td>{$user['username']}</td>
                    <td>" . date("d/m/Y H:i", strtotime($user['created_at'])) . "</td>
                </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php include __DIR__ . '/../layout/footer.php'; ?>
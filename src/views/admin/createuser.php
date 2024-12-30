<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start or resume session
}
$title = "បង្កើត​មន្រ្តី";
include('src/includes/header.php');

?>

<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Users</h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user...">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <!-- Add SVG icon for add button -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            បង្កើតមន្រ្តីថ្មី
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal create user -->
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">បង្កើតមន្រ្តីថ្មី</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/iods/createuser" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    autocomplete="off">
                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                                        <!-- Add SVG icon for password visibility -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                            </path>
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">បោះបង់</button>
                        <button type="submit" class="btn btn-primary ms-auto">បង្កើតមន្រ្តី</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <?php foreach ($getAllusers as $user): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card shadow-sm">
                            <div class="card-body text-center ">
                                <h4 class="mb-3">
                                    <a href="#" class="text-decoration-none text-green">
                                        <?= htmlspecialchars($user['Honorific'] . ' ' . $user['FirstName'] . ' ' . $user['LastName']) ?>
                                    </a>
                                </h4>
                                <div class="mb-2">
                                    <i class="bi bi-telephone"></i>
                                    <span class="text-secondary"><?= htmlspecialchars($user['Contact']) ?></span>
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-gender-ambiguous"></i>
                                    <span class="text-secondary"><?= htmlspecialchars($user['Gender']) ?></span>
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-info-circle"></i>
                                    <span class="text-secondary"><?= htmlspecialchars($user['Status']) ?></span>
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-calendar"></i>
                                    <span class="text-secondary"><?= htmlspecialchars($user['DateofBirth']) ?></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around p-3 bg-light border-top">
                                <a href="#" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                    <i class="bi bi-envelope me-2"></i>Email
                                </a>
                                <a href="#" class="btn btn-outline-success btn-sm d-flex align-items-center">
                                    <i class="bi bi-telephone me-2"></i>Call
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<?php include('src/includes/footer.php'); ?>
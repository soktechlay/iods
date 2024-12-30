<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start(); // Start or resume session
}
$title = "ឯកសារចូល";
include('src/includes/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <div class="container-xl flex-grow-1">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between">
                <div class="card-header">
                    <h4 class="py-3 mb-1 text-primary">
                        <span class="text-muted fw-light">អង្គភាពសវនកម្មផ្ទៃក្នុង/</span>ឯកសារចេញ
                    </h4>
                </div>
                <div class="dt-action-buttons pt-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        បញ្ជូលឯកសារចូល
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ការដាក់បញ្ជូលឯកសារចូល</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" class="row g-2 needs-validation" enctype="multipart/form-data"
                                novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="code" class="form-label">លេខឯកសារ</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-book'></i></span>
                                            <input type="text" class="form-control" id="code" name="code" required
                                                placeholder="បំពេញលេខឯកសារ...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="type" class="form-label">កម្មវត្តុ</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-detail'></i></span>
                                            <input type="text" class="form-control" id="type" name="type" required
                                                placeholder="បំពេញកម្មវត្តុ...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="echonomic" class="form-label">ទទួលពីក្រសួង/ស្ថាប័ន</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bxs-business'></i></span>
                                            <input type="text" class="form-control" id="echonomic" name="echonomic"
                                                required placeholder="បំពេញឈ្មោះស្ថាប័ន...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="give" class="form-label">មន្រ្តីប្រគល់</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                                            <input type="text" class="form-control" id="give" name="give"
                                                placeholder="បំពេញឈ្មោះមន្រ្តីប្រគល់...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="recrived" class="form-label">មន្រ្តីទទួល</label>
                                        <select class="form-select" id="recrived" name="recrived" required>
                                            <option value="">ជ្រើសរើស...</option>
                                            <!-- Add options dynamically here -->
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="document" class="form-label">ភ្ជាប់ឯកសារចូល</label>
                                        <input type="file" class="form-control" id="files" name="files" required
                                            accept=".pdf,.docx">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">បដិសេធ</button>
                                    <button type="submit" name="submit" class="btn btn-primary">រក្សាទុក</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="row">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-1">
                    <input type="text" id="search" placeholder="ស្វែងរក..." class="form-control">
                </div>
                <div class="col-md-4 mb-1">
                    <form method="post" id="filterForm" class="d-flex">
                        <input type="text" id="fromDate" name="fromDate" class="form-control me-1"
                            placeholder="ចាប់ពីថ្ងៃខែឆ្នាំ">
                        <input type="text" id="toDate" name="toDate" class="form-control me-1"
                            placeholder="ដល់ថ្ងៃទីខែឆ្នាំ">
                        <button type="submit" class="btn btn-secondary"><i class="bx bx-search"></i></button>
                    </form>
                </div>
                <div class="col-md-4 mb-1 text-end">
                    <form method="POST" action="export_script.php">
                        <input type="hidden" name="fromDate" value="">
                        <input type="hidden" name="toDate" value="">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-export"></i> Export
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table container for responsiveness -->
<div class="row">    
        <div class="card">            
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                        <tr>
                            <th>ល.រ</th>
                            <th>លេខឯកសារ</th>
                            <th>កម្មវត្តុ</th>
                            <th>ទទួលពីក្រសួង/ស្ថាប័ន</th>
                            <th>មន្រ្តីប្រគល់</th>
                            <th>ឯកសារចំណារ</th>
                            <th>កាលបរិច្ឆេទ</th>
                            <th>សកម្មភាព</th>
                        </tr>
                        </thead>
                        <tbody>
                            <!-- Add your data rows here -->
                        </tbody>
                    </table>
                </div>
            </div>
        
    </div>
</div>
<?php include('src/includes/footer.php'); ?>
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
                        <span class="text-muted fw-light">អង្គភាពសវនកម្មផ្ទៃក្នុង/</span>ឯកសារចូល
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
                            <form method="POST" action="/iods/createdocumentin" class="row g-3 needs-validation"
                                enctype="multipart/form-data" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="CodeId" class="form-label">លេខឯកសារ</label>
                                        <input type="text" class="form-control" id="CodeId" name="CodeId" required
                                            placeholder="បំពេញលេខឯកសារ...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="Type" class="form-label">កម្មវត្ថុ៖</label>
                                        <input type="text" class="form-control" id="Type" name="Type" required
                                            placeholder="បំពេញកម្មវត្ថុ...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="DepartmentName" class="form-label">ទទួលពីក្រសួង/ស្ថាប័ន</label>
                                        <input type="text" class="form-control" id="DepartmentName"
                                            name="DepartmentName" required placeholder="បំពេញឈ្មោះស្ថាប័ន...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="NameOfgive" class="form-label">មន្រ្តីប្រគល់ឯកសារ</label>
                                        <input type="text" class="form-control" id="NameOfgive" name="NameOfgive"
                                            placeholder="បំពេញឈ្មោះមន្រ្តីប្រគល់...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="NameOFReceive" class="form-label">មន្រ្តីទទួលឯកសារ</label>
                                        <select class="form-select" id="NameOFReceive" name="NameOFReceive" required>
                                            <option value="fg">ជ្រើសរើស...</option>
                                            <!-- Add dynamic options for NameOFReceive -->
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="Typedocument" class="form-label">ភ្ជាប់ឯកសារចូល</label>
                                        <input type="file" class="form-control" id="Typedocument" name="Typedocument"
                                            required accept=".pdf,.docx">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="date" class="form-label">កាលបរិច្ឆេទបញ្ចួល</label>
                                        <input type="datetime-local" class="form-control" id="date" name="date"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <div class="row w-100">
                                        <div class="col-6">
                                            <button type="button" class="btn w-100 btn-danger"
                                                data-bs-dismiss="modal">បោះបង់</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-success w-100">យល់ព្រម</button>
                                        </div>
                                    </div>
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
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <!-- Search Input -->
            <div class="col-md-4 mb-1">
                <form action="" method="POST" id="searchForm" class="d-flex">
                    <input type="text" name="search" id="search" placeholder="ស្វែងរក..."
                        value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>" class="form-control me-1">
                </form>
            </div>

            <!-- Date Range Filter -->
            <div class="col-md-4 mb-1">
                <form action="" method="POST" id="filterForm" class="d-flex">
                    <div class="form-group me-1">
                        <input type="date" id="fromDate" name="fromDate" class="form-control"
                            placeholder="ចាប់ពីថ្ងៃខែឆ្នាំ"
                            value="<?php echo htmlspecialchars($_POST['fromDate'] ?? ''); ?>">
                    </div>
                    <div class="form-group me-1">
                        <input type="date" id="toDate" name="toDate" class="form-control" placeholder="ដល់ថ្ងៃទីខែឆ្នាំ"
                            value="<?php echo htmlspecialchars($_POST['toDate'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-icon btn-secondary">
                        <i class="bx bx-search"></i>
                    </button>
                </form>
            </div>

            <!-- Export Button -->
            <div class="col-md-4 mb-1 text-end">
                <form method="POST" action="/iods/exportData" id="filterIndocument">
                    <input type="hidden" name="documentType" value="indocument">
                    <input type="hidden" name="fromDate" id="hiddenFromDate"
                        value="<?php echo htmlspecialchars($_POST['fromDate'] ?? ''); ?>">
                    <input type="hidden" name="toDate" id="hiddenToDate"
                        value="<?php echo htmlspecialchars($_POST['toDate'] ?? ''); ?>">
                    <input type="hidden" name="search" id="hiddenSearch"
                        value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-export me-1"></i>Export to Excel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add JavaScript for dynamic hidden inputs -->
<script>
    document.getElementById('fromDate').addEventListener('change', function () {
        document.getElementById('hiddenFromDate').value = this.value;
    });

    document.getElementById('toDate').addEventListener('change', function () {
        document.getElementById('hiddenToDate').value = this.value;
    });

    document.getElementById('search').addEventListener('input', function () {
        document.getElementById('hiddenSearch').value = this.value;
    });
</script>


<!-- Table container for responsiveness -->
<div class="row" id="results">
    <div class="card">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>ល.រ</th>
                            <th>លេខឯកសារ</th>
                            <th>កម្មវត្ថុ៖</th>
                            <th>ទទួលពីក្រសួង/ស្ថាប័ន</th>
                            <th>មន្រ្តីប្រគល់ឯកសារ</th>
                            <th>ឯកសារចំណារ</th>
                            <th>កាលបរិច្ឆេទបញ្ចួល</th>
                            <th>សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($documents)): ?>
                            <?php foreach ($documents as $index => $doc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($index + 1) ?></td>
                                    <td><?= htmlspecialchars($doc['CodeId']) ?></td>
                                    <td><?= htmlspecialchars($doc['Type']) ?></td>
                                    <td><?= htmlspecialchars($doc['DepartmentName']) ?></td>
                                    <td><?= htmlspecialchars($doc['NameOfgive']) ?></td>
                                    <td>
                                        <?php if (!empty($doc['document'])): ?>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#documentModal-<?php echo $doc['ID']; ?>">
                                                ពិនិត្យឯកសារ
                                            </a>
                                            <div class="modal fade modal-blur" id="documentModal-<?php echo $doc['ID']; ?>"
                                                tabindex="-1" aria-labelledby="documentModalLabel-<?php echo $doc['ID']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-primary"
                                                                id="documentModalLabel-<?php echo $doc['ID']; ?>">
                                                                ពិនិត្យមើលឯកសារចំណារ</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe src="public/uploads/file/indoc/<?php echo $doc['document']; ?>"
                                                                width="100%" height="600px"></iframe>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">បោះបង់</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a href="#" data-bs-toggle="modal" class="text-danger"
                                                data-bs-target="#uploadModal-<?php echo $doc['ID']; ?>">
                                                រងចាំឯកសារចំណារ
                                            </a>
                                            <!-- Modal Structure send noted -->
                                            <div class="modal fade modal-blur" id="uploadModal-<?php echo $doc['ID']; ?>"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="uploadModalLabel-<?php echo $doc['ID']; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="uploadModalLabel">Upload Document</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" enctype="multipart/form-data"
                                                            action="/iods/senddocument">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="ID"
                                                                    value="<?= htmlspecialchars($doc['ID']); ?>">
                                                                <div class="form-group mb-3">
                                                                    <label for="file" class="form-label">ភ្ជាប់ឯកសារចំណារ</label>
                                                                    <input type="file" name="document" id="file"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="department-select-<?php echo $doc['ID']; ?>"
                                                                        class="form-label">បញ្ចូនទៅកាន់នាយកដ្ឋានទទួលបន្ទុក</label>
                                                                    <select id="department-select-<?php echo $doc['ID']; ?>"
                                                                        name="DepartmentReceive[]" class="ts-select" multiple autocomplete="off">
                                                                        <option value="DC">District of Columbia</option>
                                                                        <option value="FL">Florida</option>
                                                                        <option value="GA">Georgia</option>
                                                                        <option value="HI">Hawaii</option>
                                                                        <option value="ID">Idaho</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label for="recipient-select-<?php echo $doc['ID']; ?>"
                                                                        class="form-label">បញ្ចូនទៅកាន់មន្រ្តីទទួលបន្ទុក</label>
                                                                    <select id="recipient-select-<?php echo $doc['ID']; ?>"
                                                                        name="NameRecipient[]" class="ts-select" multiple autocomplete="off">
                                                                        <option value="ដថដង">ដថដង</option>
                                                                        <option value="ឆេរតថដងឋ">ឆេរតថដងឋ</option>
                                                                        <option value="ថងហងថ">ថងហងថ</option>
                                                                        <option value="ផង">ផង</option>
                                                                        <option value="ល្ន្នថរ">ល្ន្នថរ</option>
                                                                    </select>
                                                                </div>

                                                                

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn me-auto"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Upload</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($doc['Date']) ?></td>
                                    <td>
                                        <a href="/edit-document.php?id=<?= $doc['ID']; ?>"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a href="/delete-document.php?id=<?= $doc['ID']; ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-danger">No documents found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Flatpickr JS -->
<script>
    flatpickr("#fromDate", {
        dateFormat: "Y-m-d",  // Set the date format (e.g., "YYYY-MM-DD")
    });
    flatpickr("#toDate", {
        dateFormat: "Y-m-d",
    });
</script>
<?php include('src/includes/footer.php'); ?>
<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user_id is not set
if (!isset($_SESSION['user_id'])) {
    header('Location: /iods/login');
    exit();
}

$title = "ទំព័រដើម";
include('src/includes/header.php');
?>

<div class="page-header d-print-none mt-0 mb-3">
    <div class="col-12">
        <div class="row g-2 align-items-center">
            <div class="col-12 d-flex align-items-center justify-content-between mb-3">
                <!-- Display the user's full name -->
                <h3 class="mb-0">
                    <span class="mef2 text-primary mx-2 me-0 mb-0">
                        <?php
                        // Check if session data exists
                        if (isset($_SESSION['user_khmer_name'])) {
                            // Display the full name with honorific
                            echo htmlspecialchars($_SESSION['user_khmer_name']);
                        } else {
                            // Fallback text if session data is not available
                            echo 'User Name';
                        }
                        ?>
                    </span>
                </h3>
                <div class="dropdown">
                    <?php date_default_timezone_set('Asia/Bangkok'); ?>
                    <button class="btn btn-primary">
                        <i class="bx bx-calendar me-2"></i>
                        <span id="real-time-clock"><?php echo date('D-m-Y h:i:s A'); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateDateTime() {
        const clockElement = document.getElementById('real-time-clock');
        const currentTime = new Date();

        const daysOfWeek = ['អាទិត្យ', 'ច័ន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍'];
        const dayOfWeek = daysOfWeek[currentTime.getDay()];

        const months = ['មករា', 'កុម្ភៈ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];
        const month = months[currentTime.getMonth()];

        const day = currentTime.getDate();
        const year = currentTime.getFullYear();

        let hours = currentTime.getHours();
        let period;

        if (hours >= 5 && hours < 12) {
            period = 'ព្រឹក'; // Khmer for AM (morning)
        } else if (hours >= 12 && hours < 17) {
            period = 'រសៀល'; // Khmer for afternoon
        } else if (hours >= 17 && hours < 20) {
            period = 'ល្ងាច'; // Khmer for evening
        } else {
            period = 'យប់'; // Khmer for night
        }

        hours = hours % 12 || 12;
        const minutes = currentTime.getMinutes().toString().padStart(2, '0');
        const seconds = currentTime.getSeconds().toString().padStart(2, '0');

        const dateTimeString = `${dayOfWeek}, ${day} ${month} ${year} ${hours}:${minutes}:${seconds} ${period}`;
        clockElement.textContent = dateTimeString;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

<div class="row">
    <!-- Incoming Document Activity Card -->
    <div class="col">
        <div class="card h-100 border-0 shadow">
            <div class="card-header text-primary text-white d-flex justify-content-center align-items-center">
                <div class="card-title mb-0 h1">សកម្មភាពឯកសារចូល</div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>មកពីស្ថាប័នឬក្រសួង</th>
                                <th>ឈ្មោះមន្រ្តីប្រគល់</th>
                                <th>កាលបរិច្ឆេទ</th>
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
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card h-100 border-0 shadow">
            <div class="card-header text-primary text-white d-flex justify-content-center align-items-center">
                <div class="card-title mb-0 h1">សកម្មភាពឯកសារចេញ</div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ចេញទៅស្ថាប័នឬក្រសួង</th>
                                <th>ឈ្មោះមន្រ្តីទទួល</th>
                                <th>កាលបរិច្ឆេទ</th>
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
</div>

<?php
include('src/includes/footer.php');
?>
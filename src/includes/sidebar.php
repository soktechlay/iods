<?php
function getUserPermissions($userId)
{
    global $dbh; // Access the global $dbh variable
    $query = "SELECT p.name 
              FROM permissions p
              INNER JOIN user_permissions up ON p.id = up.permission_id
              WHERE up.user_id = :userId";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Usage example
$userId = $_SESSION['user_id'];
$userPermissions = getUserPermissions($userId);

// Get the current page name

$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$is_management_active = in_array($current_page, ['iniaudocument', 'outiaudocument']);

?>
<style>
    .nav-link.active,
    .dropdown-item.active {
        color: #0d6efd !important;
        /* Bootstrap Primary Blue */
    }

    .nav-item.active .nav-link-title {
        color: #0d6efd !important;
        /* Make the title blue */
    }

    .nav-item.active .dropdown-toggle {
        color: #0d6efd !important;
        /* Make the dropdown link blue */
    }
</style>

<header class=" navbar-expand-md bg-light shadow-sm d-print-none">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl h-100">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="navbar-nav me-auto">
                        <!-- Dashboard Link -->
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'dashboard') ? 'active' : '' ?>"
                                href="/iods/dashboard">
                                <span class="nav-link-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon icon-tabler icon-tabler-home">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                    ទំព័រដើម
                                </span>
                            </a>
                        </li>

                        <!-- Dropdown Menu for User Permissions -->
                        <?php if (in_array('iau', $userPermissions)): ?>
                            <li class="nav-item dropdown">
                                <a href="#"
                                    class="nav-link dropdown-toggle <?= ($current_page == 'iniaudocument' || $current_page == 'outiaudocument') ? 'active' : '' ?>"
                                    data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="nav-link-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="icon icon-tabler icon-tabler-box">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 3l8 4.5v9l-8 4.5l-8-4.5v-9l8-4.5" />
                                            <path d="M12 12l8-4.5" />
                                            <path d="M12 12v9" />
                                            <path d="M12 12l-8-4.5" />
                                        </svg>
                                        គ្រប់គ្របងបញ្ចីឯកសារចេញចូលអង្គភាព
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item <?= ($current_page == 'iniaudocument') ? 'active' : '' ?>"
                                            href="/iods/iniaudocument">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icon-tabler-arrow-big-right-line">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-6v-6h6z" />
                                                <path d="M3 9v6" />
                                            </svg>
                                            បញ្ចីឯកសារចូល
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item <?= ($current_page == 'outiaudocument') ? 'active' : '' ?>"
                                            href="/iods/outiaudocument">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icon-tabler-arrow-big-right-line">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-6v-6h6z" />
                                                <path d="M3 9v6" />
                                            </svg>
                                            បញ្ចីឯកសារចេញ
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>


                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
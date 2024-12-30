<?php
require_once 'src/models/document/DocumentModel.php';
require_once 'src/models/User.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Documentcontroller
{
    public function iniaudocument()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        // Retrieve filters from POST data

        $search = !empty($_POST['search']) ? $_POST['search'] : null;
        $fromDate = $_POST['fromDate'] ?? null;
        $toDate = $_POST['toDate'] ?? null;

        // Ensure format is correct
        if ($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
        }
        if ($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
        }

        // Use DocumentModel to fetch documents
        $model = new DocumentModel();
        $documents = $model->getAllDocuments($userId, 0, $fromDate, $toDate, $search);

        // Render the view
        require 'src/views/user/iniau.php';
    }
    public function outiaudocument()
    {
        require 'src/views/user/outiau.php';
    }

    public function createdocumentin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input data
            $CodeId = trim($_POST['CodeId']);
            $Type = trim($_POST['Type']);
            $DepartmentName = trim($_POST['DepartmentName']);
            $NameOfgive = trim($_POST['NameOfgive']);
            $NameOFReceive = trim($_POST['NameOFReceive']);
            $date = trim($_POST['date']);
            $userId = $_SESSION['user_id'] ?? 0;
            $departmentId = $_SESSION['departmentId'] ?? null;
            $officeId = $_SESSION['officeId'] ?? null;

            // Validate session data
            if (!$departmentId || !$officeId) {
                echo 'Invalid session data: departmentId or officeId is missing.';
                exit;
            }

            $model = new DocumentModel();
            if ($model->docExists($CodeId, $userId, 0)) {
                $_SESSION['error'] = "ឯកសារដែលមានលេខកូដនេះមានរួចហើយ។";
                header("Location: /iods/iniaudocument");
                exit;
            }

            // Handle file upload if provided
            if (isset($_FILES['Typedocument']) && $_FILES['Typedocument']['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = $_FILES['Typedocument'];
                $uploadDir = 'public/uploads/file/indoc/';
                $fileName = basename($uploadedFile['name']); // Generate unique file name
                $filePath = $uploadDir . $fileName; // Full path for the file

                // Ensure the target directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
                    $Typedocument = $fileName; // Store only the file name for the database
                } else {
                    echo 'Failed to upload file.';
                    exit;
                }
            } elseif (isset($_FILES['Typedocument'])) {
                echo 'File upload error.';
                exit;
            }
            // Model interaction
            $model = new DocumentModel();
            $result = $model->insertDocument(
                $CodeId,
                $Type,
                $DepartmentName,
                $NameOfgive,
                $NameOFReceive,
                $Typedocument,
                $date,
                $userId,
                $departmentId,
                $officeId
            );

            if ($result) {
                $_SESSION['success'] = "ឯកសារបានបង្កើតដោយជោគជ័យ។";

                header("Location: /iods/iniaudocument");
                exit;
            } else {
                $_SESSION['error'] = "មិនអាចបង្កើតឯកសារបានទេ។";

                header("Location: /iods/iniaudocument");
                exit;
            }

        }
    }
    public function uploadDocument()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $ID = $_POST['ID'];
        $department = $_POST['DepartmentReceive'];
        $recipient = $_POST['NameRecipient'];

        // Handle file upload
        if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['document'];

            // Ensure that the $file is an array with necessary keys
            if (is_array($file) && isset($file['tmp_name']) && isset($file['name']) && isset($file['size'])) {
                $fileTmp = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileName = basename($file['name']); // Extract file name

                // Validate file size (e.g., 100MB max)
                if ($fileSize <= 104857600) { // 100MB in bytes
                    $uploadDir = 'public/uploads/file/notedoc/';
                    $filePath = $uploadDir . $fileName;

                    // Move uploaded file
                    if (move_uploaded_file($fileTmp, $filePath)) {
                        // Save only the file name in the database
                        $model = new DocumentModel();
                        $model->saveDocument([
                            'ID' => $ID,
                            'DepartmentReceive' => implode(',', $department),
                            'NameRecipient' => implode(',', $recipient),
                            'document' => $fileName // Save only the file name (not the full path)
                        ]);
                        $_SESSION['success'] = 'ផ្ទេរឯកសារបានជោគជ័យ។';
                    } else {
                        $_SESSION['error'] = 'មានកំហុសក្នុងការបញ្ជូនឯកសារ។';
                    }
                } else {
                    $_SESSION['error'] = 'ទំហំឯកសារដាក់លើសពីដែនកំណត់ 100MB។';
                }
            } else {
                $_SESSION['error'] = 'រចនាសម្ព័ន្ធឯកសារមិនត្រឹមត្រូវ ឬ ប៉ារ៉ាម៉ែត្របញ្ជូនឯកសារខ្វះ។';
            }
        } else {
            $_SESSION['error'] = 'មិនមានឯកសារបញ្ជូន ឬ កំហុសក្នុងការបញ្ជូនឯកសារ។';
        }
    }

    // Redirect back to the appropriate page
    header('Location: /iods/iniaudocument');
    exit;
}

    public function export()
    {
        require 'src/views/user/export_script.php';
    }
    public function exportData()
    {
        // Collect form data
        $documentType = $_POST['documentType'] ?? '';
        $fromDate = $_POST['fromDate'] ?? '';
        $toDate = $_POST['toDate'] ?? '';
        $search = $_POST['search'] ?? '';

        // Query data based on form inputs
        $model = new DocumentModel();
        $data = $model->getFilteredData($documentType, $fromDate, $toDate, $search);

        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['ID', 'Document Type', 'Date', 'Content', 'Additional Fields...'];
        $sheet->fromArray($headers, null, 'A1');

        // Populate data
        $rowIndex = 2; // Starting row for data
        foreach ($data as $row) {
            $sheet->fromArray(array_values($row), null, "A{$rowIndex}");
            $rowIndex++;
        }

        // Style headers (optional)
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->getFont()->setBold(true);

        // Output file
        $fileName = 'Exported_Data_' . date('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }



}

<?php
// Include PhpSpreadsheet library
require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get filter inputs
$fromDate = $_POST['fromDate'] ?? null;
$toDate = $_POST['toDate'] ?? null;
$search = $_POST['search'] ?? null;

// Initialize the model (assumes you have a DocumentModel class)
$model = new DocumentModel();
$userId = $_SESSION['user_id'] ?? 0;

// Fetch filtered data from the model
$documents = $model->getAllDocuments($userId, 0, $fromDate, $toDate, $search);

// Check if there is data to export
if (empty($documents)) {
    die('No data available for export.');
}

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the header row for the Excel sheet
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Document Code');
$sheet->setCellValue('C1', 'Type');
$sheet->setCellValue('D1', 'Department Name');
$sheet->setCellValue('E1', 'Name of Giver');
$sheet->setCellValue('F1', 'Typedocument');
$sheet->setCellValue('G1', 'Date');

// Write rows of document data
$row = 2; // Start row for data
foreach ($documents as $document) {
    $sheet->setCellValue('A' . $row, $document['ID']);
    $sheet->setCellValue('B' . $row, $document['CodeId']);
    $sheet->setCellValue('C' . $row, $document['Type']);
    $sheet->setCellValue('D' . $row, $document['DepartmentName']);
    $sheet->setCellValue('E' . $row, $document['NameOfgive']);
    $sheet->setCellValue('F' . $row, $document['Typedocument']);
    $sheet->setCellValue('G' . $row, date('Y-m-d', strtotime($document['Date']))); // Format date
    $row++;
}

// Set the filename for the Excel file
$filename = 'export_' . date('Ymd_His') . '.xlsx';

// Create an Excel writer and output to the browser
$writer = new Xlsx($spreadsheet);

// Set headers for Excel download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Output the Excel file
$writer->save('php://output');
exit;
?>

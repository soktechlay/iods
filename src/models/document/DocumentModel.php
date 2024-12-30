<?php

class DocumentModel
{
    private $dbh;

    public function __construct()
    {
        global $dbh;
        $this->dbh = $dbh;
    }

    public function insertDocument($CodeId, $Type, $DepartmentName, $NameOfgive, $NameOFReceive, $Typedocument, $date, $userId, $departmentId, $officeId)
    {
        $sql = "INSERT INTO indocument (codeId, type, departmentName, nameOfgive, nameOfReceive, Typedocument, date, user_id, Department, office) 
                VALUES (:codeId, :type, :departmentName, :nameOfgive, :nameOfReceive, :Typedocument, :date, :user_id, :department, :office)";

        $stmt = $this->dbh->prepare($sql);

        return $stmt->execute([
            ':codeId' => $CodeId,
            ':type' => $Type,
            ':departmentName' => $DepartmentName,
            ':nameOfgive' => $NameOfgive,
            ':nameOfReceive' => $NameOFReceive,
            ':Typedocument' => $Typedocument,
            ':date' => $date,
            ':user_id' => $userId,
            ':department' => $departmentId,
            ':office' => $officeId,
        ]);
    }
    public function saveDocument($data)
    {
        // Correct the SQL query to use UPDATE, not INTO
        $sql = "UPDATE indocument 
            SET document = :document, DepartmentReceive = :DepartmentReceive, NameRecipient = :NameRecipient
            WHERE id = :ID";

        // Prepare and execute the statement
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([
            ':document' => $data['document'], // Storing file path
            ':DepartmentReceive' => $data['DepartmentReceive'],
            ':NameRecipient' => $data['NameRecipient'],
            ':ID' => $data['ID'] // Adding ID for WHERE clause
        ]);
    }

    public function docExists($CodeId, $userId, $isDelete = 0)
    {
        global $dbh; // Assuming $dbh is the database connection object

        $query = "SELECT COUNT(*) FROM indocument 
                  WHERE CodeId = :CodeId AND user_id = :user_id AND isdelete = :isDelete";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':CodeId', $CodeId, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':isDelete', $isDelete, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
    public function getAllDocuments($userId, $isDelete = 0, $fromDate = null, $toDate = null, $search = null)
    {
        global $dbh;

        $query = "SELECT ID, CodeId, Type, DepartmentName, NameOfgive, Typedocument, Date , document
              FROM indocument 
              WHERE user_id = :userId 
              AND isdelete = :isDelete";

        // Add date range filter (use DATE() to match only the date part of the TIMESTAMP)
        if ($fromDate && $toDate) {
            $query .= " AND DATE(Date) BETWEEN :fromDate AND :toDate";
        }

        // Add search filter
        if ($search) {
            $query .= " AND (CodeId LIKE :search OR Type LIKE :search OR DepartmentName LIKE :search)";
        }

        $query .= " ORDER BY ID DESC";

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':isDelete', $isDelete, PDO::PARAM_INT);

        // Bind date range parameters
        if ($fromDate && $toDate) {
            $stmt->bindParam(':fromDate', $fromDate);
            $stmt->bindParam(':toDate', $toDate);
        }

        // Bind search parameter
        if ($search) {
            $searchTerm = "%" . $search . "%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFilteredData($documentType, $fromDate, $toDate, $search)
    {
        $query = "SELECT * FROM indocument WHERE documentType = :documentType";
        $params = ['documentType' => $documentType];

        if (!empty($fromDate) && !empty($toDate)) {
            $query .= " AND Date BETWEEN :fromDate AND :toDate";
            $params['fromDate'] = $fromDate;
            $params['toDate'] = $toDate;
        }

        if (!empty($search)) {
            $query .= " AND content LIKE :search";
            $params['search'] = "%$search%";
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

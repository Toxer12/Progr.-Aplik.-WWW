<?php
include('cfg.php');

$page_id = isset($_GET['page']) ? intval($_GET['page']) : 1;

$sql = "SELECT page_title, page_content FROM page_list WHERE id = ? AND status = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $page_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . $row['page_content'] . "</p>";
    }
} else {
    echo "Strona nie została znaleziona.";
}

$stmt->close();
?>

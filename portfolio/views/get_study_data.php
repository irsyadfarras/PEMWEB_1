<?php
require_once '../config/database.php';

header('Content-Type: application/json');

if(!isset($_GET['id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$id = $_GET['id'];
$action = $_GET['action'] ?? 'detail';

if($action == 'detail') {
    $stmt = $pdo->prepare("
        SELECT s.*, l.nama as level_name 
        FROM studies s 
        JOIN level l ON s.idlevel = l.id 
        WHERE s.id = ?
    ");
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    if($data) {
        echo json_encode([
            'success' => true,
            'id' => $data['id'],
            'nama' => $data['nama'],
            'level_name' => $data['level_name'],
            'tahun_lulus' => $data['tahun_lulus'],
            'foto' => $data['foto_sekolah'],
            'keterangan' => $data['keterangan'],
            'created_at' => date('d/m/Y H:i:s', strtotime($data['created_at']))
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} 
elseif($action == 'edit') {
    $stmt = $pdo->prepare("SELECT * FROM studies WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    if($data) {
        echo json_encode([
            'success' => true,
            'id' => $data['id'],
            'nama' => $data['nama'],
            'idlevel' => $data['idlevel'],
            'tahun_lulus' => $data['tahun_lulus'],
            'foto' => $data['foto_sekolah'],
            'keterangan' => $data['keterangan']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
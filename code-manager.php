
<?php
$file = 'codes.json';
if (!file_exists($file)) file_put_contents($file, '{}');
$data = json_decode(file_get_contents($file), true);
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'use') {
    $code = $_POST['code'];
    if (!isset($data[$code])) {
        echo json_encode(['success' => false, 'message' => 'Invalid code.']);
        exit;
    }
    if ($data[$code]['used'] >= $data[$code]['max']) {
        echo json_encode(['success' => false, 'message' => 'Usage limit reached.']);
        exit;
    }
    $data[$code]['used']++;
    file_put_contents($file, json_encode($data));
    echo json_encode(['success' => true]);
} elseif ($action === 'add') {
    $code = $_POST['code'];
    $max = intval($_POST['max']);
    $data[$code] = ['used' => 0, 'max' => $max];
    file_put_contents($file, json_encode($data));
    echo "OK";
} elseif ($action === 'delete') {
    $code = $_POST['code'];
    unset($data[$code]);
    file_put_contents($file, json_encode($data));
    echo "Deleted";
} elseif ($action === 'list') {
    echo json_encode($data);
}
?>

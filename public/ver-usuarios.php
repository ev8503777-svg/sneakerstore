<?php
$db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$users = $db->query('SELECT id, name, email, password, is_admin, created_at FROM users')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Usuarios - SneakerStore</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #1a1a2e; color: white; }
        h1 { color: #e94560; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #e94560; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #444; font-size: 12px; }
        tr:hover { background: #2a2a4e; }
        .hash { color: #aaffaa; word-break: break-all; font-family: monospace; font-size: 11px; }
        .admin { color: #ffaa00; font-weight: bold; }
        .badge { background: #e94560; padding: 2px 8px; border-radius: 10px; font-size: 11px; }
    </style>
</head>
<body>
    <h1>🔐 Usuarios con Contraseñas Encriptadas (bcrypt)</h1>
    <p style="color:#aaa">Base de datos: SQLite | Algoritmo: <strong style="color:#4caf50">bcrypt (Blowfish)</strong> | Laravel Hash</p>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Contraseña Encriptada (Hash bcrypt)</th>
            <th>Admin</th>
            <th>Creado</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td class="hash"><?= htmlspecialchars($u['password']) ?></td>
            <td><?= $u['is_admin'] ? '<span class="admin badge">✅ Admin</span>' : '👤 Usuario' ?></td>
            <td><?= $u['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p style="margin-top:20px; color:#aaa; font-size:12px">
        ⚠️ El hash bcrypt NO se puede revertir. Laravel lo verifica con <code>Hash::check()</code>
    </p>
</body>
</html>

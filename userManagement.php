<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';
include_once __DIR__ . '/src/Service/Database.php';
include_once __DIR__ . '/src/Repository/UserRepository.php';

$userRepository = new UserRepository();

$currentUser = $userRepository->getById($_SESSION['user_id']);

if (!$currentUser->isAdmin()) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Benutzerverwaltung</title>
    <link rel="stylesheet" href="public/css/user-management.css">
    <link rel="stylesheet" href="public/css/navigation.css">
</head>
<body>
    <div class="container">

        <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

        <div class="content">
            <div class="user-management-container">
                <h1>Benutzerverwaltung</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Vollständiger Name</th>
                            <th>E-Mail</th>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody id="user-list"></tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    let users = [];

    function loadUsers() {
        fetch('/src/Api/allUsers.php?auth_code=MatwMdTOoszgfVyCnTHQ')
            .then(response => response.json())
            .then(data => {
                users = data;

                const userList = document.querySelector('#user-list');

                userList.innerHTML = '';

                users.forEach(user => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <td>${user.fullName}</td>
                        <td>${user.email}</td>
                        <td>
                            <button class="edit-button">Bearbeiten</button>
                            <button class="delete-button">Löschen</button>
                        </td>
                    `;

                    userList.appendChild(tr);

                    const deleteButton = tr.querySelector('.delete-button');
                    deleteButton.addEventListener('click', function() {
                        deleteUser(user.id);
                    });

                    const editButton = tr.querySelector('.edit-button');
                    editButton.addEventListener('click', function() {
                        window.location.href = `editUserSettings.php?id=${user.id}`;
                    });
                });
            })
            .catch(error => {
                console.error('Fehler beim Abrufen aller Benutzer:', error);
            });
    }

    function deleteUser(id) {
        fetch(`/src/Api/deleteUser.php?id=${id}&auth_code=MatwMdTOoszgfVyCnTHQ`, {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    console.log(`Benutzer mit ID ${id} erfolgreich gelöscht`);
                    loadUsers();
                } else {
                    console.error(`Fehler beim Löschen des Benutzers mit ID ${id}`);
                }
            })
            .catch(error => {
                console.error(`Fehler beim Löschen des Benutzers mit ID ${id}:`, error);
            });
    }

    loadUsers();
</script>
</html>

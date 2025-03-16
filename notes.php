<!DOCTYPE html>
<html lang="en">
<?php include 'modules/header.php'; ?>
<body>
    <?php include 'modules/nav-logged.php'; ?>
    <hr />
    <section>
        <h2 class='user-notes'>Twoje notatki</h2>
        <div class="note">
            <h2 class="note-title">Tytul notatki</h2>
            <div class="edit-delete">
                <div class="container">
                <a href="edit.php" class="edit">Edytuj</a>
                <a href="delete.php" class="delete">Usuń</a>
                </div>
            </div>
        </div>
        <div class="add-note">
            <a href="add.php" class="add">&#10010;</a>
        </div>
    </section>
    <?php include 'modules/footer.php'; ?>
</body>
</html>
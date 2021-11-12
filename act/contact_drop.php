<?php
session_start();
include('../include/config.php');

if (isset($_GET['contact_id']) && !empty($_GET['contact_id']))
{
    $contact_id = $_GET['contact_id'];

    $contact = $db->prepare("SELECT id FROM contacts WHERE id=?");
    $contact->execute([
        $contact_id,
    ]);

    if ($contact->rowCount() > 0)
    {
        $contact = $db->prepare("DELETE FROM contacts WHERE id=?");
        $check = $contact->execute([
            $contact_id,
        ]);

        if ($check)
        {
            $success = "Contact successfully deleted.";
        }
        else
        {
            $error = "Contact does't successfully deleted, please try again.";
        }
    }
    else
    {
        $error = "Contact histry does't found.";
    }
}
else
{
    $error = "Contact histry does't found.";
}


if (isset($error))
{
    $_SESSION['error'] = $error;
}
else
{
    $_SESSION['success'] = $success;
}

header("Location: ../contact_list.php");
exit();
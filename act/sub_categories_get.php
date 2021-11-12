<?php

session_start();
include('../include/config.php');

if (isset($_GET['category_id']) && !empty($_GET['category_id']))
{
    $category_id = $_GET['category_id'];

    $category = $db->prepare("SELECT id FROM categories WHERE id=?");
    $category->execute([
        $category_id,
    ]);

    if ($category->rowCount() > 0)
    {
        $sub_categories = $db->prepare("SELECT id, name FROM s_categories WHERE category_id=?");
        $sub_categories->execute([
            $category_id,
        ]);

        if (!isset($_GET['select']))
        {
            ?>
            <option value="0">Select Product Sub-Category</option>
            <?php
            while ($sub_category = $sub_categories->fetchObject())
            {
                ?>
                <option value="<?= $sub_category->id ?>"><?= $sub_category->name ?></option>
                <?php
            }
        } else
        {
            while ($sub_category = $sub_categories->fetchObject())
            {
                if ($sub_category->id == $_GET['select'])
                {
                    ?>
                    <option value="<?= $sub_category->id ?>" selected><?= $sub_category->name ?></option>
                    <?php
                } else
                {
                    ?>
                    <option value="<?= $sub_category->id ?>"><?= $sub_category->name ?></option>
                    <?php
                }
            }
        }

    }
}
?>
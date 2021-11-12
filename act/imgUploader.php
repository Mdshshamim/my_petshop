<?php
function imgUploader($fileToUpload)
{
    $target_dir = "../../uploads/";
    $time = time();
    $target_file = $target_dir . '' . $time . '-' . basename($_FILES[$fileToUpload]["name"]);
    $img = $time . '-' . basename($_FILES[$fileToUpload]["name"]);
    $i = 0;
    while (file_exists($target_file))
    {
        $i++;
        $target_file = $target_dir . '' . $time . '-' . $i . '' . basename($_FILES[$fileToUpload]["name"]);
        $img = $time . '-' . $i . '' . basename($_FILES[$fileToUpload]["name"]);
    }
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$fileToUpload]["tmp_name"]);
    if ($check != false)
    {
        $uploadOk = 1;
    } else
    {
        // return "File is not an image.";
        return null;
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file))
    {
        // return "Sorry, file already exists.";
        return null;
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES[$fileToUpload]["size"] > 500000)
    {
        // return "Sorry, your file is too large.";
        return null;
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    )
    {
        // return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return null;
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        // return "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        return null;
    } else
    {
        if (move_uploaded_file($_FILES[$fileToUpload]["tmp_name"], $target_file))
        {
            return $img;
        } else
        {
            // return "Sorry, there was an error uploading your file.";
            return null;
        }
    }
}

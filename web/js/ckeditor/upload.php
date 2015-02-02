<?php
if (file_exists("/../../../uploads/" . $_FILES["upload"]["name"]))
{
 echo $_FILES["upload"]["name"] . " already exists. ";
}
else
{
 move_uploaded_file($_FILES["upload"]["tmp_name"],
 __DIR__."/../../uploads/" . $_FILES["upload"]["name"]);
 echo " Image upload�e dans : " . __DIR__."/../../uploads/" . $_FILES["upload"]["name"];
}

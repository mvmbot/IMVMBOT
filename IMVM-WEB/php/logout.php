<?php
#region Required files
require_once("redirectFunctions.php");
#endregion

#region Logout proccess
session_start();
session_destroy();
redirectToIndex();
#endregion
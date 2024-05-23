<?php
/*
 * File: logout
 * Author: Álvaro Fernández
 * Github 1: https://github.com/afernandezmvm (School acc)
 * Github 2: https://github.com/JisuKlk (Personal acc)
 * Desc: File responsible for logging out whether is an user or admin
 */

#region Required files
require_once ("redirectFunctions.php");
#endregion

#region Logout proccess
session_start();
session_destroy();
redirectToIndex();
#endregion
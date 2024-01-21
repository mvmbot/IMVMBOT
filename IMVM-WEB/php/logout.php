<?php
// Grab some handy tools for our code!
require("redirectFunctions.php");

session_start();
session_destroy();
redirectToIndex();
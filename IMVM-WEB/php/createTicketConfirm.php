<?php
#region Required files
# Get the database stuff ready
require('databaseFunctions.php');

# Grab some tools for our code
require('redirectFunctions.php');
require('dataValidationFunctions.php');
require('errorAlerts.php');
#endregion

#region errors
# Turn on the error reporting to see any coding errors!
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

# Now, let's connect to our database!
connectToDatabase();

# We grab all the data from the form
$type = $_POST['type'] ?? ''; # First of all, we get the type so we know what table to look in
$fieldsToCheck; # This will hold an array with fields that need validation
# Switch case to fill the values from every possible type
switch ($type) {

    #region Help & Support!
    case 'helpSupportFields':
        $subject = $_POST['subject'] ?? '';
        $description = $_POST['description'] ?? '';
        $fileAttachment = $_POST['attachment'] ?? '';
        $fieldsToCheck = ['subject', 'description', 'attachment'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        createTicketHelpSupportFields($subject, $fileAttachment, $description);
        break;
    #endregion

    #region Bug Reporting!
    case 'bugReportFields':
        $bugDescription = $_POST['bugDescription'] ?? '';
        $stepsToReproduce = $_POST['stepsToReproduce'] ?? '';
        $expectedResult = $_POST['expectedResult'] ?? '';
        $receivedResult = $_POST['receivedResult'] ?? '';
        $discordClient = $_POST['discordClient'] ?? '';
        $bugImage = $_POST['bugImage'] ?? '';
        $fieldsToCheck = ['bugDescription', 'stepsToReproduce', 'expectedResult', 'receivedResult', 'discordClient'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        break;
    #endregion

    #region  Feature Request!
    case 'featureRequest':
        $requestType = $_POST['requestType'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $description = $_POST['description'] ?? '';
        $fieldsToCheck = ['requestType', 'subject', 'description'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        break;
    #endregion

    #region Grammar Issues!
    case 'grammarIssues':
        $subject = $_POST['subject'] ?? '';
        $description = $_POST['description'] ?? '';
        $fileAttachment = $_POST['fileAttachment'] ?? '';
        $fieldsToCheck = ['subject', 'description', 'fileAttachment'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        break;
    #endregion

    #region Information Update!
    case 'informationUpdate':
        $subject = $_POST['subject'] ?? '';
        $updateInfo = $_POST['updateInfo'] ?? '';
        $fieldsToCheck = ['subject', 'updateInfo'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        break;
    #endregion

    #region Other Issues!
    case 'other':
        $subject = $_POST['subject'] ?? '';
        $description = $_POST['description'] ?? '';
        $fieldsToCheck = ['subject', 'description'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        break;
    #endregion

    #region Default
    default:
        break;
    #endregion
}


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
        createTicketHelpSupportFields($conn, $subject, $fileAttachment, $description);
        break;
    #endregion

    #region Bug Reporting!
    case 'bugReportFields':
        $subject = $_POST['subject']?? '';
        $impactedPart = $_POST['impactedPart'] ?? '';
        $operativeSystem = $_POST['operativeSystem'] ?? '';
        $bugDescription = $_POST['bugDescription'] ?? '';
        $stepsToReproduce = $_POST['stepsToReproduce'] ?? '';
        $expectedResult = $_POST['expectedResult'] ?? '';
        $receivedResult = $_POST['receivedResult'] ?? '';
        $discordClient = $_POST['discordClient'] ?? '';
        $bugImage = $_POST['bugImage'] ?? '';
        $fieldsToCheck = ['bugDescription', 'stepsToReproduce', 'expectedResult', 'receivedResult', 'discordClient', 'subject', 'impactedPart', 'operativeSystem'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        break;
    #endregion

    #region  Feature Request!
    case 'featureRequestFields':
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
    case 'grammarIssuesFields':
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
    case 'informationUpdateFields':
        $subject = $_POST['subject'] ?? '';
        $updateInfo = $_POST['updateInfo'] ?? '';
        $fieldsToCheck = ['subject', 'updateInfo'];
        if (areFieldsEmpty($fieldsToCheck)) {
            redirectToSignup();
        }
        break;
    #endregion

    #region Other Issues!
    case 'otherFields':
        $subject = $_POST['subject'] ?? '';
        $description = $_POST['description'] ?? '';
        $extraText = $_POST['extraText'] ?? '';
        $fieldsToCheck = ['subject', 'description', 'extraText'];
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


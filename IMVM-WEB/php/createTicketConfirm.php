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
# Turn on the error reporting to see any coding errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

# Now, let's connect to our database
$conn = connectToDatabase();

# We grab all the data from the form
$type = $_POST['type'] ?? ''; # First of all, we get the type so we know what table to look in
$fieldsToCheck; # This will hold an array with fields that need validation

$targetDirectory =  './userUploads/'; # Directory where images should
# Switch case to fill the values from every possible type
switch ($type) {

        #region Help & Support
    case 'helpSupport':
        $subject = $_POST['subjectHelpSupportFields'] ?? '';
        $description = $_POST['descriptionHelpSupportFields'] ?? '';

        $inputs = array(
            $subject,
            $description
        );

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        #$fileAttachment = $targetDirectory . basename($_FILES["fileAttachmentHelpSupportFields"]);

        # Check if the user has filled out everything necessary (just the necessary, there can be null values sometimes)
        if ($varCheck === true) {
            redirectToTicket();
        } else {
            # Now we create the Ticket with the parameters we just took from the user's form
            createTicketHelpSupport($conn, $subject, $fileAttachment, $description);
        }
        break;
        #endregion

        #region Bug Reporting
    case 'bugReport':
        $requestType = $_POST['requestTypeBugReportFields'] ?? '';
        $subject = $_POST['subjectBugReportFields'] ?? '';
        $bugDescription = $_POST['bugDescriptionBugReportFields'] ?? '';
        $stepsToReproduce = $_POST['stepsToReproduceBugReportFields'] ?? '';
        $expectedResult = $_POST['expectedResultBugReportFields'] ?? '';
        $receivedResult = $_POST['receivedResultBugReportFields'] ?? '';
        $discordClient = $_POST['discordClientBugReportFields'] ?? '';
        $bugImage = $_POST['bugImageBugReportFields'] ?? '';

        $inputs = array(
            $requestType,
            $subject,
            $bugDescription,
            $stepsToReproduce,
            $expectedResult,
            $receivedResult,
            $discordClient,
            $bugImage
        );

        # Check if the user has filled out everything necessary (just the necessary, there can be null values sometimes), and for the newer version, sanitize them aswell!
        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if ($varCheck === true) {
            redirectToTicket();
        } else {
            # Now we create the Ticket with the parameters we just took from the user's form
            createTicketBugReport($conn, $requestType, $subject, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage);
        }
        break;
        #endregion

        #region  Feature Request
    case 'featureRequest':
        $requestType = $_POST['requestTypeFeatureRequestFields'] ?? '';
        $subject = $_POST['subjectFeatureRequestFields'] ?? '';
        $description = $_POST['descriptionFeatureRequestFields'] ?? '';

        $inputs = array(
            $requestType,
            $subject,
            $description
        );

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if ($varCheck === true) {
            redirectToTicket();
        } else {
            # Now we create the Ticket with the parameters we just took from the user's form
            createTicketFeatureRequest($conn, $requestType, $subject, $description);
        }
        break;
        #endregion

        #region Grammar Issues
    case 'grammarIssues':
        $subject = $_POST['subjectGrammarIssuesFields'] ?? '';
        $description = $_POST['descriptionGrammarIssuesFields'] ?? '';
        $fileAttachment = $_POST['fileAttachmentGrammarIssuesFields'] ?? '';

        $inputs = array(
            $subject,
            $description
        );

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if ($varCheck === true) {
            redirectToTicket();
        } else {
            # Now we create the Ticket with the parameters we just took from the user's form
            createTicketGrammarIssues($conn, $subject, $description, $fileAttachment);
        }
        break;
        #endregion

        #region Information Update
    case 'informationUpdate':
        $subject = $_POST['subjectInformationUpdateFields'] ?? '';
        $updateInfo = $_POST['updateInfoInformationUpdateFields'] ?? '';

        $inputs = array(
            $subject,
            $updateInfo
        );

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if ($varCheck === true) {
            redirectToTicket();
        } else {
            # Now we create the Ticket with the parameters we just took from the user's form
            createTicketInformationUpdate($conn, $subject, $updateInfo);
        }
        break;
        #endregion

        #region Other Issues
    case 'other':
        $subject = $_POST['subjectOtherFields'] ?? '';
        $description = $_POST['descriptionOtherFields'] ?? '';
        $extraText = $_POST['extraTextOtherFields'] ?? '';

        $inputs = array(
            $subject,
            $description,
            $extraText
        );

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if ($varCheck === true) {
            redirectToTicket();
        } else {
            # Now we create the Ticket with the parameters we just took from the user's form
            createTicketOther($conn, $subject, $description, $extraText);
        }
        break;
        #endregion

        #region Default
    default:
        break;
        #endregion
}
redirectToViewTicket();

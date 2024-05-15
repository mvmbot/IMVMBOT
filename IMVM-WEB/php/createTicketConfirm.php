<?php
#region Required files
# Get the database stuff ready
require_once ('databaseFunctions.php');

# Grab some tools for our code
require_once ('redirectFunctions.php');
require_once ('dataValidationFunctions.php');
require_once ('errorAlerts.php');
#endregion

#region errors
# Turn on the error reporting to see any coding errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
#endregion

# Now, let's connect to our database
$conn = connectToDatabase();

# We declare the directory that we're using to store all the user data
$targetDirectory = '../userUploads/';

# We grab all the data from the form

# First of all, we get the type so we know what table to look in
$type = $_POST['type'] ?? '';

# This will hold an array with fields that need validation
$fieldsToCheck;

# Switch case to fill the values from every possible type
switch ($type) {

    #region Help & Support
    case 'helpSupport':

        # We get the form data aswell as we sanitize them directly. If the array got values inside, it will return the array sanitized, otherwise, it will return false
        $inputs = validateInputs([
            $subject = $_POST['subjectHelpSupportFields'] ?? '',
            $description = $_POST['descriptionHelpSupportFields'] ?? ''
            # If the array got empty values (false) it will redirect. Otherwise, it will continue
        ]) ?: redirectToTicket();

        # We get the file type, we'll need it later
        $type = "fileAttachmentHelpSupportFields";

        # Declare the file attachment path
        $fileAttachment = $targetDirectory . basename($_FILES["fileAttachmentHelpSupportFields"]["name"]);

        # We check if the file is valid, if it's cool, it will move the file to the target directory, otherwise, it'll return false and will redirect
        validateFile($fileAttachment, $type) ?: redirectToTicket();

        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketHelpSupport($conn, $inputs, $fileAttachment);
        break;
    #endregion

    #region Bug Reporting
    case 'bugReport':
        $inputs = validateInputs([
            $subject = $_POST['subjectBugReportFields'] ?? '',
            $requestType = $_POST['requestTypeBugReportFields'] ?? '',
            $bugDescription = $_POST['bugDescriptionBugReportFields'] ?? '',
            $stepsToReproduce = $_POST['stepsToReproduceBugReportFields'] ?? '',
            $expectedResult = $_POST['expectedResultBugReportFields'] ?? '',
            $receivedResult = $_POST['receivedResultBugReportFields'] ?? '',
            $discordClient = $_POST['discordClientBugReportFields'] ?? ''
        ]) ?: redirectToTicket();

        $type = 'bugImageBugReportFields';

        $fileAttachment = $targetDirectory . basename($_FILES["bugImageBugReportFields"]["name"]);

        $check = validateFile($fileAttachment, $type) ?: redirectToTicket();

        createTicketBugReport($conn, $inputs, $fileAttachment);

        break;
    #endregion

    #region  Feature Request
    case 'featureRequest':
        $inputs = validateInputs([
            $subject = $_POST['subjectFeatureRequestFields'] ?? '',
            $description = $_POST['descriptionFeatureRequestFields'] ?? '',
            $requestType = $_POST['requestTypeFeatureRequestFields'] ?? ''
        ]) ?: redirectToTicket();

        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketFeatureRequest($conn, $inputs);

        break;
    #endregion

    #region Grammar Issues
    case 'grammarIssues':
        $inputs = validateInputs([
            $subject = $_POST['subjectGrammarIssuesFields'] ?? '',
            $description = $_POST['descriptionGrammarIssuesFields'] ?? '',
        ]);

        $type = 'fileAttachmentGrammarIssuesFields';

        $fileAttachment = $targetDirectory . basename($_FILES["fileAttachmentGrammarIssuesFields"]["name"]);

        $check = validateFile($fileAttachment, $type);

        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketGrammarIssues($conn, $inputs, $fileAttachment);

        break;
    #endregion

    #region Information Update
    case 'informationUpdate':
        $inputs = validateInputs([
            $subject = $_POST['subjectInformationUpdateFields'] ?? '',
            $updateInfo = $_POST['updateInfoInformationUpdateFields'] ?? ''
        ]) ?: redirectToTicket();

        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketInformationUpdate($conn, $inputs);

        break;
    #endregion

    #region Other Issues
    case 'other':

        $inputs = validateInputs([
            $subject = $_POST['subjectOtherFields'] ?? '',
            $description = $_POST['descriptionOtherFields'] ?? '',
            $extraText = $_POST['extraTextOtherFields'] ?? '',
        ]) ?: redirectToTicket();

        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketOther($conn, $inputs);

        break;
    #endregion
    default:
        redirectToTicket();
        break;
}
redirectToViewTicket();

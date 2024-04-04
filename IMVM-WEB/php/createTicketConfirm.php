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

# We declare the directory that we're using to store all the user data
$targetDirectory =  './userUploads/';

# We grab all the data from the form

# First of all, we get the type so we know what table to look in
$type = $_POST['type'] ?? '';

# This will hold an array with fields that need validation
$fieldsToCheck;

# Switch case to fill the values from every possible type
switch ($type) {

    #region Help & Support
    case 'helpSupport':
        $subject = $_POST['subjectHelpSupportFields'] ?? '';
        $description = $_POST['descriptionHelpSupportFields'] ?? '';
        $file = pathinfo($_FILES['fileAttachmentHelpSupportFields']['name'], PATHINFO_FILENAME);
        $type = "fileAttachmentHelpSupportFields";

        $inputs = array(
            $subject,
            $description,
        );

        # Check if the user has filled out everything necessary (just the necessary, there can be null values sometimes), and for the newer version, sanitize them aswell!\
        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        # Check if the user has filled out everything necessary (just the necessary, there can be null values sometimes)
        if (!$varCheck) {
            #redirectToTicket();
        }

        # Declare the file attachment path
        $fileAttachment = $targetDirectory . basename($_FILES["fileAttachmentHelpSupportFields"]["name"]);

        echo validateFile($fileAttachment, $file, $type);
        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketHelpSupport($conn, $subject, $description, $fileAttachment);

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
        $file = $_POST['bugImageBugReportFields'] ?? '';

        $inputs = array(
            $requestType,
            $subject,
            $bugDescription,
            $stepsToReproduce,
            $expectedResult,
            $receivedResult,
            $discordClient,
            $file
        );

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if (!$varCheck) {
            redirectToTicket();
        }

        $fileAttachment = $targetDirectory . basename($_FILES["bugImageBugReportFields"]["name"]);

        echo validateFile($fileAttachment, $file, $type);
        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketBugReport($conn, $requestType, $subject, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $fileAttachment);

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

        if (!$varCheck) {
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
        $file = $_POST['fileAttachmentGrammarIssuesFields'] ?? '';

        $inputs = array(
            $subject,
            $description,
            $file
        );

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if (!$varCheck) {
            redirectToTicket();
        }

        $fileAttachment = $targetDirectory . basename($_FILES["fileAttachmentGrammarIssuesFields"]["name"]);

        echo validateFile($fileAttachment, $file, $type);

        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketGrammarIssues($conn, $subject, $description, $fileAttachment);

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

        if (!$varCheck) {
            redirectToTicket();
        }
        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketInformationUpdate($conn, $subject, $updateInfo);

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

        if (!$varCheck) {
            redirectToTicket();
        }
        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketOther($conn, $subject, $description, $extraText);

        break;
    #endregion

    #region Default
    default:
        break;
    #endregion
}
#redirectToViewTicket();

function validateFile($fileAttachment, $fileName, $type) {

    var_dump($fileName);

    var_dump($fileAttachment);

    # We check again if its empty in case somethings missing
    if (empty($fileAttachment)) {
        return "No file provided";
    }

    # We check if it already exists too
    if (file_exists($fileAttachment)) {
        return "File already exists";
    }

    # We get the extension of the file
    $imageFileType = strtolower(pathinfo($fileAttachment, PATHINFO_EXTENSION));

    # We store valid extensions on an array so it's easier to change them if we need to in the future
    $allowedExtensions = array("jpg", "jpeg", "png");

    # Then we check if the extension is inside the allowed extensions array
    if (!in_array($imageFileType, $allowedExtensions)) {
        return "Sorry, only JPG/JPEG and PNG files are allowed.";
    }

    # We vheck if it's a real image file
    $check = getimagesize($fileAttachment);
    
    if ($check !== false) {
        return 'File is not an image - ' . $check['mime'] . '.';
    }

    # We check if the file is too big
    if ($fileAttachment > 500000) {
        return "Sorry, your file is too large.";
    }

    # We try to move the file into the upload directory
    if (move_uploaded_file($_FILES[$type]["tmp_name"], $fileAttachment)) {
        return "The file " . htmlspecialchars($fileName) . " has been uploaded";
    } else {
        return "There was an error uploading your file";
    }
}

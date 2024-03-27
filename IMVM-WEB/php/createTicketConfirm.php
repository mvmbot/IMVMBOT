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

        $inputs = array(
            $subject,
            $description
        );

        # Check if the user has filled out everything necessary (just the necessary, there can be null values sometimes), and for the newer version, sanitize them aswell!\
        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        # Declare the file attachment path
        $fileAttachment = $targetDirectory . basename($_FILES["fileAttachmentHelpSupportFields"]["name"]);

        # We'll be using this var to check if the file uploadede correctly
        $uploadOk = 1;

        # Now we get the extension of the file (in lower case)
        $imageFileType = strtolower(pathinfo($fileAttachment, PATHINFO_EXTENSION));

        # Then, we gotta check if it's a real image
        if(isset($_POST["fileAttachmentHelpSupportFields"])) {
            $check = getimagesize($_FILES["fileAttachmentHelpSupportFields"]["tmpName"]);
            if(!$check) {
                echo 'file is an image - ' . $check['mime'] . '.';
                $uploadOk = 1;
            } else {
                echo "Sorry, only images are allowed.";
                $uploadOk = 0;
            }
        }

        # We also gotta check if the image already exists
        if (file_exists($fileAttachment)) {
            echo "Sorry, your file already exists.";
            $uploadOk = 0;
        }

        # Now we check the file size
        if ($_FILES["fileAttachmentHelpSupportFields"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        # Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
            echo "Sorry, only JPG/JPEG and PNG files are allowed.";
            $uploadOk = 0;
        }

        # If uploadOk = 0, there's an error
        if ($uploadOk == 0) {
            echo 'file not uploaded';
        } else {
            if (move_uploaded_file($_FILES["fileAttachmentHelpSupportFields"]["tmp_name"], $fileAttachment)) {
                echo "The file " . htmlspecialchars(basename ($_FILES["fileAttachmentHelpSupportFields"]["name"])) . "has been uploaded";
            } else {
                echo "There was an error uploading your file";
            }
        }

        # Check if the user has filled out everything necessary (just the necessary, there can be null values sometimes)
        if ($varCheck === true) {
            redirectToTicket();
        }
        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketHelpSupport($conn, $subject, $fileAttachment, $description);

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

        $varCheck = sanitizeInputsAndCheckEmpty($inputs);

        if ($varCheck === true) {
            redirectToTicket();
        }
        # Now we create the Ticket with the parameters we just took from the user's form
        createTicketBugReport($conn, $requestType, $subject, $bugDescription, $stepsToReproduce, $expectedResult, $receivedResult, $discordClient, $bugImage);

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
        }
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

        if ($varCheck === true) {
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

        if ($varCheck === true) {
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
redirectToViewTicket();

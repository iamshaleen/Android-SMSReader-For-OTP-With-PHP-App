<?php
// Function to sanitize user input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

// Function to check if a string is a valid sender
function isValidSender($sender) {
    return preg_match("/^[A-Za-z0-9_@+-]+$/", $sender);
}

// Function to load JSON data from a file
function loadJSONData($file_path) {
    if (file_exists($file_path)) {
        $json_data = file_get_contents($file_path);
        return json_decode($json_data, true);
    }
    return [];
}

// Function to save JSON data to a file
function saveJSONData($file_path, $json_data) {
    $json_content = json_encode($json_data, JSON_PRETTY_PRINT);
    file_put_contents($file_path, $json_content);
}

// Function to check if a SOW number already exists in the JSON data with same sender
function isSOWNumberExists($json_data, $sow_number, $selection, $sender) {
    foreach ($json_data as $entry) {
        if ($entry["sow_number"] === $sow_number){ 
            if($entry["sender"] === $sender){
                return true;    
            }   
        }
    }
    return false;
}

// Function to check if a sender already exists in the JSON data
function isSenderExists($json_data, $sender) {
    foreach ($json_data as $entry) {
        if ($entry["sender"] === $sender) {
            return true;
        }
    }
    return false;
}

// Function to get the JSON file path based on the dropdown selection
function getFilePath($selection) {
    if ($selection === "12345678") {
        return "data12345678.json";
    } elseif ($selection === "87654321") {
        return "data87654321.json";
    }
    return "";
}

$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if delete button is clicked
    if (isset($_POST["delete"]) && isset($_POST["selection"])) {
        // Get the index of the entry to be deleted
        $delete_index = $_POST["delete"];
        $selection = $_POST["selection"];

        // Load the JSON data based on the selection
        $file_path = getFilePath($selection);
        $json_data = loadJSONData($file_path);

        // Check if the delete index is valid
        if (isset($json_data[$delete_index])) {
            // Remove the entry from the JSON data
            unset($json_data[$delete_index]);

            // Reset the array keys
            $json_data = array_values($json_data);

            // Save the updated JSON data to the file
            saveJSONData($file_path, $json_data);
        }
    } else {
        // Get form data
        $sow_number = sanitizeInput($_POST["sow_number"]);
        $sender = sanitizeInput($_POST["sender"]);
        $message = sanitizeInput($_POST["message"]);
        $selection = sanitizeInput($_POST["selection"]);

        // Validate form data
        if (!ctype_digit($sow_number)) {
            $errors[] = "Invalid SOW Number";
        }

        if (!isValidSender($sender)) {
            $errors[] = "Invalid Sender";
        }

        // Load the JSON data based on the selection
        $file_path = getFilePath($selection);
        $json_data = loadJSONData($file_path);

        // Check if SOW number already exists with the same selection
        if (isSOWNumberExists($json_data, $sow_number, $selection, $sender)) {
            $errors[] = "SOW Number already exists with the same selection/sender";
        }

        // Check if sender already exists
        if (isSenderExists($json_data, $sender) && empty($message)) {
            $errors[] = "Message cannot be empty for an existing sender";
        }

        // If there are no errors, add the entry to the JSON data
        if (empty($errors)) {
            $entry = array(
                "sow_number" => $sow_number,
                "sender" => $sender,
                "message" => $message
                //"selection" => $selection
            );

            // Add the entry to the JSON data
            $json_data[] = $entry;

            // Save the updated JSON data to the file
            saveJSONData($file_path, $json_data);
        }
    }
}

// Load the JSON data for each selection
$json_data_12345678 = loadJSONData("data12345678.json");
$json_data_87654321 = loadJSONData("data87654321.json");
?>

<!DOCTYPE html>
<html>
<head>
    <title>JSON List</title>
    <style>
        .container {
            display: flex;
            height: calc(100vh - 50px);
        }

        .left {
            flex: 1;
            padding: 20px;
        }

        .right {
            flex: 1;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <h2>Add Entry</h2>
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <label for="sow_number">SOW Number:</label>
                <input type="text" name="sow_number" required><br><br>
                <label for="sender">Sender:</label>
                <input type="text" name="sender" required><br><br>
                <label for="message">Message:</label>
                <input type="text" name="message"><br><br>
                <label for="selection">Select Mobile Number:</label>
                <select name="selection" required>
                    <option value="12345678">12345678</option>
                    <option value="87654321">87654321</option>
                </select><br><br>
                <input type="submit" value="Add Entry">
            </form>
            <br>
            <?php if (!empty($errors)) : ?>
                <div style="color: red;">
                    <?php foreach ($errors as $error) : ?>
                        <?php echo $error; ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="right">
            <h2>List</h2>
            <?php if (!empty($json_data_12345678) || !empty($json_data_87654321)) : ?>
                <ul>
                    <?php foreach ($json_data_12345678 as $index => $entry) : ?>
                        <li>
                            <strong>SOW Number:</strong> <?php echo $entry["sow_number"]; ?><br>
                            <strong>Sender:</strong> <?php echo $entry["sender"]; ?><br>
                            <strong>Message:</strong> <?php echo $entry["message"]; ?><br>
                            <strong>Mobile Number:</strong> 12345678<br>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                <input type="hidden" name="delete" value="<?php echo $index; ?>">
                                <input type="hidden" name="selection" value="12345678">
                                <input type="submit" value="Delete">
                            </form>
                            <hr>
                        </li>
                    <?php endforeach; ?>
                    <?php foreach ($json_data_87654321 as $index => $entry) : ?>
                        <li>
                            <strong>SOW Number:</strong> <?php echo $entry["sow_number"]; ?><br>
                            <strong>Sender:</strong> <?php echo $entry["sender"]; ?><br>
                            <strong>Message:</strong> <?php echo $entry["message"]; ?><br>
                            <strong>Mobile Number:</strong> 87654321<br>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                <input type="hidden" name="delete" value="<?php echo $index; ?>">
                                <input type="hidden" name="selection" value="87654321">
                                <input type="submit" value="Delete">
                            </form>
                            <hr>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No entries found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

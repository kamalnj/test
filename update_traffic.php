<?php
session_start();
if (!in_array($_SESSION['role'], ['super_admin','filler_admin', 'order_admin', 'ftd_admin'])) {
    header("Location: dashboard.php");
    exit();
}

include('config.php');

// Fetch Traffic Details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_traffic']) && isset($_POST['traffic_id'])) {
    $traffic_id = $_POST['traffic_id'];
    $result = mysqli_query($conn, "SELECT * FROM traffic WHERE id='$traffic_id'");
    $traffic = mysqli_fetch_assoc($result);
}else{
    header('Location: manage_traffic.php');
    exit();
}

// Handle Update Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_traffic_submit'])) {
    $traffic_id = $_POST['traffic_id'];
    $updated_fields = array();
    if (isset($_POST['first_name'])) {
        $first_name = $_POST['first_name'];
        $updated_fields[] = "first_name='$first_name'";
    }

    if (isset($_POST['last_name'])) {
        $last_name = $_POST['last_name'];
        $updated_fields[] = "last_name='$last_name'";
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $updated_fields[] = "email='$email'";
    }

    if (isset($_POST['phone_number'])) {
        $phone_number = $_POST['phone_number'];
        $updated_fields[] = "phone_number='$phone_number'";
    }

    if (isset($_POST['country'])) {
        $country = $_POST['country'];
        $updated_fields[] = "country='$country'";
    }

    if (isset($_POST['date_created'])) {
        $date_created = $_POST['date_created'];
        $updated_fields[] = "date_created='$date_created'";
    }

    if (isset($_POST['our_network'])) {
        $our_network = $_POST['our_network'];
        $updated_fields[] = "our_network='$our_network'";
    }

    if (isset($_POST['client_network'])) {
        $client_network = $_POST['client_network'];
        $updated_fields[] = "client_network='$client_network'";
    }

    if (isset($_POST['broker'])) {
        $broker = $_POST['broker'];
        $updated_fields[] = "broker='$broker'";
    }

    // Construct the update query with the updated fields
    if (!empty($updated_fields)) {
        $update_query = "UPDATE traffic SET " . implode(', ', $updated_fields) . " WHERE id=$traffic_id";
        mysqli_query($conn, $update_query);
        // Redirect or handle success message
        header("Location: manage_traffic.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Traffic</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Update Traffic</h1>
        <form method="post" class="bg-white p-6 rounded-lg shadow-md">
            <input type="hidden" name="traffic_id" value="<?php echo $traffic['id']; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $traffic['first_name']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="last_name" class="block">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $traffic['last_name']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="email" class="block">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $traffic['email']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="phone_number" class="block">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo $traffic['phone_number']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="country" class="block">Country:</label>
                    <input type="text" id="country" name="country" value="<?php echo $traffic['country']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="date_created" class="block">Date Created:</label>
                    <input type="text" id="date_created" name="date_created" value="<?php echo $traffic['date_created']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="our_network" class="block">Our Network:</label>
                    <input type="text" id="our_network" name="our_network" value="<?php echo $traffic['our_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="client_network" class="block">Client Network:</label>
                    <input type="text" id="client_network" name="client_network" value="<?php echo $traffic['client_network']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
                <div>
                    <label for="broker" class="block">Broker:</label>
                    <input type="text" id="broker" name="broker" value="<?php echo $traffic['broker']; ?>" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
                </div>
            </div>
            <button type="submit" name="update_traffic_submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Update Traffic</button>
        </form>
        <a href="manage_traffic.php" class="block mt-4 text-blue-500">Cancel</a>
    </div>
</body>
</html>
<?php
 session_start(); 
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['alogin']) || (trim($_SESSION['alogin']) == '')) { ?>
<script>
window.location = "../index.php";
</script>
<?php
}
$session_id=$_SESSION['alogin'];
$session_role = $_SESSION['arole'];
$session_depart = $_SESSION['adepart'];
?>



<!-- Check Session Variables: 
The code checks whether the session variable $_SESSION['alogin'] is set and not empty. 
If it's not set or empty, it means the user is not logged in or the session is expired.
In such cases, it redirects the user to the login page (../index.php) using JavaScript.

Session Variables Retrieval: 
After ensuring that the user is authenticated (logged in), the script retrieves some session variables and assigns them to local variables for further use. These session variables might contain information about the user's ID, role, and department, which are essential for controlling access to different parts of the application.

Here:

$session_id: Contains the user's ID or some unique identifier.
$session_role: Contains the user's role or level of access (e.g., admin, manager, user).
$session_depart: Contains the user's department or some organizational unit. -->
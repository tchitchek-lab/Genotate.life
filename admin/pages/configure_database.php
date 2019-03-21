<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config_file.php");
?>

<script src='/admin/js/configure_database.js' xmlns:right></script>

<?php
$disabled_status = "";
if (USER_MODE == "restricted") {
    $disabled_status = "disabled";
}
?>

<?php
if (!empty ($_POST ['database']) && !empty ($_POST ['host']) && !empty ($_POST ['login']) && !empty ($_POST ['pass'])) {

    $host = $_POST ['host'];
    $login = $_POST ['login'];
    $pass = $_POST ['pass'];
    $database = $_POST ['database'];

    if (($database != "") && ($host != "") && ($login != "") && ($pass != "")) {
        $mysqli = new mysqli ($host, $login, $pass);
        if ($mysqli->connect_error) {
            die ("connection with new login failed: " . $connexion->connect_error);
        }
        $target_file = $_SERVER['DOCUMENT_ROOT'] . "../workspace/config/database.config";
        $text = "database:$database\nhost:$host\nuser:$login\npwd:$pass\n";
        file_put_contents($target_file, $text) or die ("$target_file not  writable");
        include($_SERVER['DOCUMENT_ROOT'] . "/admin/includes/manage_database.php");
        $request = "SHOW DATABASES LIKE '$database'";
        $results = mysqli_query($mysqli, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($mysqli));
        if (mysqli_num_rows($results) == 0) {
            $request = "CREATE DATABASE IF NOT EXISTS $database DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
            $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
            $mysqli->select_db($database);
            create_tables($mysqli);
            insert_algorithms($mysqli);
            header("Refresh:0");
        }
    }
}

$file_path = $_SERVER['DOCUMENT_ROOT'] . "../workspace/config/database.config";
$configfile = fopen($file_path, "r");
while (!feof($configfile)) {
    $line = fgets($configfile);
    $splitline = explode(':', $line);
    if (strcmp($splitline[0], "database") == 0) {
        $database = $splitline[1];
    } else if (strcmp($splitline[0], "user") == 0) {
        $user = $splitline[1];
    } else if (strcmp($splitline[0], "host") == 0) {
        $host = $splitline[1];
    } else if (strcmp($splitline[0], "pwd") == 0) {
        $pwd = $splitline[1];
    }
}

fclose($configfile);
$host = preg_replace("/\r|\n/", "", $host);
$user = preg_replace("/\r|\n/", "", $user);
$pwd = preg_replace("/\r|\n/", "", $pwd);
$database = preg_replace("/\r|\n/", "", $database);

?>
<script>
    function checkEntries() {
        let form_valid = true;
        if (document.getElementById("host").value === "") {
            form_valid = false;
        }
        if (document.getElementById("login").value === "") {
            form_valid = false;
        }
        if (document.getElementById("pass").value === "") {
            form_valid = false;
        }
        if (document.getElementById("database").value === "") {
            form_valid = false;
        }
        if (!form_valid) {
            alert("Please complete the inputs.\n");
        }
        return form_valid;
    }
</script>
<label type=title>Database configuration</label>
<p style='text-align: justify; text-justify: inter-word;'>This page allows to change the Genotate.life database login
    parameters or to reset it.</p>
<br>

<form action="" method='post' onsubmit='return checkEntries();'>
    <br>
    <div class="div-border-title">
        Database login<a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top"
                         href="../index.php" target="_blank"
                         title="<?php echo $tooltip_text['database_configuration']; ?>"> <img src="/img/tutorial.svg"
                                                                                              style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
    </div>
    <div class='div-border' style="width: 100%; padding: 5px;">
        <div style="width: 100%;">
            <label>host</label>
            <input type='text' id='host' name='host' title='host' style='width: 100%; height: 2em; float: right;'
                   value='<?php echo $host; ?>' <?php echo $disabled_status; ?> >
        </div>
        <div style="width: 100%;">
            <label>login</label>
            <input type='text' id='login' name='login' title='login' style='width: 100%; height: 2em; float: right;'
                   value='<?php echo $user; ?>' <?php echo $disabled_status; ?> >
        </div>
        <div style="width: 100%; margin-bottom: 5px;">
            <label>password</label>
            <input type='password' id='pass' name='pass' title='pass'
                   style='width: 100%; height: 2em; float: right;' <?php echo $disabled_status; ?> >
        </div>
        <div style="width: 100%; margin-bottom: 5px;">
            <label>database name</label>
            <input type='text' id='database' name='database' title='database'
                   style='width: 100%; height: 2em; float: right;'
                   value='<?php echo $database; ?>' <?php echo $disabled_status; ?> >
        </div>
    </div>
    <button type='submit' class='btn btn-secondary active'
            style='width: 100%; font-size: 1.3em; margin-top: 5px; margin-bottom: 5px;' <?php echo $disabled_status; ?> >
        update database information
    </button>
</form>
<button type='button' class='btn btn-danger' style='width: 100%; font-size: 1.3em;'
        onclick='database_reset();' <?php echo $disabled_status; ?> >reset the Genotate
    database
</button>

<script>
    document.title = "Genotate.life - Admin - Database configuration";
</script>

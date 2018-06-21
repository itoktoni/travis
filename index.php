<?php
$ftp_server = "ftp.ptibm.id";
$ftp_user_name = "itoktoni@ptibm.id";
$ftp_user_pass = "0215443294";
$remote_dir = "/apps/demo/travis";

// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

//default values
$file_url = "";

if($login_result) {
//set passive mode enabled
ftp_pasv($conn_id, true);

//check if directory exists and if not then create it
if(!@ftp_chdir($conn_id, $remote_dir)) {
//create diectory
ftp_mkdir($conn_id, $remote_dir);
//change directory
ftp_chdir($conn_id, $remote_dir);
}

$file = 'txt.txt';
$remote_file = 'txt.txt';

$ret = ftp_nb_put($conn_id, $remote_file, $file, FTP_BINARY, FTP_AUTORESUME);
while(FTP_MOREDATA == $ret) {
$ret = ftp_nb_continue($conn_id);
}

if($ret == FTP_FINISHED) {
echo "File '" . $remote_file . "' uploaded successfully.";
} else {
echo "Failed uploading file '" . $remote_file . "'.";
}
} else {
echo "Cannot connect to FTP server at " . $ftp_server;
}
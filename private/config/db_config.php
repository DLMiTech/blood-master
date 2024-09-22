<?php
/** database config **/
const DB_HOST = "localhost:3360";

if($_SERVER['SERVER_NAME'] == 'localhost')
{
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "blood_bank_db");
}else
{
    define("DB_USER", "userName");
    define("DB_PASS", "M1248@");
    define("DB_NAME", "name");
}


//frontend purpose data
const SITE_URL = 'http://127.0.0.1/works/passToSchool/';
const PROFILE_IMG_PATH = SITE_URL . 'FILES/profile_img/';


//backend upload process data
define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/works/passToSchool/FILES/');
//const UPLOAD_IMAGE_PATH = 'http://127.0.0.1/works/ssms.dlm/FILES/';
const PROFILE_FOLDER = 'profile_img/';
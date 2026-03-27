<?php

$messages['action-success-text'] = '';
$messages['action-error-text'] = '';
$messages['error_author_name'] = '';
$messages['error_message'] = '';
$messages['input_pre_author_name'] = '';
$messages['input_pre_message'] = '';

if(isset($_SESSION['input_pre_author_name'])){
    $messages['input_pre_author_name'] = $_SESSION['input_pre_author_name'];
    unset($_SESSION['input_pre_author_name']);
}

if(isset($_SESSION['input_pre_message'])){
    $messages['input_pre_message'] = $_SESSION['input_pre_message'];
    unset($_SESSION['input_pre_message']);
}

if(isset($_SESSION['error_author_name'])){
    $messages['error_author_name'] = $_SESSION['error_author_name'];
    unset($_SESSION['error_author_name']);
}

if(isset($_SESSION['error_message'])){
    $messages['error_message'] = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

if(isset($_SESSION['action-success-text'])){
    $messages['action-success-text'] = $_SESSION['action-success-text'];
    unset($_SESSION['action-success-text']);
}

if(isset($_SESSION['action-error-text'])){
    $messages['action-error-text'] = $_SESSION['action-error-text'];
    unset($_SESSION['action-error-text']);
}
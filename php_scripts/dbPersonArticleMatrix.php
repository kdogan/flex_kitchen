<?php
$person_id = $_GET["person_id"];
$isLastEntryRequested = $_GET["lastEntryRequested"];

if(!isset($isLastEntryRequested) || $isLastEntryRequested != 1){
    $entry = getLastPersonArticleMatrixEntryForUser($person_id);
    echo json_encode($entry);
}else {
    $response['name'] = getLastPurchasedArticleOfUser($person_id);
    json_encode($response);
}

function getLastPurchasedArticleName($person_id){
    require_once("../php_script.php");
    $functionScript = new FunctionScript();
    $purchasedArticle =  $functionScript->getLastPurchasedArticle($person_id);
    return $purchasedArticle["name"];
}

function getLastPersonArticleMatrixEntryForUser($person_id){
    require_once("../php_script.php");
    $functionScript = new FunctionScript();
    $purchasedArticle =  $functionScript->getLastPurchasedArticle($person_id);
    return $purchasedArticle;
}
?>

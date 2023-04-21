<?php
$fileName = $_GET['file'];
$directory = "../../storage/uploads/" . $fileName;

$zip = new ZipArchive();

if($zip->open($directory) === true){
    $content = $zip->getFromName('word/document.xml');

    $content = str_replace('</w:p>', '<br>', $content);
    $content = preg_replace('/<w:p [^>]+>/', '', $content);
    $content = str_replace('</w:t>', '', $content);
    $content = preg_replace('/<w:t [^>]+>/', '', $content);
    $content = str_replace('<w:r>', '', $content);
    $content = str_replace('</w:r>', '', $content);
    $content = str_replace('<w:pict>', '<img src="data:image/jpeg;base64,', $content);
    $content = str_replace('</w:pict>', '">', $content);
    $content = preg_replace('/<v:imagedata [^>]+>/', '', $content);
    $content = str_replace('</v:shape>', '', $content);

    $content = preg_replace_callback('/<w:pict[^>]*>.*?<v:shape.*?<v:imagedata.*?o;href="(.*?)".*?<\/v:shape>.*?<\/w:pict>/', function($match) use ($zip){
        $imagePath = 'word/' . $match[1];
        $imageData = base64_encode($zip->getFromName($imagePath));
        return '<img src="data:image/jpeg;base64,"' . $imageData . '">';
    }, $content);

    echo $content;

    $zip->close();
} else {
    echo 'failed to open document';
}

?>
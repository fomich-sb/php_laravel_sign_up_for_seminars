<div style=' <?=$project->certificate_orientation ? "width: 210mm; height: 297mm;" : "width: 297mm; height: 210mm;" ?> background-size:cover; background-position:center; background-repeat: no-repeat; background-image: url(<?=config('app.uploadImageFolder')?>/certificates/<?=$certificateBg?>); font-family: "Regular";'>
    <?=$certificateHtml?>
</div>


<style>
@page {
        margin: 0 !important;
        padding: 0 !important;
    }
@font-face {
        font-family: "Regular"; 
        src: url('/themes/default/Manrope-Regular.ttf');
    } 
</style>
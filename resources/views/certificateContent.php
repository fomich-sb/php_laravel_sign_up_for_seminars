<div style=' <?=$certificateOrientation ? "width: 210mm; height: 297mm;" : "width: 297mm; height: 210mm;" ?> background-size:cover; background-position:center; background-repeat: no-repeat; background-image: url(<?=config('app.uploadImageFolder')?>/certificates/<?=$certificateBg?>); font-family: "Regular";'>
    <?=$certificateHtml?>
    <?php if(isset($active) && $active==0): ?>
        <div style='position:absolute; left:0; top:0; width:100%; height:100%; background: #000B; color: #FFF;'>
            <div style='position:absolute; top:40%; width:100%;  font-size:4em; text-align:center;  font-family: "Bold";'>АННУЛИРОВАН</div>
        </div>
    <?php endif;?>
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
@font-face {
    font-family: "Bold"; 
    src: url('/themes/default/Manrope-Bold.ttf');
} 
</style>
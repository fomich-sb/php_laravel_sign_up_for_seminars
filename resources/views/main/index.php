
<div class="onepage-wrapper">
    <div class="mainOnePageSlider">
        <section class="mainPageIndex" id='mainPageIndex'>
            <div class="mainPageInner">
                <div class="mainPageSloganRoot">
                    <div class="mainPageSlogan">Психология как сказка</div>
                    <div class="mainPageSlogan2">Семинары по транзактному анализу</div>
                </div>
                <div class="mainPageProjectsListRoot">
                    <div class="mainButton mainPageProjectsListButton"  onclick='openSection("mainPageProjectsFuture")'>Предстоящие семинары</div>
                </div>
            </div>
        </section>
        <section class="mainPageProjectsFuture" id='mainPageProjectsFuture'>
            <div class="mainPageInner">
                <div class="mainPageSectionCaption">Предстоящие семинары</div>
                <div class='projectsMenuRoot'>
                    <?php foreach($projectItems as $project): ?>
                        <a href='/?id=<?= $project->id ?>' data-projectid='<?= $project->id ?>'>
                            <div class='projectsMenuItem projectsMenuItem<?= $project->id ?>'>
                                <div class='projectsMenuItemHeader'></div>
                                    <div class = 'projectsMenuItemDate'><?= $project->dates ?></div>
                                    <div class = 'projectsMenuItemCaption'><?= $project->caption ?></div>
                                <div class='projectsMenuItemFooter'></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="mainPageMyProjects" id='mainPageMyProjects'>
            <div class="mainPageInner">
                <div class="mainPageSectionCaption">Ваши семинары</div>
                
            </div>
        </section>
        <section class="mainPageAbout" id='mainPageAbout'>
            <div class="mainPageInner">
                <div class="mainPageSectionCaption">Обо мне</div>
            </div>
        </section>
    </div>
</div>

<script>
    
    $(".mainOnePageSlider").onepage_scroll();

</script>
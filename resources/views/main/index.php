
<section class="mainPageIndex" id='mainPageIndex'>
    <div class="mainPageInner">
        <div class="mainPageSloganRoot">
            <div class="mainPageSlogan">Психология как искусство</div>
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
        <div class="mainPageProjectsFutureContent">
            <?php if(count($projectItems)>0): ?>
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
            <?php else: ?>
                <div class='blockFlex1'></div>
                <div>Нет актуальных семинаров</div>
                <div class='blockFlex2'></div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="mainPageMyProjects" id='mainPageMyProjects'>
    <div class="mainPageInner">
        <div class="mainPageSectionCaption">Ваши семинары</div>
        <div class="mainPageMyProjectsContent">
            <?php if($user): ?>
                <?php if($myProjectItems && count($myProjectItems)>0): ?>
                    <div class='projectsMenuRoot'>
                        <?php foreach($myProjectItems as $project): ?>
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
                <?php else: ?>
                    <div class='blockFlex1'></div>
                    <div>Нет актуальных семинаров</div>
                    <div class='blockFlex2'></div>
                <?php endif; ?>
            <?php else: ?>
                <div class='mainPageMyProjectsNotAuth'>
                    <div class='blockFlex1'></div>
                    <div>
                        Для просмотра семинаров, в которых Вы участвовали, необходимо войти в учетную запись<br><br>
                        <div class='button' onclick='openLoginForm()'>Войти</div>
                    </div>
                    <div class='blockFlex2'></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="mainPageAbout" id='mainPageAbout'>
    <div class="mainPageInner">
        <div class="mainPageSectionCaption">Обо мне</div>
        <div class="mainPageAboutContent">
            <div class="mainPageAboutText">
                Сертифицированный транзактный аналитик<br>
                Психолог<br>
                Абдалова Феруза<br>
                Индивидуальная, семейная и групповая психотерапия.<br>
                Опыт работы — 17 лет<br>

                <a href='https://fira-psy.ru' target='_blank'><div class='mainButton'>Подробнее</div></a>
            </div>
            <div class="mainPageAboutPhoto"></div>
        </div>
    </div>
</section>
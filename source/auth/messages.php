<?php

use Work\plugin\lib\pQuery;

if (isset($_SESSION['id']) && isset($_SESSION['password'])) {

    if ($_SESSION['type'] == 'users') {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() <= 0) {
            $app->notFound();
        }
    
        $r = $stmt->fetch();
    } else if ($_SESSION['type'] == 'company') {
        $sql = "SELECT * FROM `company` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() <= 0) {
            $app->notFound();
        }
    
        $r = $stmt->fetch();
    } else {
        $app->notFound();
    }

    if (isset($_GET['id'])) {

        if (isset($_POST['clear'])) {
            $app->execute("DELETE FROM `msg` WHERE `chat_id` = :id", [':id' => intval($_GET['id'])]);
            header('location: /messages/?id='.$_GET['id']);
        }

        if ($_SESSION['type'] == 'users') {
            $sql = "SELECT * FROM `chat` WHERE `id` = :id AND `user_id` = :ui";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $stmt->bindParam(':ui', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $chat = $stmt->fetch();
            } else {
                $app->notFound();
            }
        }


        if ($_SESSION['type'] == 'company') {
            $sql2 = "SELECT * FROM `chat` WHERE `id` = :id AND `company_id` = :ui";
            $stmt = $PDO->prepare($sql2);
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $stmt->bindParam(':ui', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $chat = $stmt->fetch();
            } else {
                $app->notFound();
            }
        }

    }


    if (isset($_GET['id'])) {
        if ($_SESSION['type'] == 'users') {

            Head('Чат - ' . $chat['company']);

        }

        if ($_SESSION['type'] == 'company') {

            Head('Чат - ' . $chat['user']);

        }


    } else {

        Head('Чат');

    }

    Head('Чат');


?>
<body class="profile-body">



<main class="wrapper wrapper-profile" id="wrapper">

    <?php require('template/more/profileAside.php'); ?>

    

    <section class="profile-base">

        <?php require('template/more/profileHeader.php'); ?>
    

        <div class="profile-content">

            <div class="section-nav-profile">
                <span><a href="/profile">Профиль</a></span>
                <span><i class="fa-solid fa-chevron-right"></i></span>
                <span><a href="/messages">Чат</a></span>

    <?php if (isset($_GET['id'])) { ?>

        <?php if ($_SESSION['type'] == 'users') { ?>
            <span><i class="fa-solid fa-chevron-right"></i></span>
            <span><a href="/company/?id=<?php echo $chat['company_id'] ?>"><?php echo $chat['company'] ?></a></span>
        <?php   } ?>

        <?php if ($_SESSION['type'] == 'company') { ?>
            <span><i class="fa-solid fa-chevron-right"></i></span>
            <span><a href="/resume/?id=<?php echo $chat['user_id'] ?>"><?php echo $chat['user'] ?></a></span>
        <?php   } ?>

    <?php   } ?>
            </div>

            <?php
            if ($_SESSION['type'] == 'company') {

            ?>
            <div class="chat-data">
                <div class="chat-list">
                    <div class="search-box">
                        <form class="form-chat-list" role="form" method="GET">
                            <div class="chat-label">
                                <div class="chat-s-block">
                                    <input type="text" id="search" name="search" placeholder="Поиск...">
                                    <button type="button" class="search-chat"><i class="mdi mdi-magnify"></i></button>
                                </div>

                                <?php
                                if (isset($r['id'])) {
                                    ?>
                                    <input class="lock-ses" value="<?php echo $r['id'] ?>">
                                    <?php
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                    <div class="user-box">
                        <ul class="chat-list-box">
                            <div class="placeholder-main">

                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>
                                <div class="placeholder-chat">
                                    <div class="placeholder-item chat-img"></div>
                                    <div class="placeholder-block-chat">
                                        <div class="pc-flex">
                                            <div class="placeholder-item chat-title"></div>
                                            <div class="placeholder-item chat-litter-1"></div>
                                        </div>
                                        <div class="placeholder-item chat-little-2"></div>
                                    </div>
                                </div>

                            </div>
                        </ul>
                    </div>
                </div>
                <div class="chat-content">

                    <?php if (isset($_GET['id'])) { ?>

                        <div class="setting-box">
                            <div class="sb-img">
                                <span>
                                    <img src="/static/image/users/<?php echo $chat['img'] ?>" alt="">
                                </span>
                                <div>
                                    <a target="_blank" href="/resume/?id=<?php echo $chat['id'] ?>"><?php echo $chat['user'] ?></a>
                                    <p>Обновление...</p>
                                </div>
                            </div>
                            <div class="sb-icon">
                                <span class="sb-icon-bth">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </span>
                                <ul class="sb-icon-pop">
                                    <li onclick="window.location.href = '/resume/?id=<?php echo $chat['user_id'] ?>';" class=""><i class="mdi mdi-school-outline"></i> О студенте</li>

                                    <?php if ($chat['lock_company'] == 1) {?>
                                    <li class="unlock-chat-go"><i class="mdi mdi-check"></i> Разблокировать</li>
                                    <?php } else {?>
                                    <li class="lock-chat-go"><i class="mdi mdi-cancel"></i> Заблокировать</li>
                                    <?php } ?>
                                    <li class="" onclick="clearUrl()"><i class="mdi mdi-cached"></i> Очистить чат</li>
                                </ul>
                            </div>
                        </div>
                        <div class="chat-box">
                            <ul class="chat-ul">

                                <div class="loading-chat">
                                    <svg class="spinner" viewBox="0 0 50 50">
                                        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                                    </svg>
                                </div>

                            </ul>
                        </div>
                    <form method="POST" role="form" class="form-chat">
                        <?php if ($chat['lock_user'] == 0 && $chat['lock_company'] == 0) { ?>
                        <div class="field-box">

                            <div class="input-box">
                                <textarea class="input-msg type-<?php echo $_SESSION['type']; ?>" type="text" name="text" placeholder="Напишите сообщение..."></textarea>
                            </div>
                            <div class="send-box">
                                <div class="files-box">
                                  <!-- <label for="upload-chat-photo">
                                           <span>
                                               <i class="mdi mdi-link-variant"></i>
                                           </span>
                                       <input style="display: none" type="file" id="upload-chat-photo" name="file[]" multiple accept=".jpg,.jpeg,.png,.gif">
                                   </label>-->
                               </div>
                                <button class="send-chat-y" id="send-chat" name="send-msg" type="submit">
                                    Отправить
                                </button>
                            </div>
                        </div>
                        <?php } else if ($chat['lock_company'] == 1) {
                            ?>
                            <div class="unlock-box"><button type="button" class="unlock-chat-go">Разблокировать</button></div>
                            <?php
                        } else if ($chat['lock_user'] == 1) {
                            ?>
                            <div class="unlock-box"><span>Студент заблокировал Вас</span></div>
                            <?php
                        }?>
                    </form>

                    <?php } else {
                        echo '<span class="chat-non">Нажмите на чат</span>';
                    } ?>
                </div>
            </div>


                <?php
            } else if ($_SESSION['type'] = 'users') {
                ?>




                <div class="chat-data">
                    <div class="chat-list">
                        <div class="search-box">
                            <form class="form-chat-list" role="form" method="GET">
                                <div class="chat-label">
                                    <div class="chat-s-block">
                                        <input type="text" id="search" name="search" placeholder="Поиск...">
                                        <button type="button" class="search-chat"><i class="mdi mdi-magnify"></i></button>
                                    </div>


                                    <?php
                                    if (isset($_SESSION['id'])) {
                                        ?>
                                        <input class="lock-ses" value="<?php echo $_SESSION['id'] ?>">
                                        <?php
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>
                        <div class="user-box">
                            <ul class="chat-list-box">
                                <div class="placeholder-main">
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>
                                    <div class="placeholder-chat">
                                        <div class="placeholder-item chat-img"></div>
                                        <div class="placeholder-block-chat">
                                            <div class="pc-flex">
                                                <div class="placeholder-item chat-title"></div>
                                                <div class="placeholder-item chat-litter-1"></div>
                                            </div>
                                            <div class="placeholder-item chat-little-2"></div>
                                        </div>
                                    </div>

                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-content">

                        <?php if (isset($_GET['id'])) { ?>


                                <div class="setting-box">
                                    <div class="sb-img">
                                <span>
                                    <img src="/static/image/company/<?php echo $chat['com_img'] ?>" alt="">
                                </span>
                                        <div>
                                            <a href="/company/?id=<?php echo $chat['id'] ?>" target="_blank"><?php echo $chat['company'] ?></a>
                                            <p>Обновление...</p>
                                        </div>
                                    </div>
                                    <div class="sb-icon">
                                <span class="sb-icon-bth">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </span>
                                        <ul class="sb-icon-pop">
                                            <li onclick="window.location.href = '/company/?id=<?php echo $chat['company_id'] ?>';"><i class="mdi mdi-briefcase-outline"></i> О компании</li>

                                            <?php if ($chat['lock_user'] == 1) {
                                                ?>
                                                <li class="unlock-chat-go"><i class="mdi mdi-check"></i> Разблокировать</li>
                                                <?php
                                            } else {
                                            ?>
                                                <li class="lock-chat-go"><i class="mdi mdi-cancel"></i> Заблокировать</li>
                                            <?php
                                            } ?>
                                            <li class="" onclick="clearUrl()"><i class="mdi mdi-cached"></i> Очистить чат</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chat-box">
                                    <ul class="chat-ul">

                                        <div class="loading-chat">
                                            <svg class="spinner" viewBox="0 0 50 50">
                                                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                                            </svg>
                                        </div>



                                    </ul>
                                </div>
                            <form method="POST" role="form" class="form-chat">
                                <div class="image-box">

                                </div>
                                <?php if ($chat['lock_user'] == 0 && $chat['lock_company'] == 0) { ?>
                                <div class="field-box">


                                    <div class="input-box">
                                        <textarea class="input-msg type-<?php echo $_SESSION['type']; ?>" type="text" name="text" placeholder="Напишите сообщение..."></textarea>
                                    </div>
                                    <div class="send-box">
                                        <div class="files-box">
                                            <!-- <label for="upload-chat-photo">
                                                     <span>
                                                         <i class="mdi mdi-link-variant"></i>
                                                     </span>
                                                 <input style="display: none" type="file" id="upload-chat-photo" name="file[]" multiple accept=".jpg,.jpeg,.png,.gif">
                                             </label>-->
                                        </div>
                                        <button class="send-chat-y" id="send-chat" name="send-msg" type="submit">
                                            Отправить
                                        </button>
                                    </div>
                                </div>
                                <?php } else if ($chat['lock_user'] == 1) {
                                    ?>
                                    <div class="unlock-box"><button type="button" class="unlock-chat-go">Разблокировать</button></div>
                                    <?php
                                } else if ($chat['lock_company'] == 1) {
                                    ?>
                                    <div class="unlock-box"><span>Работодатель заблокировал Вас</span></div>
                                    <?php
                                }?>
                            </form>

                        <?php } else {
                            echo '<span class="chat-non">Нажмите на чат</span>';
                        } ?>
                    </div>
                </div>





                <?php
            }
            ?>
            
        </div>
    </section>

</main>


<?php require('template/more/profileFooter.php'); ?>

<script src="/static/scripts/chat.js?v=<?= date('YmdHis') ?>"></script>
<script>
    function deleteForm(){document.querySelector('#auth').remove()}
    function clearUrl(){document.querySelector('.profile-body').innerHTML+=`

                        <div id="auth" style="display:flex">
                    <div class="contact-wrapper" style="display:block">
                        <div class="auth-container auth-log" style="display:block">
                            <div class="auth-title">
                                Очистить чат
                                <i class="mdi mdi-close form-detete" onclick="deleteForm()"></i>
                            </div>
                            <div class="auth-form">
                                <span>Вы уверены, что вы хотите очисть чат для всех?</span>
                                <form method="post">
                                    <div class="pop-flex-bth">
                                        <button class="more-inf" type="button" onclick="deleteForm()">Нет</button>
                                        <button type="submit" class="lock-yes" name="clear">Уверен</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

           `}(function($){function remove_img(target){$(target).parent().remove()}})(jQuery)
</script>

</body>
</html>
<?php
} else {
    $app->notFound();
}
?>
<!DOCTYPE html>
<html lang="en">

<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<div class="navbar mycustomNav">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link" data-ignore-cache="true">
                <i class="ic_back_icon point-item"></i>
            </a>
        </div>
        <div class="center sliding">
            <!--My Events-->
            Request Song
        </div>
        <!--<div class="right">
            <?php
/*                if(isset($status) && $status === true)
                {
                    */?>
                    <a href="#" id="music-logout-btn">
                        <i class="ic_logout_icon point-item"></i>
                    </a>
                    <?php
/*                }
            */?>
        </div>-->
    </div>
</div>

<div class="pages">
    <div data-page="songlist" class="page tapSong-page">
        <?php
        if(isset($status) && $status === true)
        {
            ?>
            <!--<form class="searchbar searchbar-init" data-search-list=".list-block-search" data-search-in=".item-title,.item-subtitle" data-found=".searchbar-found" data-not-found=".searchbar-not-found">
                <div class="searchbar-input">
                    <input type="search" placeholder="Search Music">
                    <a href="#" class="searchbar-clear"></a>
                </div>
                <a href="#" class="searchbar-cancel">Cancel</a>
            </form>

            <div class="searchbar-overlay"></div>-->
            <?php
        }
        ?>

        <div class="page-content">
            <!--<div class="content-block searchbar-not-found">
                Nothing found
            </div>-->
            <?php
            if(isset($status) && $status === true)
            {
                if(isset($tapSongs) && myIsMultiArray($tapSongs))
                {
                    $songs = json_decode($tapSongs[0]['tapSongs'],true);
                    ?>
                    <input type="hidden" value="<?php echo $tapId;?>" id="taproomId"/>
                    <div class="list-block media-list list-block-search searchbar-found" id="song-list">
                        <div class="search-container">
                            <div>
                                <i class="fa fa-search"></i>
                                <div class="mdl-textfield mdl-js-textfield search-field">
                                    <input class="mdl-textfield__input search" type="text" id="sample1">
                                    <label class="mdl-textfield__label" for="sample1">Song Search</label>
                                </div>
                            </div>
                        </div>
                        <ul class="pagination list-of-song"></ul>
                        <ul class="list my-song-list">
                            <?php
                            foreach($songs[0] as $key => $row)
                            {

                                ?>
                                <li class="request_song_btn" data-songId="<?php echo $row['id'];?>"
                                    data-tapId="<?php echo $tapId;?>">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <?php
                                                if($row['albumartThumbnail'] == '')
                                                {
                                                    ?>
                                                    <i class="fa fa-music music-placeholder"></i>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <img class="queue-img-icon" src="<?php $url = preg_replace("/^http:/i", "https:", $row['albumartThumbnail']); echo $url;?>" width="44"/>

                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title-row">
                                                <div class="item-title"><?php echo $row['name'];?></div>
                                            </div>
                                            <div class="item-subtitle">
                                                <?php echo $row['artist'];?>
                                                <div class="plus-sign-btn">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
            }
            else
            {
                ?>
                <div class="page-content zeroTopPad" id="jukebx-form">
                    <div class="content-block">
                        <div class="list-block">
                            <ul>
                                <li class="item-content">
                                    <div class="item-inner">
                                        <div class="item-title label">Email</div>
                                        <div class="item-input">
                                            <input type="email" name="username" placeholder="Email">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <input onclick="jukeboxLoginFunc(this)" type="submit" class="button button-big button-fill" value="Request Song"/>
                        <div class="text-center content-block fa-15x">OR</div>
                        <div class="content-black text-center">
                            <div class="fb-login-button" data-max-rows="1" data-size="large" onlogin="checkLoginState();"
                                 data-show-faces="false" data-auto-logout-link="false" data-scope="email"></div>
                            <div id="my-signin2"></div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    if(isset($meta) && myIsArray($meta))
    {
        ?>
        <title><?php echo $meta['title'];?></title>
        <meta name="description" content="<?php echo $meta['description'];?>" />

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $meta['title'];?>">
        <meta itemprop="description" content="<?php echo $meta['description'];?>">
        <meta itemprop="image" content="<?php echo $meta['img'];?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@godoolally">
        <meta name="twitter:title" content="<?php echo $meta['title'];?>">
        <meta name="twitter:description" content="<?php echo $meta['description'];?>">
        <meta name="twitter:creator" content="@godoolally">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo $meta['img'];?>">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $meta['title'];?>" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo $meta['link'];?>" />
        <meta property="og:image" itemprop="image" content="<?php echo $meta['img'];?>" />
        <meta property="og:description" content="<?php echo $meta['description'];?>" />
        <?php
    }
    elseif(isset($meta1) && myIsArray($meta1))
    {
        ?>
        <title><?php echo $meta1['title'];?></title>
        <meta name="description" content="<?php echo $meta1['description'];?>" />
        <meta itemprop="name" content="<?php echo $meta1['title'];?>">
        <meta itemprop="description" content="<?php echo $meta1['description'];?>">
        <meta itemprop="image" content="<?php echo $meta1['img'];?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@godoolally">
        <meta name="twitter:title" content="<?php echo $meta1['title'];?>">
        <meta name="twitter:description" content="<?php echo $meta1['description'];?>">
        <meta name="twitter:creator" content="@godoolally">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo $meta1['img'];?>">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $meta1['title'];?>" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="<?php echo $meta1['img'];?>" />
        <meta property="og:description" content="<?php echo $meta1['description'];?>" />
        <?php
    }
    else
    {
        ?>
        <title>Doolally</title>
        <?php
    }
    ?>
    <?php echo $desktopStyle ;?>
</head>
<body>
<div class="tippy-overlay hide"></div>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <div id="custom-progressBar" class="mdl-progress mdl-js-progress mdl-progress__indeterminate hide"></div>
    <?php echo $deskHeader; ?>
    <main class="mdl-layout__content mainHome">
        <?php
        if(isset($currentUrl))
        {
            ?>
            <input type="hidden" value="<?php echo $currentUrl;?>" id="currentUrl"/>
            <?php
        }
        if(isset($fnbShareId))
        {
            ?>
            <input type="hidden" value="<?php echo $fnbShareId;?>" id="fnbShareId"/>
            <?php
        }
        if(isset($pageName) && isset($pageUrl))
        {
            ?>
            <input type="hidden" value="<?php echo $pageName;?>" id="pageName"/>
            <input type="hidden" value="<?php echo $pageUrl;?>" id="pageUrl"/>
            <?php
        }
        ?>
        <div class="mdl-grid page-content">
            <div class="mdl-cell mdl-cell--3-col">
                <?php echo $leftSideCal; ?>
            </div>
            <div class="mdl-cell mdl-cell--my-6-col my-vanish" id="mainContent-view">
                <section class="mdl-layout__tab-panel is-active" id="timelineTab">
                    <div class="page-content">
                        <div class="content-block custom-accordion">
                            <?php
                            if(isset($myFeeds) && myIsArray($myFeeds))
                            {
                                $postlimit = 0;
                                foreach($myFeeds as $key => $row)
                                {
                                    $row = json_decode($row['feedText'],true);
                                    if(isset($row['socialType']))
                                    {
                                        switch($row['socialType'])
                                        {
                                            case 't':
                                                $row['text'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['text']);
                                                $row['text'] = highlight('/#\w+/',$row['text']);
                                                $row['text'] = highlight('/@\w+/',$row['text']);
                                                //$truncated_RestaurantName = (strlen($row['text']) > 140) ? substr($row['text'], 0, 140) . '..' : $row['text'];
                                                ?>
                                                <!--twitter://status?status_id=756765768470130689-->
                                                <a href="https://twitter.com/<?php echo $row['user']['screen_name'];?>/status/<?php echo $row['id_str'];?>" target="_blank" class="twitter-wrapper">
                                                    <div class="my-card-items <?php if($postlimit >= 5){echo 'hide';} $postlimit++; ?>">
                                                        <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                                                            <div class="card-content">
                                                                <div class="card-content-inner">
                                                                    <ul class="mdl-list main-avatar-list">
                                                                        <li class="mdl-list__item mdl-list__item--two-line">
                                                                            <span class="mdl-list__item-primary-content">
                                                                                <?php
                                                                                if($postlimit > 5)
                                                                                {
                                                                                    ?>
                                                                                    <img class="myAvtar-list mdl-list__item-avatar lazy" data-src="<?php echo $row['user']['profile_image_url_https'];?>" width="44"/>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <img class="myAvtar-list mdl-list__item-avatar" src="<?php echo $row['user']['profile_image_url_https'];?>" width="44"/>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <span class="avatar-title"><?php echo ucfirst($row['user']['name']);?></span>
                                                                                <span class="mdl-list__item-sub-title">@<?php echo $row['user']['screen_name'];?></span>
                                                                            </span>
                                                                            <span class="mdl-list__item-secondary-content">
                                                                                <span class="mdl-list__item-secondary-info">
                                                                                    <i class="fa fa-twitter fa-15x social-icon-gap"></i>
                                                                                </span>
                                                                                <span class="mdl-list__item-secondary-action">
                                                                                    <time class="timeago time-stamp" datetime="<?php echo $row['created_at'];?>"></time>
                                                                                </span>
                                                                            </span>
                                                                            <!--<div class="item-inner">
                                                                                <div class="item-title-row">
                                                                                    <div class="item-title"><?php /*echo ucfirst($row['user']['name']);*/?></div>
                                                                                    <i class="fa fa-twitter social-icon-gap"></i>
                                                                                </div>
                                                                                <div class="item-subtitle">@<?php /*echo $row['user']['screen_name'];*/?>
                                                                                    <time class="timeago time-stamp" datetime="<?php /*echo $row['created_at'];*/?>"></time>
                                                                                </div>
                                                                            </div>-->
                                                                        </li>
                                                                    </ul>
                                                                    <?php
                                                                    if(isset($row['extended_entities']))
                                                                    {
                                                                        ?>
                                                                        <!--<div class="row no-gutter feed-image-container">-->
                                                                            <?php
                                                                            $imageLimit = 0;
                                                                            foreach($row['extended_entities']['media'] as $mediaKey => $mediaRow)
                                                                            {

                                                                                if($imageLimit >= 1)
                                                                                {
                                                                                    $isImageDone = true;
                                                                                    break;
                                                                                }
                                                                                $imageLimit++;
                                                                                if(isset($mediaRow['media_url_https']))
                                                                                {
                                                                                    if($postlimit > 5)
                                                                                    {
                                                                                        ?>
                                                                                        <img data-src="<?php echo $mediaRow['media_url_https'];?>" class="mainFeed-img lazy"/>
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <img src="<?php echo $mediaRow['media_url_https'];?>" class="mainFeed-img"/>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                elseif(isset($mediaRow['video_info']['variants']) && myIsArray($mediaRow['video_info']['variants']))
                                                                                {
                                                                                    $videoUrl= '';
                                                                                    $videoType = '';
                                                                                    foreach($mediaRow['video_info']['variants'] as $videoKey => $videoRow)
                                                                                    {
                                                                                        if(isset($videoRow['bitrate']))
                                                                                        {
                                                                                            $videoUrl = $videoRow['url'];
                                                                                            $videoType = $videoRow['content_type'];
                                                                                        }
                                                                                    }
                                                                                    if(strpos($videoUrl,"youtube") !== false || strpos($videoUrl,"youtu.be"))
                                                                                    {
                                                                                        ?>
                                                                                        <!--<div class="col-100">-->
                                                                                            <iframe width="100%" src="<?php echo $videoUrl;?>" frameborder="0" allowfullscreen>
                                                                                            </iframe>
                                                                                        <!--</div>-->
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <!--<div class="col-100">-->
                                                                                            <video width="100%" controls>
                                                                                                <source src="<?php echo $videoUrl;?>" type="<?php echo $videoType;?>">
                                                                                                No Video Found!
                                                                                            </video>
                                                                                        <!--</div>-->
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        <!--</div>-->
                                                                        <?php
                                                                    }
                                                                    elseif(isset($row['is_quote_status']) && $row['is_quote_status'] == true)
                                                                    {
                                                                        ?>
                                                                        <div class="mdl-card__supporting-text">
                                                                            <p class="final-card-text"><?php echo $row['text'];?></p>
                                                                        </div>
                                                                        <?php
                                                                        if(isset($row['quoted_status']) && myIsMultiArray($row['quoted_status']))
                                                                        {
                                                                            ?>
                                                                            <div class="content-block inset quoted-block">
                                                                                <div class="content-block-inner">
                                                                                    <ul class="mdl-list">
                                                                                        <li class="mdl-list__item mdl-list__item--two-line">
                                                                                            <span class="mdl-list__item-primary-content">
                                                                                              <span><?php echo $row['quoted_status']['user']['name'];?></span>
                                                                                              <span class="mdl-list__item-sub-title">@<?php echo $row['quoted_status']['user']['screen_name'];?></span>
                                                                                            </span>
                                                                                        </li>
                                                                                    </ul>
                                                                                    <?php
                                                                                    $row['quoted_status']['text'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['quoted_status']['text']);
                                                                                    $row['quoted_status']['text'] = highlight('/#\w+/',$row['quoted_status']['text']);
                                                                                    $row['quoted_status']['text'] = highlight('/@\w+/',$row['quoted_status']['text']);
                                                                                    ?>
                                                                                    <div class="mdl-card__supporting-text">
                                                                                        <p class="final-card-text"><?php echo $row['quoted_status']['text'];?></p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        elseif(isset($row['retweeted_status']) && myIsMultiArray($row['retweeted_status']))
                                                                        {
                                                                            ?>
                                                                            <div class="content-block inset quoted-block">
                                                                                <div class="content-block-inner">
                                                                                    <ul class="mdl-list">
                                                                                        <li class="mdl-list__item mdl-list__item--two-line">
                                                                                            <span class="mdl-list__item-primary-content">
                                                                                              <span><?php echo $row['retweeted_status']['quoted_status']['user']['name'];?></span>
                                                                                              <span class="mdl-list__item-sub-title">@<?php echo $row['retweeted_status']['quoted_status']['user']['screen_name'];?></span>
                                                                                            </span>
                                                                                        </li>
                                                                                    </ul>
                                                                                    <?php
                                                                                    $row['retweeted_status']['quoted_status']['text'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['retweeted_status']['quoted_status']['text']);
                                                                                    $row['retweeted_status']['quoted_status']['text'] = highlight('/#\w+/',$row['retweeted_status']['quoted_status']['text']);
                                                                                    $row['retweeted_status']['quoted_status']['text'] = highlight('/@\w+/',$row['retweeted_status']['quoted_status']['text']);
                                                                                    ?>
                                                                                    <div class="mdl-card__supporting-text">
                                                                                        <p class="final-card-text"><?php echo $row['retweeted_status']['quoted_status']['text'];?></p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    elseif(isset($row['entities']['urls']) && myIsMultiArray($row['entities']['urls']))
                                                                    {
                                                                        ?>
                                                                        <div class="link-card-wrapper">
                                                                            <input type="hidden" class="my-link-url" value="<?php echo $row['entities']['urls'][0]['expanded_url'];?>"/>
                                                                            <div class="liveurl feed-image-container hide">
                                                                                <img src="" class="link-image mainFeed-img" />
                                                                                <div class="details">
                                                                                    <div class="title"></div>
                                                                                    <div class="description"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if(isset($row['is_quote_status']) && $row['is_quote_status'] == false)
                                                                    {
                                                                        ?>
                                                                        <div class="mdl-card__supporting-text">
                                                                            <p class="final-card-text"><?php echo $row['text'];?></p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                                break;
                                            case 'f':
                                                preg_match_all('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $row['message'], $backupLink);
                                                $row['message'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['message']);
                                                $row['message'] = highlight('/#\w+/',$row['message']);
                                                $row['message'] = highlight('/@\w+/',$row['message']);
                                                $truncated_RestaurantName = (strlen($row['message']) > 140) ? substr($row['message'], 0, 140) . '..' : $row['message'];
                                                ?>
                                                <!--twitter://status?status_id=756765768470130689-->
                                                <a href="<?php echo $row['permalink_url'];?>" target="_blank" class="facebook-wrapper">
                                                    <div class="my-card-items <?php if($postlimit >= 5){echo 'hide';} $postlimit++; ?>">
                                                        <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                                                            <div class="card-content">
                                                                <div class="card-content-inner">
                                                                    <ul class="mdl-list main-avatar-list">
                                                                        <li class="mdl-list__item mdl-list__item--two-line">
                                                                            <span class="mdl-list__item-primary-content">
                                                                                <?php
                                                                                if($postlimit > 5)
                                                                                {
                                                                                    ?>
                                                                                    <img class="myAvtar-list mdl-list__item-avatar lazy" data-src="https://graph.facebook.com/v2.7/<?php echo $row['from']['id'];?>/picture" width="44"/>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <img class="myAvtar-list mdl-list__item-avatar" src="https://graph.facebook.com/v2.7/<?php echo $row['from']['id'];?>/picture" width="44"/>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <span class="avatar-title"><?php echo ucfirst($row['from']['name']);?></span>
                                                                            </span>
                                                                            <span class="mdl-list__item-secondary-content">
                                                                                <span class="mdl-list__item-secondary-info">
                                                                                    <i class="fa fa-facebook-official fa-15x social-icon-gap"></i>
                                                                                </span>
                                                                                <span class="mdl-list__item-secondary-action">
                                                                                    <time class="timeago time-stamp" datetime="<?php echo $row['created_at'];?>"></time>
                                                                                </span>
                                                                            </span>
                                                                        </li>
                                                                    </ul>
                                                                    <?php
                                                                    if(isset($row['source']))
                                                                    {
                                                                        if(strpos($row['source'],"youtube") !== false || strpos($row['source'],"youtu.be") !== false)
                                                                        {
                                                                            ?>
                                                                            <div onclick="preventAct(event)">
                                                                                <iframe width="100%" src="<?php echo $row['source'];?>" frameborder="0" allowfullscreen>
                                                                                </iframe>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <div onclick="preventAct(event)">
                                                                                <video width="100%" controls>
                                                                                    <source src="<?php echo $row['source'];?>" >
                                                                                    No Video Found!
                                                                                </video>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    elseif(isset($row['picture']))
                                                                    {
                                                                        if($postlimit > 5)
                                                                        {
                                                                            ?>
                                                                            <img data-src="<?php echo $row['picture'];?>" class="mainFeed-img lazy"/>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <img src="<?php echo $row['picture'];?>" class="mainFeed-img"/>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    elseif(isset($backupLink) && myIsMultiArray($backupLink))
                                                                    {
                                                                        ?>
                                                                        <div class="link-card-wrapper">
                                                                            <input type="hidden" class="my-link-url" value="<?php echo $backupLink[0][0];?>"/>
                                                                            <div class="liveurl feed-image-container hide">
                                                                                <img src="" class="link-image mainFeed-img" />
                                                                                <div class="details">
                                                                                    <div class="title"></div>
                                                                                    <div class="description"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div class="mdl-card__supporting-text">
                                                                        <p class="final-card-text"><?php echo $truncated_RestaurantName;?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                                break;
                                            case 'i':
                                                preg_match_all('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', $row['unformatted_message'], $backupLink);
                                                $row['unformatted_message'] = preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/]+!', "", $row['unformatted_message']);
                                                $row['unformatted_message'] = highlight('/#\w+/',$row['unformatted_message']);
                                                $row['unformatted_message'] = highlight('/@\w+/',$row['unformatted_message']);
                                                $truncated_RestaurantName = (strlen($row['unformatted_message']) > 140) ? substr($row['unformatted_message'], 0, 140) . '..' : $row['unformatted_message'];
                                                ?>
                                                <!--twitter://status?status_id=756765768470130689-->
                                                <a href="<?php echo $row['full_url'];?>" target="_blank" class="instagram-wrapper">
                                                    <div class="my-card-items <?php if($postlimit >= 5){echo 'hide';} $postlimit++; ?>">
                                                        <div class="mdl-card mdl-shadow--2dp demo-card-header-pic">
                                                            <div class="card-content">
                                                                <div class="card-content-inner">
                                                                    <ul class="mdl-list main-avatar-list">
                                                                        <li class="mdl-list__item mdl-list__item--two-line">
                                                                            <span class="mdl-list__item-primary-content">
                                                                                <?php
                                                                                if($postlimit > 5)
                                                                                {
                                                                                    ?>
                                                                                    <img class="myAvtar-list mdl-list__item-avatar lazy" data-src="<?php echo $row['poster_image'];?>" width="44"/>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <img class="myAvtar-list mdl-list__item-avatar" src="<?php echo $row['poster_image'];?>" width="44"/>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <span class="avatar-title"><?php echo ucfirst($row['poster_name']);?></span>
                                                                                <?php
                                                                                if(isset($row['source']))
                                                                                {
                                                                                    if($row['source']['term_type'] == 'hashtag')
                                                                                    {
                                                                                        ?>
                                                                                        <span class="mdl-list__item-sub-title">#<?php echo $row['source']['term'];?></span>
                                                                                        <?php
                                                                                    }
                                                                                    elseif($row['source']['term_type'] == 'location')
                                                                                    {
                                                                                        $locs = $this->config->item('insta_locationMap');
                                                                                        ?>
                                                                                        <span class="mdl-list__item-sub-title"><?php echo $locs[$row['source']['term']];?></span>
                                                                                        <?php
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        ?>
                                                                                        <span class="mdl-list__item-sub-title">@<?php echo $row['source']['term'];?></span>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                            <span class="mdl-list__item-secondary-content">
                                                                                <span class="mdl-list__item-secondary-info">
                                                                                    <i class="fa fa-instagram fa-15x social-icon-gap"></i>
                                                                                </span>
                                                                                <span class="mdl-list__item-secondary-action">
                                                                                    <time class="timeago time-stamp" datetime="<?php echo $row['created_at'];?>"></time>
                                                                                </span>
                                                                            </span>
                                                                        </li>
                                                                    </ul>
                                                                    <?php
                                                                    if(isset($row['image']))
                                                                    {
                                                                        if($postlimit > 5)
                                                                        {
                                                                            ?>
                                                                            <img data-src="<?php echo $row['image'];?>" class="mainFeed-img lazy"/>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <img src="<?php echo $row['image'];?>" class="mainFeed-img"/>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    elseif(isset($row['video']))
                                                                    {
                                                                        if(strpos($row['video'],"youtube") !== false || strpos($row['video'],"youtu.be") !== false)
                                                                        {
                                                                            ?>
                                                                            <iframe width="100%" src="<?php echo $row['video'];?>" frameborder="0" allowfullscreen>
                                                                            </iframe>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <video width="100%" controls>
                                                                                <source src="<?php echo $row['video'];?>" >
                                                                                No Video Found!
                                                                            </video>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    elseif(isset($backupLink) && myIsArray($backupLink))
                                                                    {
                                                                        ?>
                                                                        <div class="link-card-wrapper">
                                                                            <input type="hidden" class="my-link-url" value="<?php echo $backupLink[0][0];?>"/>
                                                                            <div class="liveurl feed-image-container hide">
                                                                                <img src="" class="link-image mainFeed-img" />
                                                                                <div class="details">
                                                                                    <div class="title"></div>
                                                                                    <div class="description"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div class="mdl-card__supporting-text">
                                                                        <p class="final-card-text"><?php echo $truncated_RestaurantName;?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                                break;
                                        }
                                    }
                                }
                            }
                            else
                            {
                                echo 'No Feeds Found!';
                            }
                            ?>
                        </div>
                        <?php
                        if(isset($myFeeds) && myIsArray($myFeeds))
                        {
                            ?>
                            <div class="text-center my-marginUp">
                                <div class="mdl-spinner mdl-js-spinner is-active" id="loading-icn"></div>
                                <span style="vertical-align: text-bottom;"> Loading....</span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </section>
                <section class="mdl-layout__tab-panel" id="eventsTab">
                    <div class="page-content">
                        <div class="mdl-shadow--2dp event-creator-box">
                            <div class="mdl-grid">
                                <div class="mdl-cell--8-col">
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="text" name="eventName" id="newEvent">
                                        <label class="mdl-textfield__label" for="newEvent">Create your event...</label>
                                    </div>
                                </div>
                                <div class="mdl-cell--4-col text-right">
                                    <a href="create_event" id="event-create-btn" data-title="Create Event" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect bookNow-event-btn my-AutoWidth dynamic">
                                        Continue
                                    </a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="MojoStatus" value="<?php echo $MojoStatus;?>"/>
                        <input type="hidden" id="eventsHigh" value="<?php echo $PaymentStatus;?>"/>
                        <div class="event-section">
                            <?php
                            if(isset($eventDetails) && myIsMultiArray($eventDetails))
                            {
                                $postImg = 0;
                                foreach($eventDetails as $key => $row)
                                {
                                    if(isEventFinished($row['eventDate'], $row['endTime']))
                                    {
                                        continue;
                                    }
                                    $img_collection = array();
                                    ?>
                                    <div itemscope itemtype="http://schema.org/Event" class="mdl-card mdl-shadow--2dp demo-card-header-pic <?php
                                    if(isset($row['eventPlace']))
                                    {
                                        if($row['isSpecialEvent'] == STATUS_YES)
                                        {
                                            echo 'eve-special';
                                        }
                                        elseif($row['isEventEverywhere'] == STATUS_YES)
                                        {
                                            echo 'eve-all';
                                        }
                                        else
                                        {
                                            echo 'eve-'.$row['eventPlace'];
                                        }
                                    }
                                    ?>" data-eveTitle="<?php echo $row['eventName'];?>">
                                        <?php
                                        if($postImg <=2)
                                        {
                                            ?>
                                            <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="dynamic">
                                                <img itemprop="image" src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img"/>
                                            </a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="dynamic">
                                                <img itemprop="image" data-src="<?php echo base_url().EVENT_PATH_THUMB.$row['filename'];?>" class="mainFeed-img lazy"/>
                                            </a>
                                            <?php
                                        }
                                        $postImg++;
                                        ?>
                                        <!--<div style="background-image:url()" valign="bottom" class="card-header color-white no-border">Journey To Mountains</div>-->
                                        <div class="card-content">
                                            <div class="card-content-inner">
                                                <ul class="mdl-list main-avatar-list">
                                                    <li class="mdl-list__item mdl-list__item--two-line">
                                                        <span class="mdl-list__item-primary-content">
                                                            <h1 class="hide" itemprop="name"> <?php echo $row['eventName'];?></h1>
                                                            <span class="avatar-title">
                                                                <?php
                                                                $eventName = (strlen($row['eventName']) > 45) ? substr($row['eventName'], 0, 45) . '..' : $row['eventName'];
                                                                echo $eventName;
                                                                ?>
                                                            </span>
                                                            <span class="mdl-list__item-sub-title">By <?php echo $row['creatorName'];?></span>
                                                        </span>
                                                        <span class="mdl-list__item-secondary-content">
                                                            <span class="mdl-list__item-secondary-info">
                                                                <input type="hidden" data-shareTxt="This looks pretty cool, shall we?" data-name="<?php echo $row['eventName'];?>" value="<?php if(isset($row['shortUrl'])){echo $row['shortUrl'];}else{echo $row['eventShareLink'];} ?>"/>
                                                                <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn event-card-share-btn"></i>
                                                            </span>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <meta class="hide" itemprop="startDate" content="<?php echo $row['eventDate'].'T'.$row['startTime'];?>" />
                                                <meta class="hide" itemprop="endDate" content="<?php echo $row['eventDate'].'T'.$row['endTime'];?>" />
                                                <div class="mdl-card__supporting-text">
                                                    <?php
                                                    $eventDescrip = (strlen($row['eventDescription']) > 100) ? substr($row['eventDescription'], 0, 100) . '..' : $row['eventDescription'];
                                                    ?>
                                                    <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="comment dynamic" itemprop="description">
                                                        <?php echo $eventDescrip;?>
                                                    </a>
                                                    <p>
                                                        <?php
                                                        if($row['isEventEverywhere'] == STATUS_NO)
                                                        {
                                                            $mapSplit = explode('/',$row['mapLink']);
                                                            $cords = explode(',',$mapSplit[count($mapSplit)-1]);
                                                            ?>
                                                            <div style="opacity:0;position:absolute;z-index:-1" itemprop="location" itemscope itemtype="http://schema.org/Place">
                                                                <span itemprop="name"><?php echo 'Doolally Taproom '.$row['locName'];?></span>
                                                                <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                                                                    <meta itemprop="latitude" content="<?php echo $cords[0];?>" />
                                                                    <meta itemprop="longitude" content="<?php echo $cords[1];?>" />
                                                                </div>
                                                                <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                                                                <span itemprop="streetAddress">
                                                                                    <?php echo $row['locAddress'];?>
                                                                                </span>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            if(isset($mainLocs) && myIsArray($mainLocs))
                                                            {
                                                                foreach($mainLocs as $locKey => $locRow)
                                                                {
                                                                    $mapSplit = explode('/',$locRow['mapLink']);
                                                                    $cords = explode(',',$mapSplit[count($mapSplit)-1]);
                                                                    ?>
                                                                    <div style="opacity:0;position:absolute;z-index:-1" itemprop="location" itemscope itemtype="http://schema.org/Place">
                                                                        <span itemprop="name"><?php echo 'Doolally Taproom '.$locRow['locName'];?></span>
                                                                        <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                                                                            <meta itemprop="latitude" content="<?php echo $cords[0];?>" />
                                                                            <meta itemprop="longitude" content="<?php echo $cords[1];?>" />
                                                                        </div>
                                                                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                                                                <span itemprop="streetAddress">
                                                                                    <?php echo $locRow['locAddress'];?>
                                                                                </span>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <i class="ic_me_location_icon main-loc-icon"></i>&nbsp;<?php if($row['isSpecialEvent'] == STATUS_YES){echo 'Pune';} elseif($row['isEventEverywhere'] == STATUS_YES){echo 'All Taprooms';}else{ echo $row['locName'];} ?>
                                                        <?php
                                                        if($row['showEventDate'] == STATUS_YES)
                                                        {
                                                            ?>
                                                            &nbsp;&nbsp;<span class="ic_events_icon event-date-main my-display-inline"></span>&nbsp;
                                                            <?php $d = date_create($row['eventDate']);
                                                            echo date_format($d,EVENT_DATE_FORMAT); ?>
                                                            <?php
                                                        }
                                                        if($row['showEventPrice'] == STATUS_YES)
                                                        {
                                                            ?>
                                                            &nbsp;&nbsp;<i class="ic_me_rupee_icon main-rupee-icon"></i>
                                                            <?php
                                                            switch($row['costType'])
                                                            {
                                                                case "1":
                                                                    echo "Free";
                                                                    break;
                                                                default :
                                                                    echo 'Rs '.$row['eventPrice'];
                                                            }
                                                        }
                                                        if($row['isEventEverywhere'] == STATUS_YES)
                                                        {
                                                            ?>
                                                            <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="event-bookNow dynamic">View Details</a>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <a href="<?php echo 'events/'.$row['eventSlug'];?>" class="event-bookNow dynamic">Book Event <i class="ic_back_icon my-display-inline"></i></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <a itemprop="url" href="<?php echo base_url().'?page/events/'.$row['eventSlug'];?>" class="color-black hide"><?php echo $row['eventName'];?></a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else
                            {
                                echo 'No Items Found!';
                            }
                            ?>
                        </div>
                    </div>
                </section>
                <section class="mdl-layout__tab-panel" id="fnbTab">
                    <!--<div class="page-content">
                        <?php
/*                        if(isset($fnbItems) && myIsMultiArray($fnbItems))
                        {
                            $postImg = 0;
                            $resetCard = 0;
                            $foodFlag = 0;
                            $beerCount = array_count_values(array_map(function($foo){return $foo['itemType'];}, $fnbItems));
                            foreach($fnbItems as $key => $row)
                            {
                                switch($row['itemType'])
                                {
                                    case ITEM_FOOD:
                                        */?>
                                        <?php
/*                                        if($foodFlag == 0)
                                        {
                                            $foodFlag = 1;
                                            */?>
                                            <div class="content-block-title food-title">Food</div>
                                            <?php
/*                                        }
                                        */?>
                                        <div class="mdl-card mdl-shadow--2dp demo-card-header-pic" data-fnbId = "<?php /*echo $row['fnbId']; */?>">
                                            <?php
/*                                            if($postImg <=2)
                                            {
                                                */?>
                                                <img src="<?php /*echo base_url().FOOD_PATH_THUMB.$row['filename'];*/?>" class="mainFeed-img"/>
                                                <?php
/*                                            }
                                            else
                                            {
                                                */?>
                                                <img data-src="<?php /*echo base_url().FOOD_PATH_THUMB.$row['filename'];*/?>" class="mainFeed-img lazy"/>
                                                <?php
/*                                            }
                                            $postImg++;

                                            */?>

                                            <ul class="mdl-list main-avatar-list">
                                                <li class="mdl-list__item mdl-list__item--two-line">
                                                    <span class="mdl-list__item-primary-content">
                                                        <span class="avatar-title"><?php /*echo $row['itemName'];*/?></span>
                                                    </span>
                                                    <span class="mdl-list__item-secondary-content">
                                                        <span class="mdl-list__item-secondary-info">
                                                            <input type="hidden" data-name="<?php /*echo $row['itemName'];*/?>" value="<?php /*if(isset($row['shortUrl'])){ echo $row['shortUrl'];}else{echo $row['fnbShareLink'];}*/?>"/>
                                                            <i class="my-pointer-item ic_me_share_icon pull-right event-share-icn fnb-card-share-btn"></i>
                                                        </span>
                                                    </span>
                                                </li>
                                            </ul>
                                            <div class="mdl-card__supporting-text">
                                                <?php /*echo strip_tags($row['itemDescription'],'<br>');*/?>
                                            </div>
                                        </div>
                                        <?php
/*                                        break;
                                }
                            }
                        }
                        else
                        {
                            echo 'No Items Found!';
                        }
                        */?>
                    </div>-->
                </section>
                <section class="mdl-layout__tab-panel" id="jukeboxTab"></section>
                <section class="mdl-layout__tab-panel" id="contactTab"></section>
            </div>
            <div class="mdl-cell mdl-cell--3-col">
                <?php echo $rightSideFnb; ?>
            </div>
        </div>
        <!-- Beer Dialog -->
        <!--<dialog class="mdl-dialog" id="beerDialog">
            <img src="" alt="beer" class="mainFeed-img"/>
            <div class="mdl-dialog__content">
                <p class="title-beer"></p>
                <input type="hidden" data-name="" value=""/>
                <i class="ic_me_share_icon pull-right event-share-icn fnb-card-share-btn"></i>
                <p class="description-beer"></p>
            </div>
            <div class="mdl-dialog__actions">
                <button type="button" class="mdl-button close">Close</button>
            </div>
        </dialog>-->
        <!-- Share Popup -->
        <dialog class="mdl-dialog hide" id="shareDialog">
            <div class="mdl-card demo-card-header-pic">
                <p class="title-share"></p>
                <div id="main-share">
                </div>
            </div>
            <!--<div class="mdl-dialog__actions">
                <button type="button" class="mdl-button close">Close</button>
            </div>-->
        </dialog>

        <!-- Timeline Filer dialog -->
        <dialog class="mdl-dialog hide" id="timeLineDialog">
            <div class="mdl-dialog__content">
                <p class="title">Filter Posts</p>
                <ul class="demo-list-control mdl-list">
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                          Facebook
                        </span>
                        <span class="mdl-list__item-secondary-action">
                          <label class="mdl-checkbox mdl-js-checkbox my-fb-label" for="fb-checked">
                                <input type="checkbox" name="social-filter" value="1" id="fb-checked" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label"></span>
                          </label>
                        </span>
                    </li>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                          Twitter
                        </span>
                        <span class="mdl-list__item-secondary-action">
                            <label class="mdl-checkbox mdl-js-checkbox my-tw-label" for="tw-checked">
                                <input type="checkbox" name="social-filter" value="2" id="tw-checked" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label"></span>
                            </label>
                        </span>
                    </li>
                    <li class="mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                          Instagram
                        </span>
                        <span class="mdl-list__item-secondary-action">
                            <label class="mdl-checkbox mdl-js-checkbox my-insta-label" for="insta-checked">
                                <input type="checkbox" name="social-filter" value="3" id="insta-checked" class="mdl-checkbox__input">
                                <span class="mdl-checkbox__label"></span>
                            </label>
                        </span>
                    </li>
                </ul>

            </div>
            <div class="mdl-dialog__actions">
                <button type="button" class="mdl-button close">Close</button>
            </div>
        </dialog>

        <!-- alert dialog -->
        <!--<dialog class="mdl-dialog" id="alertDialog">
            <div class="mdl-dialog__content">
                <p class="title-alert"></p>
            </div>
            <div class="mdl-dialog__actions">
                <button type="button" class="mdl-button close">Close</button>
            </div>
        </dialog>-->
        <div id="demo-toast" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>

        <div class="scrollUp" style="display:none">
            <i class="fa fa-caret-up fa-2x"></i>
        </div>
    </main>
</div>
<section id="doolally-age-gate" class="hide">
    <div class="demo-card-wide mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand">
            <div class="mdl-grid">
                <div class="">
                    <div class="tutorialicon">
                        <img src="<?php echo base_url();?>asset/images/splashLogo.png" class="mainFeed-img"/>
                    </div>
                    <br>
                    <span class="load-txt">Welcome To Doolally!</span>
                    <br>
                    <p class="sub-age-txt">Are you of legal drinking age?</p>
                </div>
            </div>
        </div>
        <div class="mdl-card__actions">
            <i class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn age-gate-yes">Yes</i>
            <a href="http://www.amuldairy.com" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored bookNow-event-btn external">No</a>
        </div>
    </div>
</section>
</body>
<?php echo $desktopJs ;?>

<script>
    //previous data
    <?php
    if(isset($myFeeds) && myIsArray($myFeeds))
    {
        $row = json_decode($myFeeds[0]['feedText'], true);
        switch($row['socialType'])
        {
            case 'i':
                ?>
                    mainFeeds = '<?php echo $row['id'];?>';
                <?php
                break;
            case 'f':
                ?>
                    mainFeeds = '<?php echo $row['id'];?>';
                <?php
                break;
            case 't':
                ?>
                    mainFeeds = '<?php echo $row['id_str'];?>';
                <?php
                break;
        }
    }
    ?>

</script>
</html>
<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

require '../common/check_loged_in.php'; ?>
<?php
//TODO:spot light by ranking
//fixme: at the actual spot light, that is delivered by site later
$conn = new mysqli('localhost', 'root', 'root', 'pilipili');
$conn->set_charset('utf8');

# fetch user from session
$current_user = $_SESSION['current_user'];

# fetch followings from db
$followings = $conn->query("SELECT user.id,pilipili_id,avatar_filepath FROM follow,user WHERE followee_id=user.id AND follower_id=" . $current_user['id'])->fetch_all(MYSQLI_ASSOC);

# fetch suggested user
# fixme : do it with by tags or some algo to find out the similiar user or users that cu may fond of
$suggested_users = $conn->query("SELECT * FROM user WHERE id!=" . $current_user['id'] . " AND id NOT IN (SELECT user.id FROM user,follow WHERE followee_id=user.id AND follower_id=" . $current_user['id'] . ")  ORDER BY rand() LIMIT 10")->fetch_all(MYSQLI_ASSOC);

# fetch banner
$banner = $conn->query("SELECT * FROM banner ORDER BY id DESC LIMIT 1")->fetch_assoc();

# fetch spot light
$spot_lights = $conn->query("SELECT * FROM image ORDER BY views DESC LIMIT 4")->fetch_all(MYSQLI_ASSOC);

#fetch new work from any body
$new_work_everyone = $conn->query("SELECT * FROM image ORDER BY id DESC LIMIT 6")->fetch_all(MYSQLI_ASSOC);

# fetch favorites tags
$favorites_tags = $conn->query("SELECT * FROM user_tag,tag_category WHERE tag_id=id AND user_id=" . $current_user['id'])->fetch_all(MYSQLI_ASSOC);

# fetch frequent tags
$frequent_tags = $conn->query("SELECT name,id FROM tag_category,image_tag WHERE id=tag_id GROUP BY id ORDER BY count(*) DESC LIMIT 8 ")->fetch_all(MYSQLI_ASSOC);

# fetch new work from users followed by cu
$new_work_following = $conn->query("SELECT * FROM image WHERE author_id IN(SELECT followee_id FROM follow WHERE follower_id=" . $current_user['id'] . " ) ORDER BY id DESC LIMIT 6")->fetch_all(MYSQLI_ASSOC);

# fetch ad
$ad = $conn->query("SELECT * FROM ad ORDER BY id DESC LIMIT 1")->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
    <title>pilipili - powered by 风之凌殇</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <?php require '../common/head.php' ?>
    <style>
        body {
            background-color: #e4e7ee;
            background: url("../tmp_upload/bg.jpg") repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
<!-- navigation -->
<?php require '../common/navbar.php' ?>
<div class="container">
    <!--body-->
    <!--    <div>-->
    <!--        <h1>--><?php //if (isset($_SESSION['current_user'])) echo 'Hi ' . $_SESSION['current_user']['pilipili_id'] . ' ,'; ?>
    <!--            welcome to-->
    <!--            pilipili, and the homepage is still being implemented, please wait :)</h1>-->
    <!--    </div>-->
    <!--    <!--    TODO: implement homepage-->-->
    <!--    <div>-->
    <!--        <a href="../image/detail.php">Debug detail page :) delete it after implemented</a>-->
    <!--    </div>-->
    <!--    <!--    fixme-->-->
    <!--    <hr>-->
    <div class="wrap">
        <div class="col-md-3" id="left-side">
            <section class="content container-fluid" id="current-user">
                <a href="../user/member.php?id=<?php echo $current_user['id']; ?>">
                    <div class="col-md-5">
                        <img class="img-user" src="<?php echo $current_user['avatar_filepath']; ?>" alt="">
                    </div>
                    <div class="col-md-7" style="top: 10px;">
                        <div class="link-black-bold"><?php echo $current_user['pilipili_id']; ?></div>
                        <div>View Profile</div>
                    </div>
                </a>
            </section>
            <div class="content container-fluid text-center">
                <!--                other user's comments for this users' work -->
                <a href="../comment/comment_all.php">Comments</a>
            </div>
            <div class="content">
                <div class="sec"><a class="link-black" href="../user/bookmark.php?type=following">Following</a><span
                        class="pull-right"><?php echo count($followings); ?></span></div>
                <div>
                    <div class="content">
                        <?php
                        $following_cnt = 0;
                        foreach ($followings as $user) {
                            echo '
                        <a href="../user/member.php?id=' . $user['id'] . '" data-toggle="tooltip" data-placement="top" title="' . $user['pilipili_id'] . '"><img
                                class="img-following" src="' . $user['avatar_filepath'] . '" alt=""></a>
                        ';
                            if (++$following_cnt == 10) break;
                        }; ?>
                    </div>
                </div>
                <div class="text-right"><a href="../user/bookmark.php?type=following">View list</a></div>
                <hr>
                <div class="text-right"><a href="../user/bookmark.php?type=followed_by">Followers</a></div>
            </div>
            <div class="content">
                <div class="sec"><a class="link-black" href="../search/search_user.php">Suggested Users</a></div>
                <div>
                    <div class="content">
                        <?php
                        $suggested_cnt = 0;
                        foreach ($suggested_users as $user) {
                            echo '
                        <a href="../user/member.php?id=' . $user['id'] . '" data-toggle="tooltip" data-placement="top" title="' . $user['pilipili_id'] . '"><img
                                class="img-following" src="' . $user['avatar_filepath'] . '" alt=""></a>
                        ';
                            if (++$suggested_cnt == 10) break;
                        }; ?>
                    </div>
                </div>
                <div class="text-right"><a href="../search/search_user.php">View list</a></div>
            </div>
            <div class="content">
                <div class="sec link-black">Groups</div>
                <div class="text-right"><a href="../group/">See recently created groups</a></div>
                <hr>
                <div class="text-right"><a href="#">Create Group</a></div>
                <!--                fixme : implement it with js-->
            </div>
        </div>


        <!--        TODO: start from here implemet mid and right-->
        <div class="container-fluid col-md-6" id="mid-side">
            <div class="content">
                <?php
                echo '
                <a href="' . $banner['link'] . '"><img src="' . $banner['post_path'] . '" alt="" class="img-full-width"></a>
                ';; ?>
            </div>
            <div class="content">
                <div class="title"><a class="link-black" href="#">Info</a></div>
                <div>
                    <div class="container-fluid">
                        <div class="info-item sec col-xs-3">Announcements</div>
                        <div class="col-xs-9"><a href="#">A false announcement link</a></div>
                    </div>
                    <div class="container-fluid">
                        <div class="info-item sec col-xs-3">Events / Contests</div>
                        <div class="col-xs-9"><a href="#">A false Events link</a></div>
                    </div>
                    <div class="container-fluid">
                        <div class="info-item sec col-xs-3">Gallery</div>
                        <div class="col-xs-9"><a href="#">A false gallery link</a></div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="title"><a class="link-black" href="#">pilipili spot light</a></div>
                <div class="wrap container-fluid">
                    <?php
                    foreach ($spot_lights as $spot_light) {
                        echo '
                    <a href="../image/detail.php?image_id=' . $spot_light['id'] . '">
                        <img class="img-spot" src="' . $spot_light['filepath'] . '" alt="">
                    </a>
                        ';
                    }; ?>
                </div>
                <div class="container-fluid">
                    <a href="#" class="pull-right">»View more</a>
                </div>
            </div>
            <div class="content">
                <div class="title"><a class="link-black" href="#">New work: Everyone</a></div>
                <div class="text-center">
                    <div class="container-fluid">
                        <?php
                        foreach ($new_work_everyone as $work) {
                            $work_author_pilipili_id = $conn->query("SELECT pilipili_id FROM user WHERE id = " . $work['author_id'])->fetch_assoc()['pilipili_id'];
                            echo '
                        <div class="col-md-4">
                            <div><a href="../image/detail.php?image_id=' . $work['id'] . '"><img src="' . $work['filepath'] . '" alt=""
                                                  class="img-full-width"></a></div>
                            <div><a href="../image/detail.php?image_id=' . $work['id'] . '">' . $work['name'] . '</a></div>
                            <div><a href="../user/member_illust.php?id=' . $work['author_id'] . '">' . $work_author_pilipili_id . '</a></div>
                        </div>
                            ';
                        };
                        ?>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="title"><a class="link-black" href="#">Your favorite tags</a></div>
                <div class="container-fluid">
                    <?php
                    $cols = array('', '', '');
                    foreach ($favorites_tags as $index => $tag) {
                        $cols[$index % 3] .= '
                        <div><a href="../search/search.php?mode=tag_full&word=' . $tag['name'] . '"><span class="glyphicon glyphicon-tag tag" aria-hidden="true"></span> ' . $tag['name'] . '</a></div>
                        ';
                    }
                    foreach ($cols as $col) {
                        echo '
                        <div class="col-md-4">
                            ' . $col . '
                        </div>
                        ';
                    }; ?>
                </div>
            </div>

            <div class="content">
                <div class="title"><a class="link-black" href="#">Frequently checked tags</a></div>
                <?php
                $frequent_tags_cnt = count($frequent_tags);
                for ($i = 0; $i < 2; ++$i) {
                    echo '<div class="container-fluid">';
                    for ($j = 0; $j < 4; ++$j) {
                        $tag = $frequent_tags[4 * $i + $j];
                        $tag_most_viewd_image = $conn->query("SELECT * FROM image_tag,image WHERE id=image_id AND tag_id=" . $tag['id'] . " ORDER BY views DESC LIMIT 1")->fetch_assoc();
                        echo '
                        <div class="col-md-3 tag-list">
                            <div><a href="../image/detail.php?image_id=' . $tag_most_viewd_image['id'] . '"><img src="' . $tag_most_viewd_image['filepath'] . '" alt=""
                                                  class="img-full-width img-radius"></a>
                            </div>
                            <div><a href="../search/search.php?mode=tag_full&word=' . $tag['name'] . '"><span
                                        class="glyphicon glyphicon-tag tag" aria-hidden="true"></span> ' . $tag['name'] . '</a>
                            </div>
                        </div>
                            ';
                        if (4 * $i + $j == $frequent_tags_cnt - 1)
                            break;
                    }
                    echo '</div>';
                    if (4 * $i + $j == $frequent_tags_cnt - 1)
                        break;
                }; ?>
            </div>

            <div class="content">
                <div class="title"><a class="link-black" href="#">new work : Following</a></div>
                <div class="text-center">
                    <div class="container-fluid">
                        <?php
                        foreach ($new_work_following as $work) {
                            $work_author_pilipili_id = $conn->query("SELECT pilipili_id FROM user WHERE id = " . $work['author_id'])->fetch_assoc()['pilipili_id'];
                            echo '
                        <div class="col-md-4">
                            <div><a href="../image/detail.php?image_id=' . $work['id'] . '"><img src="' . $work['filepath'] . '" alt=""
                                                  class="img-full-width"></a></div>
                            <div><a href="../image/detail.php?image_id=' . $work['id'] . '">' . $work['name'] . '</a></div>
                            <div><a href="../user/member_illust.php?id=' . $work['author_id'] . '">' . $work_author_pilipili_id . '</a></div>
                        </div>
                            ';
                        };
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-md-3" id="right-side">
            <div class="content">
                <div>
                    <a href="<?php echo $ad['link']; ?>"><img src="<?php echo $ad['post_path']; ?>" alt="AD"
                                                              class="img-full-width"></a>
                </div>
            </div>

            <!--            TODO: make all these ranking into one template(with some params)-->
            <div class="content">
                <div class="sec"><a class="link-black" href="#">Global Rankings</a></div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">1</div>
                    </div>
                </div>
                <div class="ranking container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_2.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">2</div>
                    </div>
                </div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">3</div>
                    </div>
                </div>
                <div class="text-right"><a href="#">View more</a></div>
            </div>

            <div class="content">
                <div class="sec"><a class="link-black" href="#">Daily Rankings</a></div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">1</div>
                    </div>
                </div>
                <div class="ranking container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_2.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">2</div>
                    </div>
                </div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">3</div>
                    </div>
                </div>
                <div class="text-right"><a href="#">View more</a></div>
            </div>

            <div class="content">
                <div class="sec"><a class="link-black" href="#">Popularity Rankings</a></div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">1</div>
                    </div>
                </div>
                <div class="ranking container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_2.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">2</div>
                    </div>
                </div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">3</div>
                    </div>
                </div>
                <div class="text-right"><a href="#">View more</a></div>
            </div>


            <div class="content">
                <div class="sec"><a class="link-black" href="#">Original Rankings</a></div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">1</div>
                    </div>
                </div>
                <div class="ranking container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_2.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">2</div>
                    </div>
                </div>
                <div class="ranking ranking-odd container-fluid pad-zero">
                    <div class="col-md-6 pad-five">
                        <img src="../uploaded_img/other_work_1.jpg" alt="work-name-here:TODO"
                             class="img-full-width">
                    </div>
                    <div class="col-md-6" style="vertical-align: top;">
                        <div><a href="#">Title</a></div>
                        <div>By <a href="#">Author</a></div>
                        <div class="ranking-num">3</div>
                    </div>
                </div>
                <div class="text-right"><a href="#">View more</a></div>
            </div>

        </div>
    </div>

</div>
<!--footer-->
<?php require '../common/footer.php' ?>
<?php $conn->close(); ?>
</body>
</html>

<?php
/**
 * Copyright (c) 2016. 
 * Contact me at fzls.zju@gmail.com [ Chen Ji ]
 */

require '../common/check_loged_in.php'; ?>
<?php
// input: $img_id  the id of the image to display
$display_desc = true;
$click_by_user = true;
if (isset($_GET['image_id']) and null !== filter_input(INPUT_GET, 'image_id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE))
    $image_id = $_GET['image_id'];
if (!isset($image_id)) {
    $image_id = 1;
    $click_by_user = false;
}//TODO: for test only
// for simplicity of codes, now not use prepared procedure
$conn = new mysqli('localhost', 'root', 'root', 'pilipili');
$conn->set_charset('utf8');

//fetch current user
$current_user = $_SESSION['current_user'];

// record click event and increment the image's views by one
// fixme: for test, now do not filter the occasion when the same user click this link multiple times
if ($click_by_user) {
    $conn->query("INSERT INTO click_image_event(user_id,image_id) VALUES (" . $current_user['id'] . "," . $image_id . ")");
    $conn->query("UPDATE image SET views = views+1 WHERE id=" . $image_id);
}
// fetch image info
$res = $conn->query("SELECT * FROM image WHERE id=" . $image_id);
if ($res->num_rows == 0) die("no such image exists");
$img = $res->fetch_assoc();

// fetch author info
$res = $conn->query("SELECT * FROM user WHERE id=" . $img['author_id']);
if ($res->num_rows == 0) die("author not exists");
$author = $res->fetch_assoc();

// fetch author's work's tags
$author_images_tags = $conn->query("
    SELECT
      tag_category.name,
      tag_category.id,
      count(*) AS count
    FROM image, image_tag, tag_category
    WHERE image.author_id = " . $author['id'] . " 
          AND image.id = image_tag.image_id 
          AND tag_category.id = image_tag.tag_id
    GROUP BY tag_category.name, tag_category.id;
")->fetch_all(MYSQLI_ASSOC);

// fetch category
$res = $conn->query("SELECT * FROM image_category WHERE id=" . $img['category_id']);
if ($res->num_rows == 0) die("category not exists");
$image_category = $res->fetch_assoc();
$image_category = $image_category['name'];

// fetch comments
// TODO: get only part of the comment for pagetion
$sql = "SELECT * FROM comment WHERE image_id =" . $image_id . " ORDER BY id";
if ($display_desc) $sql .= " desc"; //decide display order
$res = $conn->query($sql);
$comments = $res->fetch_all(MYSQLI_ASSOC);

// fetch image's tag
$res = $conn->query("SELECT tag_category.name FROM image_tag,tag_category WHERE image_tag.tag_id=tag_category.id AND image_id=" . $image_id);
$image_tags = $res->fetch_all(MYSQLI_ASSOC);

// fixme: should be order by some recommendation algorithm
$recommended_images = $conn->query("SELECT * FROM image WHERE id != " . $image_id . " ORDER BY rand() LIMIT 3;")->fetch_all(MYSQLI_ASSOC);

// hack: close connection at the the end of the file so that in the middle still can access to db
?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <?php require '../common/head.php' ?>
    <title><?php if (isset($img) and isset($author)) echo "「" . $img['name'] . "」 / 「" . $author['pilipili_id'] . "」 "; ?>
        [pilipili]</title>
    <style>
        body {
            /*<!--TODO: check if not set custom background-->*/
            background: url("<?php echo $author['custom_background_image_filepath']?>") no-repeat;
            background-size: 100%;
            background-attachment: fixed;
            /*background-position: center;*/
        }

        img {
            max-width: 100%
        }
    </style>
    <script>
        function rating() {
            var score = parseInt(document.getElementById('rating-input').value);
            if (isNaN(score)) {
                alert('must input number type');
                return;
            }
            if (score < 0 || score > 10) {
                alert('score should between 0 and 10 (inclusive)');
                return;
            }

            //server update model
            var xmlhttp = new XMLHttpRequest();
            var url = 'rating.php';
            var params = 'score=' + score + '&user_id=<?php echo $current_user['id']?>&image_id=<?php echo $image_id?>';
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //local update view
                    document.getElementById('rating-ratings').innerText = parseInt(document.getElementById('rating-ratings').innerText) + 1;
                    document.getElementById('rating-total-score').innerText = parseInt(document.getElementById('rating-total-score').innerText) + score;
                    document.getElementById('rating-unrated').style = 'display: none;';
                    document.getElementById('rating-rated').style = 'display: block;';
                    document.getElementById('rating-rated').innerHTML = 'Your have rated it : ' + score;
                }
            }
            xmlhttp.open('Post', url, true);
            xmlhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(params);
        }

        function add_tag() {
            var tag = document.getElementById('add_tag_input').value;
            if (tag.length == 0) {
                alert("You forgot to add your tag");
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            var url = 'add_tag.php';
            var params = "added_user=" + encodeURIComponent(<?php echo $current_user['id'];?>) +
                "&image_id=" + encodeURIComponent(<?php echo $img['id'];?>) +
                "&tag_name=" + encodeURIComponent(tag);
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("image_tags").innerHTML += xmlhttp.responseText;
                    document.getElementById('add_tag_input').value = '';
                }
            }
            xmlhttp.open("POST", url, true);
            xmlhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(params);

        }

        function write_comment() {
            var content = document.getElementById('input_comment').value;
            if (content.length == 0) {
                //TODO: style it
                alert("Your comment is empty");
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            var url = 'write_comment.php';
            var params = "user_id=" + encodeURIComponent(<?php echo $current_user['id'];?>) +
                "&image_id=" + encodeURIComponent(<?php echo $img['id'];?>) +
                "&content=" + encodeURIComponent(content);
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    <?php
                    if ($display_desc) {
                        echo "document.getElementById('area_comments').innerHTML = xmlhttp.responseText + document.getElementById('area_comments').innerHTML;";
                    } else {
                        echo "document.getElementById('area_comments').innerHTML += xmlhttp.responseText;";
                    }
                    ?>
//                            document.getElementById('area_comments').innerHTML += xmlhttp.responseText;
                    document.getElementById('input_comment').value = '';
                }
            };
            xmlhttp.open("POST", url, true);
            xmlhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(params);

        }
    </script>
</head>
<body>
<?php require '../common/navbar.php' ?>
<!--TODO: crop image in server side-->
<div id="content-wrap" class="container">
    <!--    left side-->
    <div class="col-md-2" id="left-side">
        <section id="user-info" class="content text-center sec">
            <div><img src="<?php echo $author['avatar_filepath']; ?>" alt="avatar"></div>
            <div><a href="#user-info"><?php echo $author['pilipili_id']; ?></a></div>
            <div><a href="follow_user.php" role="button" class="btn btn-default">Follow</a></div>
            <div><a href="send_request.php" role="button" class="btn btn-default">Send friend request</a></div>
            <div><a href="send_message.php" role="button" class="btn btn-default">Send message</a></div>
        </section>
        <section id="booth" class="content text-center sec">
            This is left unimplemented
        </section>
        <section id="tags_sec" class="content">
            <div style="background-color: #dddddd;"><a href="#" style="color: black;">Illustration Tags</a></div>
            <div id="tags" class="content">
                <?php
                foreach ($author_images_tags as $tag) {
                    $font_style = "font-size: ";
                    $size = min($tag['count'] * 10, 200);
                    $size = max($size, 50);
                    $font_style .= $size;
                    $font_style .= "%;";
                    if ($size > 100) $font_style .= " font-weight: bold;";
                    echo '<a href="../image/detail.php?image_id=' . $image_id . '&tag=' . $tag['id'] . '" style="' . $font_style . '">' . $tag['name'] . '(' . $tag['count'] . ')' . ' </a>';
                }
                ?>
            </div>
            <div><a href="#" class="pull-right">View list</a></div>
        </section>
    </div>

    <!--    mid side-->
    <div class="col-md-8 content" id="mid-side">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="nav">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Profile</a></li>
                        <li class="active"><a href="#">Works</a></li>
                        <li><a href="#">Bookmarks</a></li>
                        <li><a href="#">Feed</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--            <section id="other-works" class="text-center">-->
        <!--                <div class="col-md-5 text-right">-->
        <!--                    <span class="col-md-7"><a href="#" class="pull-right">Another work</a></span>-->
        <!--                    <span class="col-md-5"><a href="#"><img src="../img/other_work_1.jpg" alt=""></a></span>-->
        <!--                </div>-->
        <!--                <div class="col-md-2">-->
        <!--                    <a href="#">Works</a>-->
        <!--                </div>-->
        <!--                <div class="col-md-5 text-left">-->
        <!--                    <span class="col-md-5"><a href="#"><img src="../img/other_work_2.jpg" alt=""></a></span>-->
        <!--                    <span class="col-md-7"><a href="#" class="pull-left">Yet another work</a></span>-->
        <!--                </div>-->
        <!--            </section>-->

        <section id="pic-info">
            <div class="col-md-6">
                <?php echo '<div>' . $img['upload_time'] . ' | ' . $img['resolution_width'] . 'x' . $img['resolution_height'] . ' | <a href="#">' . $image_category . '</a></div>'//TODO: implement href ?>
                <?php echo '<div><h1>' . $img['name'] . '</h1></div>' ?>
            </div>
            <div class="col-md-6 text-right">
                <?php echo '<div>Views: ' . $img['views'] . ' Ratings: <span id="rating-ratings">' . $img['ratings'] . '</span> Total score: <span id="rating-total-score">' . $img['total_score'] . '</span> </div>' ?>
                <!-- fixme: implement rating by JS-->
                <!--                todo: onload page, use php to check which one to use-->
                <?php
                $res = $conn->query("SELECT * FROM rate_image_event WHERE user_id=" . $current_user['id'] . " AND image_id=" . $image_id);
                $rated = $res->fetch_assoc();
                ?>

                <div id="rating-unrated"<?php if ($res->num_rows != 0) echo ' style="display:none"'; ?>>
                    <?php
                    if ($res->num_rows == 0) {
                        echo '
                    <div>
                        <div class="col-md-8 col-md-offset-4">
                            <div class="input-group">
                                <input class="form-control" placeholder="Score: 0~10" type="number"
                                       min="0"
                                       max="10" id="rating-input">
                                <span class="input-group-btn">
                                <button onclick="rating()" class="btn btn-info" type="button">
                                    Rate it
                                </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div><b>This will be implement rating by JS later</b></div>
                    ';
                    }
                    ?>
                </div>
                <div id="rating-rated"<?php if ($res->num_rows == 0) echo ' style="display:none"'; ?>>
                    <?php
                    if ($res->num_rows != 0) {
                        echo 'Your have rated it : ' . $rated['score'];
                    };
                    ?>
                </div>
            </div>
        </section>
        <div class="col-md-12 container-fluid">
            <div class="sec" id="image_tags">
                <?php
                foreach ($image_tags as $tag) {
                    echo '
                        <div class="inline-block"><a href="../search/search.php?mode=tag_full&word=' . $tag['name'] . '"><span class="glyphicon glyphicon-tag tag" aria-hidden="true"></span> ' . $tag['name'] . '</a></div>
                        ';
                }
                ?>
            </div>
            <form class="form-inline pull-right" id="add_tag_form">
                <input type="text" class="form-control" id="add_tag_input" placeholder="Your tag">
                <button accesskey="t" type="button" class="btn btn-default" onclick="add_tag()" data-toggle="tooltip"
                        title="Alt + T">Add Tag
                </button>
            </form>
        </div>
        <div id="img" class="col-md-10 col-md-offset-1 content">
            <img src="<?php echo $img['filepath']; ?>" alt="detail">
        </div>

        <!--below is comments-->
        <div id="comments" class="container-fluid col-sm-10">
            <!--            input-->
            <div id="area_input">
                <div class="col-sm-2">
                    <img src="<?php echo $current_user['avatar_filepath']; ?>" alt="avatar">
                </div>
                <div class="col-sm-10">
                    <form role="form">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="#">Comments</a></li>
                            <li role="presentation"><a href="#">Stickers</a></li>
                        </ul>
                        <textarea style="height: 100px;max-height: 100px;min-height: 100px;" id="input_comment"
                                  name="input_comment"
                                  placeholder="please enter your comment" class="form-control"></textarea>
                        <div>
                            <button type="button" class="btn btn-default">Emoij</button>
                            <button accesskey="c" onclick="write_comment()" type="button"
                                    class="pull-right btn btn-info" data-toggle="tooltip" title="Alt + C">
                                &nbsp&nbsp&nbsp Send
                                &nbsp&nbsp&nbsp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!--            display exists comments-->
            <div id="area_comments">
                <?php
                require '../util/form_data_validation.php';
                foreach ($comments as $comment) {
                    $res = $conn->query("SELECT avatar_filepath,pilipili_id,id FROM user WHERE id=" . $comment['user_id']);
                    $comment_user = $res->fetch_assoc();
                    $div_id = 'area_comments_' . $comment['id'];
//                        $comment_content = '';
//                        eval('$comment_content=\'' . $comment['content'] . '\';');//this is only for demo, never use eval for user input
                    require 'display_comment.php';
                }
                ?>
            </div>
        </div>
        <!--above is comments-->
    </div>

    <!--    right side-->
    <div class="col-md-2" id="right-side">
        <h5>Recommendation</h5>
        <?php
        foreach ($recommended_images as $image) {
            echo '
            <div class="content"><a href="../image/detail.php?image_id=' . $image['id'] . '"><img src="' . $image['filepath'] . '" alt="rec1" class="rec-img"></a></div>
            ';
        }
        ?>
        <!--            <div class="content"><a href="#"><img src="../img/recommendation_mock_1.jpg" alt="rec1"-->
        <!--                                                  class="rec-img"></a></div>-->
        <!--            <div class="content"><a href="#"><img src="../img/recommendation_mock_2.jpg" alt="rec1"-->
        <!--                                                  class="rec-img"></a></div>-->
        <!--            <div class="content"><a href="#"><img src="../img/recommendation_mock_3.jpg" alt="rec1"-->
        <!--                                                  class="rec-img"></a></div>-->
    </div>
</div>
<?php require '../common/footer.php' ?>
<?php $conn->close(); ?>
</body>
</html>

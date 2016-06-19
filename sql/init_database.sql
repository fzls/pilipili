CREATE SCHEMA IF NOT EXISTS pilipili;
USE pilipili;

DROP TABLE IF EXISTS click_image_event;
DROP TABLE IF EXISTS rate_image_event;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS image_tag;
DROP TABLE IF EXISTS user_tag;
DROP TABLE IF EXISTS tag_category;
DROP TABLE IF EXISTS follow;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS image_category;
DROP TABLE IF EXISTS user;

DROP TABLE IF EXISTS banner;
DROP TABLE IF EXISTS ad;

# TODO: add foreign key, and so on

# user
CREATE TABLE user (
  id                               INT AUTO_INCREMENT PRIMARY KEY,
  pilipili_id                      NVARCHAR(100) NOT NULL,
  email                            VARCHAR(100)  NOT NULL,
  password                         VARCHAR(100)  NOT NULL,
  nickname                         NVARCHAR(100),
  gender                           VARCHAR(50),
  gender_visibility                TINYINT,
  birth_year                       SMALLINT,
  birth_year_visibility            TINYINT,
  birth_month                      SMALLINT,
  birth_month_visibility           TINYINT,
  birth_day                        SMALLINT,
  birth_day_visibility             TINYINT,
  occupation                       NVARCHAR(50),
  occupation_visibility            TINYINT,
  country                          NVARCHAR(50),
  country_visibility               TINYINT,
  city                             NVARCHAR(50),
  city_visibility                  TINYINT,
  avatar_filepath                  NVARCHAR(100),
  avatar_mimetype                  VARCHAR(50),
  level                            TINYINT,
  role                             NVARCHAR(50),
  is_premium_member                BOOL,
  premium_member_end_time          DATETIME,
  self_desctription                NVARCHAR(500),
  custom_background_image_filepath NVARCHAR(100),
  custom_background_image_mimetype VARCHAR(50),
  prefered_language                NVARCHAR(50),
  registert_timestamp              TIMESTAMP
);
INSERT INTO user (pilipili_id, email, password, avatar_filepath, custom_background_image_filepath, role) VALUES
  ('Rem', 'Rem@gmail.com', md5('Rem'), '../uploaded_img/avatar_mock_1.jpg',
   '../uploaded_img/detail_background_image_mock_1.jpg', 'admin'),
  ('Lem', 'Lem@gmail.com', md5('Lem'), '../uploaded_img/avatar_mock_2.jpg',
   '../uploaded_img/detail_background_image_mock_2.jpg', 'USER'),
  ('Emi', 'Emi@gmail.com', md5('Emi'), '../uploaded_img/avatar_mock_3.jpg',
   '../uploaded_img/detail_background_image_mock_3.jpg', 'USER'),
  ('Maki', 'Maki@gmail.com', md5('Maki'), '../uploaded_img/avatar_mock_4.jpg',
   '../uploaded_img/detail_background_image_mock_4.jpg', 'USER'),
  ('fzls', 'fzls.zju@gmail.com', md5('test'), '../uploaded_img/avatar_mock_5.jpg',
   '../uploaded_img/detail_background_image_mock_5.jpg', 'USER'),
  # below is test data for suggested user
  ('test1', 'test1@gmail.com', md5('test1'), '../uploaded_img/avatar_mock_2.jpg',
   '../uploaded_img/detail_background_image_mock_2.jpg', 'USER'),
  ('test2', 'test2@gmail.com', md5('test2'), '../uploaded_img/avatar_mock_3.jpg',
   '../uploaded_img/detail_background_image_mock_3.jpg', 'USER'),
  ('test3', 'test3@gmail.com', md5('test3'), '../uploaded_img/avatar_mock_4.jpg',
   '../uploaded_img/detail_background_image_mock_4.jpg', 'USER'),
  ('test4', 'test4@gmail.com', md5('test4'), '../uploaded_img/avatar_mock_5.jpg',
   '../uploaded_img/detail_background_image_mock_5.jpg', 'USER'),
  ('test5', 'test5@gmail.com', md5('test5'), '../uploaded_img/avatar_mock_2.jpg',
   '../uploaded_img/detail_background_image_mock_2.jpg', 'USER'),
  ('test6', 'test6@gmail.com', md5('test6'), '../uploaded_img/avatar_mock_3.jpg',
   '../uploaded_img/detail_background_image_mock_3.jpg', 'USER'),
  ('test7', 'test7@gmail.com', md5('test7'), '../uploaded_img/avatar_mock_4.jpg',
   '../uploaded_img/detail_background_image_mock_4.jpg', 'USER'),
  ('test8', 'test8@gmail.com', md5('test8'), '../uploaded_img/avatar_mock_5.jpg',
   '../uploaded_img/detail_background_image_mock_5.jpg', 'USER'),
  ('test9', 'test9@gmail.com', md5('test9'), '../uploaded_img/avatar_mock_2.jpg',
   '../uploaded_img/detail_background_image_mock_2.jpg', 'USER'),
  ('test10', 'test10@gmail.com', md5('test10'), '../uploaded_img/avatar_mock_3.jpg',
   '../uploaded_img/detail_background_image_mock_3.jpg', 'USER'),
  ('test11', 'test11@gmail.com', md5('test11'), '../uploaded_img/avatar_mock_4.jpg',
   '../uploaded_img/detail_background_image_mock_4.jpg', 'USER'),
  ('test12', 'test12@gmail.com', md5('test12'), '../uploaded_img/avatar_mock_5.jpg',
   '../uploaded_img/detail_background_image_mock_5.jpg', 'USER');

# image category
CREATE TABLE image_category (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name NVARCHAR(50)
);
INSERT INTO image_category (name) VALUES ('Original');
INSERT INTO image_category (name) VALUES ('Illustrations');
INSERT INTO image_category (name) VALUES ('Manga');
INSERT INTO image_category (name) VALUES ('Ugoira');

# images
CREATE TABLE image (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  name                 NVARCHAR(100) NOT NULL,
  filepath             NVARCHAR(100) NOT NULL,
  filesize             DOUBLE, # in bytes
  filename             NVARCHAR(100),
  filetype             NVARCHAR(100),
  ratings              INT,
  views                INT,
  author_id            INT           NOT NULL,
  total_score          INT,
  upload_time          TIMESTAMP,
  resolution_height    INT,
  resolution_width     INT,
  category_id          INT,
  description          NVARCHAR(500),
  browsing_restriction VARCHAR(20),
  privacy              VARCHAR(20),
  md5_hash             NVARCHAR(50),
  FOREIGN KEY (author_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES image_category (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES
  ('カントリー！', '../uploaded_img/1.png', 1, 10, 200, 1000, 1024, 768, 1),
  ('小鸟游六花', '../uploaded_img/2.jpg', 1, 10, 200, 1000, 1024, 768, 2),
  ('高坂桐乃', '../uploaded_img/3.jpg', 2, 10, 200, 1000, 1024, 768, 1),
  ('Sky', '../uploaded_img/4.jpg', 2, 10, 200, 1000, 1024, 768, 3),
  ('test5', '../uploaded_img/5.jpg', 3, 10, 200, 1000, 1024, 768, 1),
  ('test6', '../uploaded_img/6.jpg', 3, 10, 200, 1000, 1024, 768, 4),
  ('test01', '../uploaded_img/avatar_mock_1.jpg', 3, 10, 2020, 1000, 1024, 768, 4),
  ('test02', '../uploaded_img/avatar_mock_2.jpg', 3, 10, 200, 1000, 1024, 768, 4),
  ('test03', '../uploaded_img/avatar_mock_3.jpg', 3, 10, 2300, 1000, 1024, 768, 4),
  ('test04', '../uploaded_img/avatar_mock_4.jpg', 3, 10, 2100, 1000, 1024, 768, 4),
  ('test05', '../uploaded_img/avatar_mock_5.jpg', 3, 10, 2004, 1000, 1024, 768, 4),
  ('test06', '../uploaded_img/detail_background_image_mock_1.jpg', 3, 10, 200, 1000, 1024, 768, 4),
  ('test07', '../uploaded_img/detail_background_image_mock_2.jpg', 3, 10, 200, 1000, 1024, 768, 4),
  ('test08', '../uploaded_img/detail_background_image_mock_3.jpg', 3, 10, 200, 1000, 1024, 768, 4),
  ('test09', '../uploaded_img/detail_background_image_mock_4.jpg', 3, 10, 200, 1000, 1024, 768, 4),
  ('test10', '../uploaded_img/detail_background_image_mock_5.jpg', 3, 10, 200, 1000, 1024, 768, 4);


CREATE TABLE comment (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  user_id             INT           NOT NULL,
  image_id            INT           NOT NULL,
  post_time           TIMESTAMP,
  content             NVARCHAR(500) NOT NULL,
  reply_to_comment_id INT, #leave for implementing reply to function
  vote_up             INT,
  vote_down           INT,
  vote_count          INT,
  FOREIGN KEY (user_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (image_id) REFERENCES image (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (reply_to_comment_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

INSERT INTO comment (user_id, image_id, content) VALUES
  (5, 1, ' < b > ADD COMMENT entity AND FUNCTION </b > '),
  (4, 1, ' < b > lz你怎么还没做完 </b > '),
  (3, 1, '喂，离截止日期只有 <h1 style="display: inline-block;">\';
$rem = strtotime("2016-6-21") - TIME ();
$comment_content.= (ceil($rem/60/60/24).\'</h1> 天了\');
\''),
  (2, 1, '好喜欢上色(｡･ω･｡)ﾉ♡'),
  (1, 1, '好喜欢上色(｡･ω･｡)ﾉ♡(个头啦)');

# tag
CREATE TABLE tag_category (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name NVARCHAR(50)
);

INSERT INTO tag_category (name) VALUES
  ('Kawai'),
  ('Bi - Pool団'),
  ('VOCALOID'),
  ('miku'),
  ('pixivファンタジアFK'),
  ('pixivファンタジアNW'),
  ('pixivファンタジアSR'),
  ('初音ミク'),
  ('インダルジェンス_ティーパーティー'),
  ('クリック推奨'),
  ('ふつくしい'),
  ('オリジナル');

CREATE TABLE image_tag (
  image_id   INT NOT NULL,
  tag_id     INT NOT NULL,
  added_user INT,
  added_time TIMESTAMP,
  FOREIGN KEY (image_id) REFERENCES image (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (tag_id) REFERENCES tag_category (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (added_user) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);


INSERT INTO image_tag (image_id, tag_id) VALUES
  (1, 1),
  (1, 2),
  (1, 3),
  (1, 4),
  (1, 5),
  (1, 6),
  (1, 7),
  (1, 8),
  (1, 9),
  (1, 10),
  (1, 11),
  (1, 12),
  (2, 1),
  (2, 2),
  (2, 3);

CREATE TABLE user_tag (
  user_id INT NOT NULL,
  tag_id  INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (tag_id) REFERENCES tag_category (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

INSERT INTO user_tag (user_id, tag_id) VALUES
  (1, 1),
  (1, 2),
  (1, 3),
  (1, 4),
  (1, 5),
  (1, 6),
  (1, 7),
  (1, 8),
  (1, 9),
  (1, 10),
  (1, 11),
  (1, 12);

# select image.name as image,tag_category.name as tag,user.pilipili_id as user from image,image_tag,tag_category,user
# WHERE image.id=image_tag.image_id and
#   tag_category.id=image_tag.tag_id AND
#   image.author_id=user.id;

# select tag_category.name,tag_category.id,count(*) as count from image,image_tag,tag_category
# WHERE image.author_id = 1 and image.id=image_tag.image_id and tag_category.id=image_tag.tag_id
# GROUP BY tag_category.name,tag_category.id;

# SELECT * FROM image WHERE id != 1 ORDER BY rand() LIMIT 3;

# INSERT INTO image_tag (image_id,tag_id,added_user)
#   SELECT 8, id, 4 FROM tag_category WHERE name='Kawai';

# SELECT * FROM image_tag,tag_category WHERE image_tag.tag_id=tag_category.id and image_id=8
# and tag_category.name='Kawai' and image_tag.added_user=4;

# TODO:homepage related
# INSERT INTO image (name, filepath, filesize, filename, filetype, ratings, views, author_id, total_score, resolution_height, resolution_width, category_id, description, browsing_restriction, privacy, md5_hash)
# VALUES ('name', 'filepath', 'filesize', 'filename', 'filetype', ratings, views, author_id, total_score, resolution_height, resolution_width, category_id, 'description', 'browsing_restriction', 'privacy', 'md5_hash');

# SELECT * FROM image_category WHERE id=5;

# follow relation
CREATE TABLE follow (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  follower_id INT NOT NULL,
  followee_id INT NOT NULL,
  follow_time TIMESTAMP,
  FOREIGN KEY (follower_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (followee_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);


INSERT INTO follow (follower_id, followee_id) VALUES
  (1, 2),
  (1, 3),
  (1, 4),
  (1, 5),
  (2, 3),
  (2, 4),
  (2, 5),
  (3, 4),
  (3, 5),
  (4, 5);

# banner in the main page
CREATE TABLE banner (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  post_time TIMESTAMP,
  link      NVARCHAR(200),
  post_path NVARCHAR(100)
);


INSERT INTO banner (link, post_path) VALUES
  ('../image/detail.php?image_id=8', '../uploaded_img/avatar_mock_2.jpg');

# banner in the main page
CREATE TABLE ad (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  post_time TIMESTAMP,
  link      NVARCHAR(200),
  post_path NVARCHAR(100)
);

INSERT INTO ad (link, post_path) VALUES
  ('../image/detail.php?image_id=4', '../uploaded_img/4.jpg');

CREATE TABLE click_image_event (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  user_id    INT,
  image_id   INT,
  click_time TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (image_id) REFERENCES image (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

# SELECT *
# FROM image
# WHERE id IN (
#   SELECT *
#   FROM (
#          SELECT image_id
#          FROM click_image_event
#          WHERE click_time >= now() - INTERVAL 1 DAY
#          GROUP BY image_id
#          ORDER BY count(*) DESC
#          LIMIT 3
#        ) AS tmp
# );
CREATE TABLE rate_image_event (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  user_id   INT,
  image_id  INT,
  score     INT,
  rate_time TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (image_id) REFERENCES image (id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);


SELECT *
FROM image
ORDER BY total_score DESC, views DESC
LIMIT 3;
SELECT *
FROM image
ORDER BY ratings DESC, views DESC
LIMIT 3;

SELECT *
FROM image
WHERE id IN (
  SELECT *
  FROM (
         SELECT image_id
         FROM rate_image_event
         GROUP BY image_id
         ORDER BY count(score) DESC
         LIMIT 3
       ) AS t
);

# select * from image ORDER BY id LIMIT 5,1;
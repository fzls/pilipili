CREATE SCHEMA IF NOT EXISTS pilipili;
USE pilipili;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS image_category;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS tag_category;
DROP TABLE IF EXISTS image_tag;
DROP TABLE IF EXISTS user_tag;

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
  avator_filepath                  NVARCHAR(100),
  avator_mimetype                  VARCHAR(50),
  level                            TINYINT,
  role                             NVARCHAR(50),
  is_premium_member                BOOL,
  premium_member_end_time          DATETIME,
  self_desctription                NVARCHAR(500),
  custom_background_image_filepath NVARCHAR(100),
  custom_background_image_mimetype VARCHAR(50),
  prefered_language                NVARCHAR(50),
  registert_imestamp               TIMESTAMP
);
INSERT INTO user (pilipili_id, email, password, avator_filepath, custom_background_image_filepath, role)
VALUES ('Rem', 'Rem@gmail.com', md5('Rem'), '../uploaded_img/avator_mock_1.jpg',
        '../uploaded_img/detail_background_image_mock_1.jpg',
        'admin');
INSERT INTO user (pilipili_id, email, password, avator_filepath, custom_background_image_filepath, role)
VALUES
  ('Lem', 'Lem@gmail.com', md5('Lem'), '../uploaded_img/avator_mock_2.jpg',
   '../uploaded_img/detail_background_image_mock_2.jpg', 'user');
INSERT INTO user (pilipili_id, email, password, avator_filepath, custom_background_image_filepath, role)
VALUES
  ('Emi', 'Emi@gmail.com', md5('Emi'), '../uploaded_img/avator_mock_3.jpg',
   '../uploaded_img/detail_background_image_mock_3.jpg', 'user');
INSERT INTO user (pilipili_id, email, password, avator_filepath, custom_background_image_filepath, role)
VALUES ('Maki', 'Maki@gmail.com', md5('Maki'), '../uploaded_img/avator_mock_4.jpg',
        '../uploaded_img/detail_background_image_mock_4.jpg',
        'user');
INSERT INTO user (pilipili_id, email, password, avator_filepath, custom_background_image_filepath, role)
VALUES
  ('fzls', 'fzls.zju@gmail.com', md5('test'), '../uploaded_img/avator_mock_5.jpg',
   '../uploaded_img/detail_background_image_mock_5.jpg',
   'user');

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
  category_id          NVARCHAR(50),
  description          NVARCHAR(500),
  browsing_restriction VARCHAR(20),
  privacy              VARCHAR(20),
  md5_hash             NVARCHAR(50)
);

INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('カントリー！', '../uploaded_img/1.png', 1, 10, 200, 1000, 1024, 768, 1);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('小鸟游六花', '../uploaded_img/2.jpg', 1, 10, 200, 1000, 1024, 768, 2);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('高坂桐乃', '../uploaded_img/3.jpg', 2, 10, 200, 1000, 1024, 768, 1);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('Sky', '../uploaded_img/4.jpg', 2, 10, 200, 1000, 1024, 768, 3);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test5', '../uploaded_img/5.jpg', 3, 10, 200, 1000, 1024, 768, 1);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test6', '../uploaded_img/6.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test01', '../uploaded_img/avator_mock_1.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test02', '../uploaded_img/avator_mock_2.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test03', '../uploaded_img/avator_mock_3.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test04', '../uploaded_img/avator_mock_4.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test05', '../uploaded_img/avator_mock_5.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test06', '../uploaded_img/detail_background_image_mock_1.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test07', '../uploaded_img/detail_background_image_mock_2.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test08', '../uploaded_img/detail_background_image_mock_3.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test09', '../uploaded_img/detail_background_image_mock_4.jpg', 3, 10, 200, 1000, 1024, 768, 4);
INSERT INTO image (name, filepath, author_id, ratings, views, total_score, resolution_height, resolution_width, category_id)
VALUES ('test10', '../uploaded_img/detail_background_image_mock_5.jpg', 3, 10, 200, 1000, 1024, 768, 4);

# image category
CREATE TABLE image_category (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name NVARCHAR(50)
);
INSERT INTO image_category (name) VALUES ('Original');
INSERT INTO image_category (name) VALUES ('Illustrations');
INSERT INTO image_category (name) VALUES ('Manga');
INSERT INTO image_category (name) VALUES ('Ugoira');

CREATE TABLE comment (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  user_id             INT NOT NULL,
  image_id            INT NOT NULL,
  post_time           TIMESTAMP,
  content             NVARCHAR(500),
  reply_to_comment_id INT, #leave for implementing reply to function
  vote_up             INT,
  vote_down           INT,
  vote_count          INT
);
INSERT INTO comment (user_id, image_id, content) VALUES (5, 1, '<b>Add comment entity and function</b>');
INSERT INTO comment (user_id, image_id, content) VALUES (4, 1, '<b>lz你怎么还没做完</b>');
INSERT INTO comment (user_id, image_id, content) VALUES (3, 1,
                                                         '喂，离截止日期只有 <h1 style="display: inline-block;">\';$rem = strtotime("2016-6-21") - time();$comment_content.= (ceil($rem / 60 / 60 / 24).\'</h1> 天了\');\'');
INSERT INTO comment (user_id, image_id, content) VALUES (2, 1, '好喜欢上色(｡･ω･｡)ﾉ♡');
INSERT INTO comment (user_id, image_id, content) VALUES (1, 1, '好喜欢上色(｡･ω･｡)ﾉ♡(个头啦)');

# tag
CREATE TABLE tag_category (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name NVARCHAR(50)
);

INSERT INTO tag_category (name) VALUES ('Kawai');
INSERT INTO tag_category (name) VALUES ('Bi-Pool団');
INSERT INTO tag_category (name) VALUES ('VOCALOID');
INSERT INTO tag_category (name) VALUES ('miku');
INSERT INTO tag_category (name) VALUES ('pixivファンタジアFK');
INSERT INTO tag_category (name) VALUES ('pixivファンタジアNW');
INSERT INTO tag_category (name) VALUES ('pixivファンタジアSR');
INSERT INTO tag_category (name) VALUES ('初音ミク');
INSERT INTO tag_category (name) VALUES ('インダルジェンス_ティーパーティー');
INSERT INTO tag_category (name) VALUES ('クリック推奨');
INSERT INTO tag_category (name) VALUES ('ふつくしい');
INSERT INTO tag_category (name) VALUES ('オリジナル');

CREATE TABLE image_tag (
  image_id   INT NOT NULL,
  tag_id     INT NOT NULL,
  added_user INT,
  added_time TIMESTAMP
);

INSERT INTO image_tag (image_id, tag_id) VALUES (1, 1);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 2);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 3);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 4);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 5);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 6);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 7);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 8);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 9);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 10);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 11);
INSERT INTO image_tag (image_id, tag_id) VALUES (1, 12);
INSERT INTO image_tag (image_id, tag_id) VALUES (2, 1);
INSERT INTO image_tag (image_id, tag_id) VALUES (2, 2);
INSERT INTO image_tag (image_id, tag_id) VALUES (2, 3);

CREATE TABLE user_tag (
  user_id INT NOT NULL,
  tag_id  INT NOT NULL
);

INSERT INTO user_tag (user_id, tag_id) VALUES (1, 1);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 2);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 3);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 4);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 5);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 6);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 7);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 8);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 9);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 10);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 11);
INSERT INTO user_tag (user_id, tag_id) VALUES (1, 12);

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
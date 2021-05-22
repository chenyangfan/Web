create database IF NOT EXISTS PictureGram;
use PictureGram;

/* table definition for Users*/
create table IF NOT EXISTS Users (
UserID int(11) NOT NULL AUTO_INCREMENT,
`Name` varchar(100) NOT NULL,
About text NOT NULL,
AboutImage varchar(50) NOT NULL,
PRIMARY KEY(UserID)
); 

/* table definition for Posts*/
create table IF NOT EXISTS Posts (
PostID int(11) NOT NULL AUTO_INCREMENT,
UserID int(11) NOT NULL,
PostImage varchar(50) NOT NULL,
Post text NOT NULL,
`Date` timestamp NOT NULL default current_timestamp on update current_timestamp,
PRIMARY KEY(PostID),
foreign key(UserID) references Users(UserID)
); 

/* table definition for Comments*/
create table IF NOT EXISTS Comments (
CommentID int(11) NOT NULL AUTO_INCREMENT,
UserID int(11) NOT NULL,
PostID int(11) NOT NULL,
`Comment` text NOT NULL,
`Date` timestamp NOT NULL default current_timestamp on update current_timestamp,
primary key(CommentID),
foreign key(UserID) references Users(UserID),
foreign key(PostID) references Posts(PostID) 
);

/*table definition for Login */
create table IF NOT EXISTS Login(
LoginID int(11) NOT NULL AUTO_INCREMENT,
UserID int(11) NOT NULL,
Username varchar(255) NOT NULL,
`Password` varchar(255) NOT NULL,
primary key(LoginID),
foreign key(UserID) references Users(UserID)
);

-- Dumping data for table `Users`
INSERT INTO `Users`  VALUES(1, 'Yangfan Chen', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit', 'dal-about.jpg');

-- Dumping data for table `Posts`
INSERT INTO `Posts` (`PostID`, `UserID`, `PostImage`, `Post`, `Date`) VALUES
(1, 1, 'sunset.jpg', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos.', '2020-10-27 17:26:20'),
(2, 1, 'poppies.jpg', 'Pellentesque pellentesque hendrerit rhoncus. Curabitur quis elementum lorem, finibus molestie.', '2020-10-27 17:26:20'),
(3, 1, 'valley1.jpg', 'Fusce libero ligula, feugiat sit. Ut non tincidunt odio, a.', '2020-10-27 17:28:15'),
(4, 1, 'cityscape.jpg', 'Quisque consequat tellus diam, ut.Vestibulum non purus magna. Nam varius, justo dignissim dapibus sollicitudin.', '2020-10-27 17:28:15'),
(5, 1, 'farm.jpg', 'Lorem ipsum dolor sit amet. Fusce ac nisi quis.', '2020-10-27 17:29:00');

-- Dumping data for table `Comments`
INSERT INTO `Comments` (`CommentID`, `UserID`, `PostID`, `Comment`, `Date`) VALUES
(1, 1, 1, 'Aenean cursus scelerisque iaculis. Vivamus enim sem, pharetra placerat vulputate pellentesque, ornare in velit. Donec sollicitudin pharetra fringilla. Duis pretium malesuada nisi. Vivamus at varius lectus. Praesent est sem, lobortis nec dui et, efficitur aliquet metus. Quisque pharetra vulputate turpis a sagittis.', '2020-10-27 17:35:29'),
(2, 1, 1, 'Nnon ullamcorper ante. Nulla aliquam volutpat ligula, vel pretium arcu interdum vel. Nam id varius nisi, ut fringilla diam. Vestibulum congue ultricies nisl eget malesuada. Donec eget dapibus tortor.', '2020-10-27 17:35:29'),
(3, 1, 1, 'Cras sagittis arcu orci, ut vestibulum neque ornare id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec eu leo vitae velit consequat consectetur a eu est.', '2020-10-27 17:35:29'),
(4, 1, 2, 'Vivamus volutpat viverra ultrices. Pellentesque porta scelerisque auctor. Sed luctus, massa nec luctus fringilla, urna diam semper turpis, a cursus massa ligula vitae mi.', '2020-10-27 17:38:52'),
(5, 1, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing!! ', '2020-10-27 17:38:52'),
(6, 1, 2, 'Strange, wonder how they got there??!', '2020-10-27 17:38:52'),
(7, 1, 3, 'Donec eu leo vitae velit consequat consectetur a eu est. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean laoreet tortor eros, sed pretium mi lacinia ut. Nunc imperdiet velit quam, quis aliquet augue imperdiet vel.', '2020-10-27 17:45:12'),
(8, 1, 3, 'Is this a winery?', '2020-10-27 17:45:12'),
(9, 1, 3, 'What a view!!', '2020-10-27 17:45:12'),
(10, 1, 4, 'Nostra, per inceptos himenaeos. Aenean laoreet tortor eros, sed pretium mi lacinia ut. Nunc imperdiet velit quam, quis aliquet augue imperdiet vel.', '2020-10-27 17:46:42'),
(11, 1, 4, 'In id risus justo. Aenean id elementum justo. Fusce rutrum ligula a ligula fermentum dapibus. Nunc non libero tincidunt leo lacinia blandit quis vel elit.', '2020-10-27 17:46:42'),
(12, 1, 4, 'Looks like you\'re on the ferry!', '2020-10-27 17:46:42'),
(13, 1, 5, 'Venenatis vitae, tincidunt id nisi. Sed ipsum velit, sodales nec ultricies eget, sagittis eget lorem. Nam in congue nulla.', '2020-10-27 17:47:40'),
(14, 1, 5, 'Gotta love fresh veggies!', '2020-10-27 17:47:40'),
(15, 1, 1, 'wow!!', '2020-10-27 17:48:23'),
(16, 1, 1, 'What a sunset!!', '2020-10-27 17:48:23'),
(17, 1, 2, 'Nice!!', '2020-10-27 17:52:06'),
(18, 1, 2, 'Pretty!', '2020-10-27 17:52:06'),
(19, 1, 3, 'Good phOto!', '2020-10-27 17:52:51'),
(20, 1, 3, 'Nice Images!!', '2020-10-27 17:52:51'),
(21, 1, 4, 'Nice View of the city!!', '2020-10-27 17:54:27'),
(22, 1, 4, 'Wonderfull!!!', '2020-10-27 17:54:27'),
(23, 1, 5, 'Good farm.', '2020-10-27 17:55:05'),
(24, 1, 5, 'It is summer.', '2020-10-27 17:55:05');

-- Dumping data for table `Login`
INSERT INTO `Login` (`LoginID`, `UserID`, `Username`, `Password`) VALUES
(1, 1, 'cyf1997', 'test.Password');
CREATE TABLE employee(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    age INT,
    title TEXT DEFAULT ''
);
INSERT INTO employee(firstname,lastname,age,title) VALUE 
('Quang','Le','40','CEO'),
('Huong','Le Thi','22','Accountant');
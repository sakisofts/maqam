CREATE TABLE transaction (
                             id INT PRIMARY KEY AUTO_INCREMENT,
                             transaction_id VARCHAR(100) NOT NULL UNIQUE,
                             reference VARCHAR(100) NOT NULL,
                             phone VARCHAR(20) NOT NULL,
                             amount DECIMAL(10, 2) NOT NULL,
                             currency VARCHAR(3) NOT NULL,
                             description VARCHAR(255),
                             type VARCHAR(20) NOT NULL,
                             status VARCHAR(20) NOT NULL DEFAULT 'pending',
                             payment_status VARCHAR(255),
                             message VARCHAR(255),
                             callback_data TEXT,
                             created_at DATETIME NOT NULL,
                             updated_at DATETIME NOT NULL
);

-- Create index on transaction_id
CREATE INDEX idx_transaction_transaction_id ON transaction (transaction_id);

-- Create index on reference
CREATE INDEX idx_transaction_reference ON transaction (reference);

-- Create index on type and status
CREATE INDEX idx_transaction_type_status ON transaction (type, status);


alter table bookings add column name varchar(255);
alter table bookings add column email varchar(255);

alter table users add column status Boolean default false;
alter table users add column password_changed_at timestamp default now();
alter table users add column email_change_token varchar(255) default null;
alter table users add column notify_login Boolean default false;
alter table users add column notify_updates Boolean default false;
alter table users add column notify_news Boolean default false;
alter table users add column new_email varchar(255) default null;

alter table users add column web_notify_login Boolean default false;
alter table users add column web_notify_updates Boolean default false;
alter table users add column web_notify_messages Boolean default false;
alter table users add column web_notify_news Boolean default false;

alter table users add column push_notify_login Boolean default false;
alter table users add column push_notify_updates Boolean default false;
alter table users add column push_notify_messages Boolean default false;
alter table users add column push_notify_news Boolean default false;

alter table users add column push_notify_news Boolean default false;

create table devices(
                        id bigint auto_increment primary key,
                        device_name varchar(255) not null,
                        last_used_at timestamp
);



CREATE TABLE user_profile (
                              id bigint  AUTO_INCREMENT PRIMARY KEY,
                              firstName VARCHAR(255) NOT NULL,
                              lastName VARCHAR(255) NOT NULL,
                              phone VARCHAR(50),
                              birthdate DATE,
                              gender ENUM('male', 'female', 'other'),
                              country_id INT,
                              address TEXT,
                              city VARCHAR(100),
                              postal_code VARCHAR(20),
                              bio TEXT,
                              avatar VARCHAR(255),
                              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                              updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

alter table user_profile add column userId int;



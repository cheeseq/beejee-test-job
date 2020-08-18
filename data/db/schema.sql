create table if not exists tasks
(
    `id` int auto_increment
        primary key,
    `username` varchar(100) not null,
    `email` varchar(100) not null,
    `text` text not null,
    `status` tinyint default 0 not null,
    `is_touched` boolean default 0 not null,
    `created_at` datetime not null,
    `updated_at` datetime not null
);


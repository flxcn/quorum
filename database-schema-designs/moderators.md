moderators table

table_column            | data type
------------------------|--------------------------------------------
moderator_id            | primary int(11) NOT NULL
username                | varchar(50) NOT NULL 
password                | varchar(250) NOT NULL
max_delegate_yea_votes  |
max_caucus_yea_votes    |
created_on              | timestamp NOT NULL, default: CURRENT_TIMESTAMP
last_active_on          | timestamp, default: CURRENT_TIMESTAMP


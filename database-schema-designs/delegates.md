delegates table

table_column    | data type
----------------|--------------------------------------------
delegate_id     | primary int(11) NOT NULL
first_name      | varchar(50) NOT NULL 
last_name       | varchar(50) NOT NULL
caucus          | varchar(50) NOT NULL
username        | varchar(50) NOT NULL
<!-- password        | varchar(250), NOT NULL -->
is_enabled      | bool NOT NULL, default: TRUE
created_on      | timestamp NOT NULL, default: CURRENT_TIMESTAMP
last_active_on  | timestamp, default: CURRENT_TIMESTAMP


caucuses table

caucus_id       | primary, int(11), NOT NULL
title           |
description     |
decision        | bool, default: NULL (could be 0 [nay], 1 [yea], or null [abstain])
is_verified     | bool, default: FALSE (0)
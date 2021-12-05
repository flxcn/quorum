ballots table

ballot_id       | primary, int(11), NOT NULL
caucus_id       | int(11), NOT NULL
vote_id         | int(11), NOT NULL
created_on      | timestamp
decision        | bool, default: NULL (could be 0 [nay], 1 [yea], or null [abstain])
is_verified     | bool, default: FALSE (0)
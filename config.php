<?php
# Config file for msgsys
# Modify as per requirement
define('MSGSYS_DB_HOST', "192.168.2.101");
define('MSGSYS_DB_NAME', "msgsys_db");
define('MSGSYS_DB_USER', "msgsysop");
define('MSGSYS_DB_PASS', "MSGSYSop1234");
# Create an empty MySQL table mstblusers
# CREATE TABLE mstblusers (uid BIGINT PRIMARY, id BIGINT NOT NULL, user VARCHAR(50), channel VARCHAR(50))
# Table has to be created manually
CREATE TABLE IF NOT EXISTS "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);
CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE IF NOT EXISTS "users" ("id" integer primary key autoincrement not null, "first_name" varchar not null, "last_name" varchar not null, "middle_initial" varchar, "suffix" varchar, "email" varchar not null, "phone" varchar, "is_driver" tinyint(1), "license" varchar, "region" varchar, "province" varchar, "city" varchar, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime);
CREATE UNIQUE INDEX "users_email_unique" on "users" ("email");
CREATE TABLE IF NOT EXISTS "jobs" ("id" integer primary key autoincrement not null, "created_at" datetime, "updated_at" datetime);
CREATE TABLE IF NOT EXISTS "cache" ("id" integer primary key autoincrement not null, "created_at" datetime, "updated_at" datetime);

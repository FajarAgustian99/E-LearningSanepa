-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table sanepa_db.announcements
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.announcements: ~0 rows (approximately)
INSERT INTO `announcements` (`id`, `title`, `description`, `date`, `created_at`, `updated_at`) VALUES
	(1, 'Penilaian Sumatif Akhir Tahun', 'Kegiatan ini akan dilaksanakan pada tanggal 1 Desember 2025', '2025-11-29', '2025-11-28 22:11:23', '2025-12-02 17:57:21');

-- Dumping structure for table sanepa_db.assignments
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `class_id` bigint unsigned NOT NULL,
  `teacher_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `due_date` datetime DEFAULT NULL,
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignments_course_id_foreign` (`course_id`),
  KEY `assignments_class_id_foreign` (`class_id`),
  KEY `assignments_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `assignments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignments_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.assignments: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.attendances
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned DEFAULT NULL,
  `course_id` bigint unsigned DEFAULT NULL,
  `student_id` bigint unsigned DEFAULT NULL,
  `teacher_id` bigint unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Alpa',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_attendance` (`class_id`,`course_id`,`student_id`,`date`),
  KEY `attendances_course_id_foreign` (`course_id`),
  KEY `attendances_student_id_foreign` (`student_id`),
  KEY `attendances_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `attendances_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.attendances: ~2 rows (approximately)

-- Dumping structure for table sanepa_db.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.cache: ~10 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('e-learningsanepa-cache-guru1@sanepa.test|127.0.0.1', 'i:1;', 1770947697),
	('e-learningsanepa-cache-guru1@sanepa.test|127.0.0.1:timer', 'i:1770947697;', 1770947697),
	('e-learningsanepa-cache-siswa3@gmail.com|127.0.0.1', 'i:1;', 1770095208),
	('e-learningsanepa-cache-siswa3@gmail.com|127.0.0.1:timer', 'i:1770095208;', 1770095208),
	('laravel-cache-adnan@lms.com|127.0.0.1', 'i:1;', 1764213512),
	('laravel-cache-adnan@lms.com|127.0.0.1:timer', 'i:1764213512;', 1764213512),
	('laravel-cache-fajar3@lms.com|127.0.0.1:timer', 'i:1763377757;', 1763377757),
	('laravel-cache-siswa1@lms.com|127.0.0.1', 'i:1;', 1764317576),
	('laravel-cache-siswa1@lms.com|127.0.0.1:timer', 'i:1764317576;', 1764317576);

-- Dumping structure for table sanepa_db.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `teacher_id` bigint unsigned DEFAULT NULL,
  `class_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attendance_locked` tinyint(1) NOT NULL DEFAULT '0',
  `meet_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher_deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_course_id_foreign` (`course_id`),
  CONSTRAINT `classes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.classes: ~28 rows (approximately)
INSERT INTO `classes` (`id`, `name`, `grade`, `description`, `teacher_id`, `class_code`, `attendance_locked`, `meet_link`, `course_id`, `created_at`, `updated_at`, `teacher_deleted_at`, `deleted_at`) VALUES
	(1, 'X 1', 'X', 'Kelas X 1', 2, NULL, 1, NULL, 1, '2026-02-01 07:22:08', '2026-02-03 04:58:00', NULL, NULL),
	(2, 'X 2', 'X', 'Kelas X 2', 3, NULL, 0, NULL, 1, '2026-02-01 07:22:08', '2026-02-04 07:21:16', NULL, NULL),
	(3, 'X 3', 'X', 'Kelas X 3', 4, NULL, 0, NULL, 1, '2026-02-01 07:22:08', '2026-02-01 07:47:30', NULL, NULL),
	(4, 'X 4', 'X', 'Kelas X 4', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:24:41', '2026-02-04 23:24:41', NULL, NULL),
	(5, 'X 5', 'X', 'Kelas X 5', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:25:08', '2026-02-04 23:25:08', NULL, NULL),
	(6, 'X 6', 'X', 'Kelas X 6', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:25:24', '2026-02-04 23:25:24', NULL, NULL),
	(7, 'X 7', 'X', 'Kelas X 7', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:25:40', '2026-02-04 23:25:40', NULL, NULL),
	(8, 'X 8', 'X', 'Kelas X 8', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:25:55', '2026-02-04 23:25:55', NULL, NULL),
	(9, 'X 9', 'X', 'Kelas X 9', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:26:17', '2026-02-04 23:26:17', NULL, NULL),
	(10, 'X 10', 'X', 'Kelas X 10', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:26:40', '2026-02-04 23:26:40', NULL, NULL),
	(11, 'XI 1', 'XI', 'Kelas XI 1', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:27:25', '2026-02-04 23:27:25', NULL, NULL),
	(12, 'XI 2', 'XI', 'Kelas XI 2', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:27:46', '2026-02-04 23:27:46', NULL, NULL),
	(13, 'XI 3', 'XI', 'Kelas XI 3', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:28:29', '2026-02-04 23:28:55', NULL, NULL),
	(14, 'XI 4', 'XI', 'Kelas XI 4', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:29:23', '2026-02-04 23:29:23', NULL, NULL),
	(15, 'XI 5', 'XI', 'Kelas XI 5', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:29:52', '2026-02-04 23:29:52', NULL, NULL),
	(16, 'XI 6', 'XI', 'Kelas XI 6', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:30:34', '2026-02-04 23:30:34', NULL, NULL),
	(17, 'XI 7', 'XI', 'Kelas XI 7', NULL, NULL, 0, NULL, NULL, '2026-02-04 23:31:07', '2026-02-04 23:31:07', NULL, NULL),
	(18, 'XI 8', 'XI', 'Kelas XI 8', NULL, NULL, 0, NULL, NULL, '2026-02-06 01:59:47', '2026-02-06 01:59:47', NULL, NULL),
	(19, 'XI 9', 'XI', 'Kelas XI 9', 2, NULL, 0, NULL, NULL, '2026-02-06 02:00:13', '2026-02-16 23:30:44', NULL, NULL),
	(20, 'XII A1', 'XII', 'Kelas XII A1', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:14:20', '2026-02-06 02:14:20', NULL, NULL),
	(21, 'XII A2', 'XII', 'Kelas XII A2', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:17:15', '2026-02-06 02:17:15', NULL, NULL),
	(22, 'XII A3', 'XII', 'Kelas XII A3', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:18:30', '2026-02-06 02:18:30', NULL, NULL),
	(23, 'XII A4', 'XII', 'Kelas XII A4', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:19:25', '2026-02-06 02:19:25', NULL, NULL),
	(24, 'XII A5', 'XII', 'Kelas XII A5', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:20:14', '2026-02-06 02:20:14', NULL, NULL),
	(25, 'XII A6', 'XII', 'Kelas XII A6', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:25:24', '2026-02-06 02:25:24', NULL, NULL),
	(26, 'XII P1', 'XII', 'Kelas XII P1', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:28:14', '2026-02-06 02:43:50', NULL, NULL),
	(27, 'XII P2', 'XII', 'Kelas XII P2', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:40:25', '2026-02-06 02:43:35', NULL, NULL),
	(28, 'XII P3', 'XII', 'Kelas XII P3', NULL, NULL, 0, NULL, NULL, '2026-02-06 02:41:11', '2026-02-06 02:41:11', NULL, NULL);

-- Dumping structure for table sanepa_db.class_course
CREATE TABLE IF NOT EXISTS `class_course` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_course_class_id_foreign` (`class_id`),
  KEY `class_course_course_id_foreign` (`course_id`),
  CONSTRAINT `class_course_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_course_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.class_course: ~2 rows (approximately)
INSERT INTO `class_course` (`id`, `class_id`, `course_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2026-02-03 03:04:09', '2026-02-03 03:04:09'),
	(2, 2, 1, '2026-02-03 03:04:09', '2026-02-03 03:04:09'),
	(3, 3, 1, '2026-02-03 03:04:09', '2026-02-03 03:04:09');

-- Dumping structure for table sanepa_db.class_teacher
CREATE TABLE IF NOT EXISTS `class_teacher` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `teacher_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_teacher_class_id_foreign` (`class_id`),
  CONSTRAINT `class_teacher_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.class_teacher: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.class_user
CREATE TABLE IF NOT EXISTS `class_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_user_class_id_foreign` (`class_id`),
  CONSTRAINT `class_user_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.class_user: ~2 rows (approximately)
INSERT INTO `class_user` (`id`, `class_id`, `user_id`, `role`, `created_at`, `updated_at`) VALUES
	(2, 1, 2, 'teacher', '2026-02-17 01:56:14', '2026-02-17 01:56:14');

-- Dumping structure for table sanepa_db.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `discussion_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `class_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_discussion_id_foreign` (`discussion_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  KEY `comments_class_id_foreign` (`class_id`),
  CONSTRAINT `comments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_discussion_id_foreign` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.comments: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `join_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_teacher_id_foreign` (`teacher_id`),
  KEY `courses_class_id_foreign` (`class_id`),
  CONSTRAINT `courses_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  CONSTRAINT `courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.courses: ~3 rows (approximately)
INSERT INTO `courses` (`id`, `class_id`, `title`, `grade`, `description`, `join_code`, `image`, `teacher_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Matematika', 'X', 'Deskripsi Matematika', 'SNP005', NULL, 2, '2026-02-01 07:22:10', '2026-02-01 08:21:54'),
	(4, 1, 'IPS', 'XI', 'Deskripsi IPS', 'SNP004', NULL, 2, '2026-02-01 07:22:10', '2026-02-17 01:54:38');

-- Dumping structure for table sanepa_db.course_user
CREATE TABLE IF NOT EXISTS `course_user` (
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `course_user_course_id_foreign` (`course_id`),
  CONSTRAINT `course_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.course_user: ~2 rows (approximately)

-- Dumping structure for table sanepa_db.discussions
CREATE TABLE IF NOT EXISTS `discussions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `class_id` bigint unsigned DEFAULT NULL,
  `teacher_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discussions_teacher_id_foreign` (`teacher_id`),
  KEY `discussions_course_id_foreign` (`course_id`),
  KEY `discussions_class_id_foreign` (`class_id`),
  CONSTRAINT `discussions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `discussions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `discussions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.discussions: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.enrollments
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enrolled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enrollments_class_id_user_id_unique` (`class_id`,`user_id`),
  KEY `enrollments_user_id_foreign` (`user_id`),
  CONSTRAINT `enrollments_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.enrollments: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.grades
CREATE TABLE IF NOT EXISTS `grades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `teacher_id` bigint unsigned DEFAULT NULL,
  `class_id` bigint unsigned DEFAULT NULL,
  `course_id` bigint unsigned DEFAULT NULL,
  `rekap_absensi` decimal(5,2) DEFAULT NULL,
  `lingkup_materi_1` decimal(5,2) DEFAULT NULL,
  `lingkup_materi_2` decimal(5,2) DEFAULT NULL,
  `lingkup_materi_3` decimal(5,2) DEFAULT NULL,
  `lingkup_materi_4` decimal(5,2) DEFAULT NULL,
  `sumatif_akhir_semester` decimal(5,2) DEFAULT NULL,
  `uhb` decimal(5,2) DEFAULT NULL,
  `psat` decimal(5,2) DEFAULT NULL,
  `na` decimal(5,2) DEFAULT NULL,
  `kktp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_student_id_index` (`student_id`),
  KEY `grades_teacher_id_index` (`teacher_id`),
  KEY `grades_class_id_index` (`class_id`),
  KEY `grades_course_id_foreign` (`course_id`),
  CONSTRAINT `grades_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `grades_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grades_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.grades: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.materials
CREATE TABLE IF NOT EXISTS `materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meeting_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_upload` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_class_id_foreign` (`class_id`),
  CONSTRAINT `materials_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.materials: ~2 rows (approximately)
INSERT INTO `materials` (`id`, `class_id`, `title`, `file`, `description`, `meeting_link`, `link_upload`, `created_at`, `updated_at`) VALUES
	(2, 2, 'BAB I Pengantar Matematika', 'materials/h51PXw8WApEDuJdVxx0YljEc99Xner0Zt43PUwoH.pdf', 'Pengantar Matematika', 'https://meet.google.com/ean-fsck-gwy', 'https://drive.google.com/drive/folders/1JkmlaNiTNTEWTilHjGEx9EeRXVDG150O?usp=sharing', '2026-02-02 23:25:52', '2026-02-02 23:25:52'),
	(3, 2, 'BAB II Matematika Dasar', 'materials/e0DRkn0N4hYNoJ0pFhyvvMCCWuTsrRDU5EGzazJd.pdf', 'Matematika Dasar', 'https://meet.google.com/ijk-knmg-daf', 'https://drive.google.com/drive/folders/1JkmlaNiTNTEWTilHjGEx9EeRXVDG150O?usp=drive_link', '2026-02-03 03:02:13', '2026-02-03 03:02:13');

-- Dumping structure for table sanepa_db.material_user
CREATE TABLE IF NOT EXISTS `material_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `material_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_user_material_id_foreign` (`material_id`),
  KEY `material_user_user_id_foreign` (`user_id`),
  CONSTRAINT `material_user_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `material_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.material_user: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.migrations: ~62 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000001_create_cache_table', 1),
	(2, '0001_01_01_000002_create_jobs_table', 1),
	(3, '2025_09_21_132559_create_roles_table', 1),
	(4, '2025_09_21_150841_create_users_table', 1),
	(5, '2025_09_21_151212_create_classes_table', 1),
	(6, '2025_09_21_151213_create_courses_table', 1),
	(7, '2025_09_21_151331_create_enrollments_table', 1),
	(8, '2025_09_21_151421_create_assignments_table', 1),
	(9, '2025_09_21_151539_create_submissions_table', 1),
	(10, '2025_09_21_152003_create_grades_table', 1),
	(11, '2025_09_21_152100_create_attendances_table', 1),
	(12, '2025_09_21_152541_create_sessions_table', 1),
	(13, '2025_09_22_151430_add_class_id_to_users_table', 1),
	(14, '2025_09_28_140859_add_image_to_courses_table', 1),
	(15, '2025_10_07_152458_add_teacher_id_to_attendances_table', 1),
	(16, '2025_10_18_101919_create_discussions_table', 1),
	(17, '2025_10_18_103554_create_students_table', 1),
	(18, '2025_10_18_134402_create_materials_table', 2),
	(19, '2025_10_18_134443_create_quizzes_table', 2),
	(20, '2025_10_18_134506_create_tasks_table', 2),
	(21, '2025_10_18_134525_add_meet_link_to_classes_table', 2),
	(22, '2025_10_18_134547_create_comments_table', 2),
	(23, '2025_10_19_025646_add_content_to_materials_table', 3),
	(24, '2025_10_19_174406_add_deleted_at_to_classes_table', 3),
	(25, '2025_10_19_204222_add_teacher_deleted_at_to_classes_table', 4),
	(26, '2025_11_08_115012_alter_course_id_nullable_in_attendances_table', 5),
	(27, '2025_11_08_120757_add_locked_to_attendances_table', 6),
	(28, '2025_11_08_130221_add_attendance_locked_to_classes_table', 7),
	(29, '2025_11_08_135021_create_grades_table', 8),
	(30, '2025_11_08_142650_add_class_id_to_submissions_table', 9),
	(33, '2025_11_08_152128_create_grades_table', 10),
	(34, '2025_11_11_141044_create_questions_table', 10),
	(35, '2025_11_11_143248_add_due_date_to_quizzes_table', 11),
	(36, '2025_11_11_143616_add_due_date_to_quizzes_table', 11),
	(37, '2025_11_11_152203_add_is_essay_to_questions_table', 11),
	(38, '2025_11_11_153204_add_question_type_to_questions_table', 12),
	(39, '2025_11_11_160134_update_questions_table_nullable_options', 13),
	(40, '2025_11_11_161224_add_duration_to_quizzes_table', 14),
	(41, '2025_11_12_132112_change_kktp_column_type_in_grades_table', 15),
	(42, '2025_11_12_134228_add_meeting_link_to_materials_table', 16),
	(43, '2025_11_12_143826_create_discussions_table', 17),
	(44, '2025_11_12_144918_create_comments_table', 18),
	(45, '2025_11_12_150737_add_class_id_to_comments_table', 19),
	(46, '2025_11_12_163614_add_link_upload_to_materials_table', 20),
	(47, '2025_11_12_173048_add_link_upload_to_materials_table', 21),
	(48, '2025_11_15_050842_create_announcements_table', 22),
	(49, '2025_11_16_134619_create_courserequest_table', 23),
	(50, '2025_11_18_103029_create_material_user_table', 24),
	(51, '2025_11_18_103647_create_quiz_submissions_table', 25),
	(52, '2025_11_18_105204_create_quiz_answers_table', 26),
	(53, '2025_11_18_112215_add_course_id_to_classes_table', 27),
	(54, '2025_11_18_123651_create_quiz_submissions_table', 28),
	(55, '2025_11_21_113355_create_class_course_table', 29),
	(56, '2025_11_21_123641_add_class_id_to_discussions_table', 30),
	(57, '2025_11_22_025407_add_course_id_to_grades_table', 31),
	(58, '2025_11_22_151419_add_score_detail_to_quiz_submissions_table', 32),
	(59, '2025_11_27_051007_add_role_to_class_user_table', 33),
	(60, '2025_11_28_082247_create_notifications_table', 34),
	(61, '2025_11_29_062851_add_role_to_enrollments_table', 35),
	(62, '2025_11_29_084734_add_user_type_to_attendances_table', 36),
	(63, '2025_11_29_131054_add_class_id_to_courses_table', 37),
	(64, '2025_11_29_140521_create_course_user_table', 38),
	(65, '2026_01_07_163303_change_due_date_type_on_quizzes_table', 39),
	(66, '2026_01_21_145853_create_material_user_table', 39),
	(67, '2026_01_25_155350_add_grade_to_courses', 39),
	(68, '2026_02_01_143027_add_grade_to_classes_table', 39),
	(69, '2026_02_13_020525_add_nip_npsn_nisn_to_users_table', 40),
	(70, '2026_02_13_061114_modify_email_nullable_on_users_table', 41);

-- Dumping structure for table sanepa_db.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.notifications: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint unsigned NOT NULL,
  `question_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_essay` tinyint(1) NOT NULL DEFAULT '0',
  `option_a` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `option_b` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `option_c` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `option_d` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `correct_answer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `essay_answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `score_correct` int DEFAULT '1',
  `score_incorrect` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `question_type` enum('multiple_choice','essay') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'multiple_choice',
  PRIMARY KEY (`id`),
  KEY `questions_quiz_id_foreign` (`quiz_id`),
  CONSTRAINT `questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.questions: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.quizzes
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `duration` bigint NOT NULL DEFAULT '0',
  `due_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quizzes_class_id_foreign` (`class_id`),
  CONSTRAINT `quizzes_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.quizzes: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.quiz_answers
CREATE TABLE IF NOT EXISTS `quiz_answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint unsigned NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `answer_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `selected_option` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `score` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_answers_submission_id_foreign` (`submission_id`),
  KEY `quiz_answers_question_id_foreign` (`question_id`),
  CONSTRAINT `quiz_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quiz_answers_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `quiz_submissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.quiz_answers: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.quiz_submissions
CREATE TABLE IF NOT EXISTS `quiz_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` bigint unsigned NOT NULL,
  `class_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `answers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `score` int DEFAULT NULL,
  `score_correct` int NOT NULL DEFAULT '0',
  `score_incorrect` int NOT NULL DEFAULT '0',
  `is_submitted` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_submissions_quiz_id_foreign` (`quiz_id`),
  KEY `quiz_submissions_user_id_foreign` (`user_id`),
  KEY `quiz_submissions_class_id_foreign` (`class_id`),
  CONSTRAINT `quiz_submissions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_submissions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.quiz_submissions: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.roles: ~2 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', '2026-02-01 07:22:07', '2026-02-01 07:22:07'),
	(2, 'Guru', '2026-02-01 07:22:07', '2026-02-01 07:22:07'),
	(3, 'Siswa', '2026-02-01 07:22:07', '2026-02-01 07:22:07');

-- Dumping structure for table sanepa_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('2d1rN4PZoyQgtry0Y23Y2oNaDBOadCsRXJtViIGr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieVZZSHNSV3VlR21TWERIRm1LNHRQUEE4Rmp2QmZYQVVqT1FFYk5kOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9lLWxlYXJuaW5nc2FuZXBhLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771323939),
	('a5YVlYnkVvnUWPJryIBJGjDWwEYMPcaEWe5ynHiu', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOTZrVjNQQWZyVHdFSmMwTEtlUmJpcU1CUWZ1RWdKankwNktPTERtWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly9lLWxlYXJuaW5nc2FuZXBhLnRlc3QvdGVhY2hlci9hdHRlbmRhbmNlLzEiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1771318610),
	('OTWrL7wGNTJd9Gr9iran8WAzWyEyJ8LkED58ExWG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMk5NRGtwdG9uRlI4RkZKcXBFUW5JY3U4M29oa0JOVE9VN2swUTQ0SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9lLWxlYXJuaW5nc2FuZXBhLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771313865),
	('rSaVdPfKa8YnxwK9kyVP490vBHY4SyT0L9TmlGuZ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVGVteVVrd1VOb29EM1AxQWZnNnNpa0tKMFB1UmN6SDdsWUhsZTM2ZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9lLWxlYXJuaW5nc2FuZXBhLnRlc3QvbG9naW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1771316163);

-- Dumping structure for table sanepa_db.submissions
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `assignment_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `class_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `submissions_assignment_id_user_id_unique` (`assignment_id`,`user_id`),
  KEY `submissions_user_id_foreign` (`user_id`),
  KEY `submissions_class_id_foreign` (`class_id`),
  CONSTRAINT `submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `submissions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.submissions: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_class_id_foreign` (`class_id`),
  KEY `tasks_user_id_foreign` (`user_id`),
  CONSTRAINT `tasks_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.tasks: ~0 rows (approximately)

-- Dumping structure for table sanepa_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint unsigned DEFAULT NULL,
  `class_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nisn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npsn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_npsn_unique` (`npsn`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_class_id_foreign` (`class_id`),
  CONSTRAINT `users_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sanepa_db.users: ~34 rows (approximately)
INSERT INTO `users` (`id`, `role_id`, `class_id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `nip`, `nisn`, `npsn`, `subject`, `phone`, `address`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 'Administrator', NULL, 'admin@sanepa.test', NULL, '$2y$12$FGEQZK7j3E86POo5CyBIr.sBQ5OTAJ7cVB/MPmh142aHnydC.BxBm', NULL, NULL, NULL, '20245860', NULL, NULL, NULL, NULL, '2026-02-01 07:22:07', '2026-02-01 07:22:07'),
	(2, 2, NULL, 'Iis Isna Adi Suniyah, S.Pd', NULL, '197608152009022003', NULL, '$2y$12$O6bnITPEXT.KEMIidjVAg.QIheyD.EuYw75IjXYJexLfpT79z/brO', NULL, '197608152009022003', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-01 07:22:07', '2026-02-06 02:51:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

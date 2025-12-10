-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 06:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Name`, `Description`) VALUES
(1, 'Allopathic', NULL),
(2, 'Herbal', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Registration_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_ID`, `Name`, `Email`, `Phone`, `Address`, `Registration_Date`) VALUES
(1, 'John Smith', 'john.smith@email.com', '555-1234', '123 Main St, Cityville', '2023-01-15'),
(2, 'Sarah Johnson', 'sarah.j@email.com', '555-5678', '456 Oak Ave, Townsburg', '2023-02-20'),
(3, 'Michael Brown', 'mbrown@email.com', '555-9012', '789 Pine Rd, Villageton', '2023-03-10'),
(4, 'Emma Wilson', 'ewilson@email.com', '555-3456', '101 Elm Blvd, Hamletville', '2023-04-05'),
(5, 'David Lee', 'dlee@email.com', '555-7890', '202 Maple Dr, Boroughtown', '2023-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `dosage`
--

CREATE TABLE `dosage` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosage`
--

INSERT INTO `dosage` (`id`, `name`) VALUES
(1, 'Tablet'),
(2, 'Capsule'),
(3, 'Powder for Suspension'),
(4, 'IV Injection or Infusion'),
(5, 'Cream'),
(6, 'IM/IV Injection'),
(7, 'Syrup'),
(8, 'IM Injection'),
(9, 'Suppository'),
(10, 'Gel'),
(11, 'Tablet (Sustained Release)'),
(12, 'Oral Gel'),
(13, 'Lotion'),
(14, 'Pediatric Drops'),
(15, 'Oral Suspension'),
(16, 'Tablet (Extended Release)'),
(17, 'Ophthalmic Solution'),
(18, 'Chewable Tablet'),
(19, 'SC Injection'),
(20, 'Oral Solution'),
(21, 'Test strip'),
(22, 'Glucometer'),
(23, 'IV Infusion'),
(24, 'Ophthalmic Ointment'),
(25, 'Effervescent Tablet'),
(26, 'Effervescent Granules'),
(27, 'Oral Powder'),
(28, 'Capsule (Enteric Coated)'),
(29, 'Tablet (Enteric Coated)'),
(30, 'IV Injection'),
(31, 'Dry Powder Inhalation Capsule (DPI)'),
(32, 'Ointment'),
(33, 'Injection'),
(34, 'Metered-Dose Inhaler (MDI)'),
(35, 'Tablet (Modified Release)'),
(36, 'Medicated Bar'),
(37, 'Oral Granules'),
(38, 'Dispersible Tablet'),
(39, 'Nebuliser Solution'),
(40, 'Ophthalmic Suspension'),
(41, 'Nasal Drop'),
(42, 'Vaginal Tablet'),
(43, 'Capsule (Extended Release)'),
(44, 'Capsule (Timed Release)'),
(45, 'Topical Gel'),
(46, 'Hand Rub'),
(47, 'Capsule (Sustained Release)'),
(48, 'Mouthwash'),
(49, 'Nasal Spray'),
(50, 'IM/IA Injection'),
(51, 'Insulin Device'),
(52, 'BP Monitor Device'),
(53, 'Intratracheal Suspension'),
(54, 'Tablet (Prolonged Release)'),
(55, 'Oral Paste'),
(56, 'Condom'),
(57, 'Tablet (Delayed Release)'),
(58, 'Rectal Saline'),
(59, 'Intraspinal Injection'),
(60, 'Sublingual Tablet'),
(61, 'Tablet (Controlled Release)'),
(62, 'Topical Spray'),
(63, 'Topical Solution'),
(64, 'Solution'),
(65, 'Ophthalmic Gel'),
(66, 'Serum'),
(67, 'Powder for Solution'),
(68, 'Injectable Solution (Oral & IM)'),
(69, 'Flash Tablet'),
(70, 'Emulsion'),
(71, 'Ear Drop'),
(72, 'IV/SC Injection'),
(73, 'Topical Powder'),
(74, 'Irrigation Solution'),
(75, 'Pen Needle'),
(76, 'Capsule (Controlled Release)'),
(77, 'Liquid'),
(78, 'Surgical Scrub'),
(79, 'Scalp Ointment'),
(80, 'Scalp Lotion'),
(81, 'Multidose Dry Powder Inhaler (MDPI)'),
(82, 'Extend Release Suspension'),
(83, 'Nebuliser Suspension'),
(84, 'Rectal Ointment'),
(85, 'Chewing Gum Tablet'),
(86, 'Shampoo'),
(87, 'Nail Lacquer'),
(88, 'Powder for Injection'),
(89, 'Solution for Inhalation'),
(90, 'IM/SC Injection'),
(91, 'XR Tablet (Wax Matrix)'),
(92, 'Vaginal Cream'),
(93, 'Scalp Solution'),
(94, 'Ophthalmic Emulsion'),
(95, 'MUPS Tablet'),
(96, 'Vaginal Gel'),
(97, 'Capsule (Delayed Release)'),
(98, 'Dialysis Solution'),
(99, 'Retard Tablet'),
(100, 'Transdermal Patch'),
(101, 'Microgranules'),
(102, 'Viscoelastic Solution'),
(103, 'Capsule (Modified Release)'),
(104, 'Effervescent Powder'),
(105, 'Sprinkle Capsule'),
(106, 'Nasal Inhaler'),
(107, 'Viscous Eye Drop'),
(108, 'OROS Tablet'),
(109, 'Vaginal Suppository'),
(110, 'Intra-articular Injection'),
(111, 'Long Acting Tablet'),
(112, 'Lancet Needle'),
(113, 'Emulsion for infusion'),
(114, 'Ocular Spray'),
(115, 'Intravitreal Injection'),
(116, 'Vaginal Pessary'),
(117, 'Intracameral Injection'),
(118, 'Intraocular Injection'),
(119, 'Oral Soluble Film'),
(120, 'Buccal Tablet'),
(121, 'Liquid Cleanser Soap'),
(122, 'Nasal Ointment'),
(123, 'Topical Suspension'),
(124, 'Semisolid Preparation'),
(125, 'Suspension for Inhalation'),
(126, 'Muscle Rub');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generics`
--

CREATE TABLE `generics` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `generics`
--

INSERT INTO `generics` (`id`, `name`) VALUES
(1, 'Vitamin B1, B6 & B12'),
(2, 'Cefixime Trihydrate'),
(3, 'Levofloxacin Hemihydrate'),
(4, 'Cholecalciferol [Vitamin D3]'),
(5, 'Fluorouracil'),
(6, 'Miscellaneous Topical Agents'),
(7, 'Ulipristal Acetate [For emergency contraception]'),
(8, 'Multivitamin & Multimineral [A-Z silver preparation]'),
(9, 'Thiamine Hydrochloride'),
(10, 'Calcium Carbonate'),
(11, 'Calcium + Vitamin D3'),
(12, 'Tolperisone Hydrochloride'),
(13, 'Isosorbide Mononitrate'),
(14, 'Betacarotene + Vitamin C + Vitamin E'),
(15, 'Cloxacillin Sodium'),
(16, 'Dextromethorphan + Pseudoephedrine + Triprolidine'),
(17, 'Bromhexine Hydrochloride'),
(18, 'Diclofenac Sodium'),
(19, 'Diclofenac Potassium'),
(20, 'Diclofenac Sodium + Lidocaine Hydrochloride'),
(21, 'Flucloxacillin Sodium'),
(22, 'Vitamin A'),
(23, 'Mifepristone + Misoprostol'),
(24, 'Mebeverine Hydrochloride'),
(25, 'Ivermectin'),
(26, 'Miconazole Nitrate'),
(27, 'Erythromycin'),
(28, 'Paracetamol'),
(29, 'Paracetamol + Caffeine'),
(30, 'Aceclofenac'),
(31, 'Chloramphenicol'),
(32, 'Dexamethasone + Chloramphenicol'),
(33, 'Roxithromycin'),
(34, 'Oxyphenonium Bromide'),
(35, 'Atorvastatin Calcium'),
(36, 'Tetracycline Hydrochloride'),
(37, 'Pancreatin'),
(38, 'Albendazole'),
(39, 'Cephradine'),
(40, 'Cefaclor Monohydrate'),
(41, 'Azithromycin Dihydrate'),
(42, 'Insulin Glargine'),
(43, 'Sodium Picosulfate'),
(44, 'Dicycloverine Hydrochloride'),
(45, 'Amlodipine Besilate + Olmesartan Medoxomil'),
(46, 'Abemaciclib'),
(47, 'Olmesartan Medoxomil'),
(48, 'Olmesartan Medoxomil + Hydrochlorothiazide'),
(49, 'Pseudoephedrine + Guaiphenasine + Triprolidine'),
(50, 'Guaifenesin + Levomenthol + Diphenhydramine'),
(51, 'Guaifenesin + Dextromethorphan + Menthol'),
(52, 'Sodium Alginate + Potassium Bicarbonate'),
(53, 'Sodium Alginate + Sodium Bicarbonate + Calcium Carbonate'),
(54, 'Abiraterone Acetate'),
(55, 'Memantine Hydrochloride'),
(56, 'Misoprostol'),
(57, 'Brimonidine Tartrate + Timolol Maleate'),
(58, 'Acalabrutinib'),
(59, 'Acarbose'),
(60, 'Blood glucose monitoring device'),
(61, 'Ramipril'),
(62, 'Aluminium Hydroxide + Magnesium Hydroxide'),
(63, 'Aluminium Hydroxide + Magnesium Hydroxide + Simethicone'),
(64, 'Cephalexin'),
(65, 'Acetazolamide'),
(66, 'Lisinopril'),
(67, 'Ranitidine Hydrochloride'),
(68, 'Acyclovir'),
(69, 'Acyclovir + Hydrocortisone'),
(70, 'Super antioxidant [vitamins & minerals]'),
(71, 'Paracetamol + Tramadol Hydrochloride'),
(72, 'Acetylcysteine'),
(73, 'Captopril'),
(74, 'Tolfenamic acid'),
(75, 'Oral rehydration salt [tasty]'),
(76, 'Oral rehydration salt [glucose based]'),
(77, 'Oral rehydration salt [flavore & glucose based]'),
(78, 'Alcaftadine'),
(79, 'Calcium Lactate Gluconate + Calcium Carbonate + Vitamin C'),
(80, 'Calcium + Vitamin D3 + Multimineral'),
(81, 'Dexamethasone'),
(82, 'Zoledronic Acid [For hypercalcemia]'),
(83, 'Magaldrate'),
(84, 'Rabeprazole Sodium'),
(85, 'Sparfloxacin'),
(86, 'Insulin Aspart [Protamine Crystallised]'),
(87, 'Biphasic Insulin Aspart'),
(88, 'Escitalopram Oxalate'),
(89, 'Ceftriaxone Sodium'),
(90, 'Cetirizine Hydrochloride'),
(91, 'Levocetirizine Dihydrochloride'),
(92, 'Zoledronic Acid [For osteoporosis]'),
(93, 'Adapalene'),
(94, 'Adapalene + Benzoyl peroxide'),
(95, 'Aclidinium Bromide + Formoterol Fumarate'),
(96, 'Meclizine Hydrochloride'),
(97, 'Meclizine + Pyridoxine'),
(98, 'Clobetasol Propionate'),
(99, 'Clobetasol Propionate + Neomycin Sulphate + Nystatin'),
(100, 'Dextrose'),
(101, 'Sodium Chloride + Dextrose'),
(102, 'Mannitol'),
(103, 'Ampicillin Sodium'),
(104, 'Sildenafil Citrate'),
(105, 'Dapsone'),
(106, 'Clascoterone'),
(107, 'Ticagrelor'),
(108, 'Ambroxol Hydrochloride'),
(109, 'Tocilizumab'),
(110, 'Probiotic Combination [4 Billion]'),
(111, 'Calcium Citrate + Calcitriol'),
(112, 'Dexketoprofen'),
(113, 'Ketorolac Tromethamine'),
(114, 'Folinic Acid'),
(115, 'Lactulose'),
(116, 'Alteplase'),
(117, '10 Vitamin & 6 Mineral [Pregnancy and Breast Feeding Formula]'),
(118, 'Levosalbutamol'),
(119, 'Multivitamin & Multimineral [A-Z gold preparation]'),
(120, 'Vitamin B Complex + Zinc'),
(121, 'Iron Polymaltose Complex + Vitamin B Complex + Zinc'),
(122, 'Diethylamine Salicylate'),
(123, 'Salbutamol'),
(124, 'Pioglitazone + Metformin Hydrochloride'),
(125, 'Pioglitazone'),
(126, 'Insulin Human [rDNA]'),
(127, 'Sulphamethoxazole + Trimethoprim'),
(128, 'Bisoprolol Fumarate'),
(129, 'Amlodipine Besilate'),
(130, 'Amlodipine Besilate + Atenolol'),
(131, 'Ferric Maltol'),
(132, 'Inhaler device'),
(133, 'Bromfenac Sodium'),
(134, 'Hydrochlorothiazide'),
(135, 'Losartan Potassium'),
(136, 'Losartan Potassium + Hydrochlorothiazide'),
(137, 'Iron + Folic Acid + Vitamin B Complex + Vitamine C + Zinc Sulfate'),
(138, 'Tadalafil'),
(139, 'Roflumilast'),
(140, 'Adalimumab'),
(141, 'Prednisolone'),
(142, 'Azilsartan Medoxomil'),
(143, 'Vitamin B complex'),
(144, 'Adenosine'),
(145, 'Ciprofloxacin'),
(146, 'Domperidone Maleate'),
(147, 'Flupentixol + Melitracen'),
(148, 'Empagliflozin'),
(149, 'Empagliflozin + Metformin Hydrochloride'),
(150, 'Cefuroxime Axetil');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Inventory_ID` int(11) NOT NULL,
  `Medicine_ID` int(11) DEFAULT NULL,
  `Batch_Number` varchar(50) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Expiry_Date` date DEFAULT NULL,
  `Purchase_Date` date DEFAULT NULL,
  `Supplier_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Inventory_ID`, `Medicine_ID`, `Batch_Number`, `Quantity`, `Expiry_Date`, `Purchase_Date`, `Supplier_ID`) VALUES
(1, 8452, '1212121', 5, '2025-08-23', '2025-08-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `pharma_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `barcode` int(11) DEFAULT NULL,
  `dosage_id` int(11) DEFAULT NULL,
  `variant_id` longtext DEFAULT NULL,
  `generic_id` int(11) NOT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `categories` text DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `pharma_id`, `category_id`, `barcode`, `dosage_id`, `variant_id`, `generic_id`, `stock_quantity`, `categories`, `name`, `image`, `unit_price`) VALUES
(8452, 75, NULL, 2147483647, 2, NULL, 137, 104, '1', 'FeonA Z', NULL, 157.23),
(8477, 75, NULL, 2147483647, 2, '10', 131, 100, '1', 'Feritol', NULL, 74.29),
(8487, 132, NULL, 1062982132, 2, NULL, 137, 100, '1', 'Ferocom', NULL, 402.54),
(8521, 20, NULL, 1863313463, 2, '10', 131, 100, '1', 'Ferromax', NULL, 101.83),
(8534, 78, NULL, 2147483647, 1, '5', 28, 100, '1', 'Feva', NULL, 424.61),
(8535, 78, NULL, 2147483647, 15, '36', 28, 100, '1', 'Feva', NULL, 107.73),
(8536, 78, NULL, 2147483647, 14, '[]', 28, 100, '[\"2\"]', 'Feva', NULL, 213.55),
(8537, 78, NULL, 2147483647, 16, '[]', 28, 100, '[\"2\"]', 'Feva Extand', NULL, 401.11),
(8538, 78, NULL, 2147483647, 1, '[]', 28, 100, '[\"2\"]', 'Feva One', NULL, 497.74),
(8539, 78, NULL, 1411429267, 1, '[]', 29, 96, '[\"2\"]', 'Feva Plus', NULL, 31.38),
(8540, 78, NULL, 1679075997, 1, '[]', 28, 100, '[\"2\"]', 'Feva Rapid (Actizorb)', NULL, 401.47),
(8541, 128, NULL, 2147483647, 15, '[]', 28, 100, '[\"2\"]', 'Fevac', NULL, 255.24),
(8542, 128, NULL, 2147483647, 1, '[]', 28, 100, '[\"1\"]', 'Fevac', NULL, 465.64),
(8543, 128, NULL, 2147483647, 16, '[]', 28, 100, '[\"1\"]', 'Fevac Extend', NULL, 144.98),
(8544, 31, NULL, 2147483647, 1, '[]', 71, 100, '[\"1\"]', 'Fevedol', NULL, 452.59),
(8546, 97, NULL, 2147483647, 1, '[]', 28, 100, '[\"1\"]', 'Fevimol', NULL, 499.03),
(8548, 92, NULL, 1807976718, 1, '[]', 29, 100, '[\"1\"]', 'Fevnil', NULL, 232.15),
(8549, 92, 2, 2147483647, 1, '[]', 28, 100, '[\"1\"]', 'Fevnil-P', NULL, 133.35),
(8550, NULL, 1, 2147483647, 1, '[]', 29, 100, '[\"1\"]', 'Fevrex Plus', NULL, 252.31),
(8551, 105, 1, 1222, 2, '[\"99\"]', 28, 50, NULL, 'Napa', 'images/medicines/1755938048.png', 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_info_api_log`
--

CREATE TABLE `medicine_info_api_log` (
  `Log_ID` int(11) NOT NULL,
  `API_Name` varchar(100) DEFAULT NULL,
  `Request_Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Response_Code` int(11) DEFAULT NULL,
  `Response_Body` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_log`
--

CREATE TABLE `notification_log` (
  `Notification_ID` int(11) NOT NULL,
  `Recipient_Type` varchar(50) DEFAULT NULL,
  `Recipient_ID` int(11) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `Sent_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ocr_upload`
--

CREATE TABLE `ocr_upload` (
  `Upload_ID` int(11) NOT NULL,
  `Staff_ID` int(11) DEFAULT NULL,
  `Image_URL` varchar(255) DEFAULT NULL,
  `Upload_Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_record`
--

CREATE TABLE `patient_record` (
  `Record_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Prescription_ID` int(11) DEFAULT NULL,
  `Medical_History` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Sale_ID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Payment_Date` date DEFAULT NULL,
  `Payment_Mode` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Payment_ID`, `Sale_ID`, `Amount`, `Payment_Date`, `Payment_Mode`, `Status`) VALUES
(1, 1, 23.97, '2023-06-10', 'Cash', 'Completed'),
(2, 2, 8.50, '2023-06-11', 'Credit Card', 'Completed'),
(3, 3, 18.75, '2023-06-12', 'Cash', 'Completed'),
(4, 4, 27.25, '2023-06-13', 'Credit Card', 'Completed'),
(5, 5, 15.00, '2023-06-14', 'Debit Card', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `pharmaceuticals`
--

CREATE TABLE `pharmaceuticals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmaceuticals`
--

INSERT INTO `pharmaceuticals` (`id`, `name`) VALUES
(1, 'Jenphar Bangladesh Ltd.'),
(2, 'Edruc Limited'),
(3, 'Hallmark Pharmaceuticals Ltd.'),
(4, 'Medimet Pharmaceuticals Ltd.'),
(5, 'ZAS Corporation'),
(6, 'Techno Drugs Ltd.'),
(7, 'DBL Healthcare Ltd.'),
(8, 'Renata PLC'),
(9, 'Pharmik Laboratories Ltd.'),
(10, 'ACME Laboratories Ltd.'),
(11, 'Asiatic Laboratories Ltd.'),
(12, 'Globe Pharmaceuticals Ltd.'),
(13, 'Aristopharma Ltd.'),
(14, 'Apex Pharmaceuticals Ltd.'),
(15, 'Benham Pharmaceuticals Ltd.'),
(16, 'Ambee Pharmaceuticals Ltd.'),
(17, 'Doctor TIMS Pharmaceuticals Ltd.'),
(18, 'Prime Pharmaceuticals Ltd.'),
(19, 'Chemist Laboratories  Ltd.'),
(20, 'ACI Limited'),
(21, 'Arges Life Science Limited'),
(22, 'Healthcare Pharmaceuticals Ltd.'),
(23, 'Union Pharmaceuticals Ltd'),
(24, 'UniMed UniHealth Pharmaceuticals Ltd.'),
(25, 'Incepta Pharmaceuticals Ltd.'),
(26, 'Opsonin Pharma Ltd.'),
(27, 'Eskayef Pharmaceuticals Ltd.'),
(28, 'Team Pharmaceuticals Ltd.'),
(29, 'Ibn Sina Pharmaceuticals Ltd.'),
(30, 'Everest Pharmaceuticals Ltd.'),
(31, 'Drug International Ltd.'),
(32, 'Ziska Pharmaceuticals Ltd.'),
(33, 'Navana Pharmaceuticals Ltd.'),
(34, 'Al-Madina Pharmaceuticals Ltd.'),
(35, 'Pacific Pharmaceuticals Ltd.'),
(36, 'The White Horse Pharmaceuticals Ltd.'),
(37, 'Radiant Export Import Enterprise'),
(38, 'DBL Pharmaceuticals Ltd.'),
(39, 'Square Pharmaceuticals PLC'),
(40, 'Beacon Pharmaceuticals PLC'),
(41, 'Premier Pharmaceuticals Ltd.'),
(42, 'Astra Biopharmaceuticals Ltd.'),
(43, 'Pristine Pharmaceuticals Ltd'),
(44, 'Marksman Pharmaceuticals Ltd.'),
(45, 'Physic pharmaceuticals ltd.'),
(46, 'Concord Pharmaceuticals Ltd.'),
(47, 'Zenith Pharmaceuticals Ltd.'),
(48, 'General Pharmaceuticals Ltd.'),
(49, 'Maks Drug Limited'),
(50, 'Apollo Pharmaceutical Ltd.'),
(51, 'Belsen Pharmaceuticals Ltd.'),
(52, 'Bristol Pharmaceuticals Ltd.'),
(53, 'Central Pharmaceuticals Ltd.'),
(54, 'Medicon Pharmaceuticals Ltd.'),
(55, 'RN Pharmaceuticals'),
(56, 'Biopharma Limited'),
(57, 'Reliance Pharmaceuticals Ltd.'),
(58, 'Decent Pharma Laboratories Ltd.'),
(59, 'Desh Pharmaceuticals Ltd.'),
(60, 'Reman Drug Laboratories Ltd.'),
(61, 'Syntho Laboratories Ltd.'),
(62, 'Beximco Pharmaceuticals Ltd.'),
(63, 'Alco Pharma Ltd.'),
(64, 'SANDOZ (A Novartis Division)'),
(65, 'Pharmasia Limited'),
(66, 'Aexim Pharmaceuticals Ltd.'),
(67, 'Modern Pharmaceuticals Ltd.'),
(68, 'Radiant Pharmaceuticals Ltd.'),
(69, 'Monicopharma Ltd.'),
(70, 'Roche Bangladesh Ltd.'),
(71, 'SMC Enterprise Ltd'),
(72, 'Nuvista Pharma Ltd.'),
(73, 'Albion Laboratories Limited'),
(74, 'Silva Pharmaceuticals Ltd.'),
(75, 'Delta Pharma Ltd.'),
(76, 'Somatec Pharmaceuticals Ltd.'),
(77, 'Novo Nordisk Pharma (Pvt.) Ltd'),
(78, 'Ad-din Pharmaceuticals Ltd.'),
(79, 'NIPRO JMI Pharma Ltd.'),
(80, 'Amulet Pharmaceuticals Ltd.'),
(81, 'Supreme Pharmaceutical Ltd.'),
(82, 'Popular Pharmaceuticals Ltd.'),
(83, 'United Pharmaceuticals Ltd.'),
(84, 'Guardian Healthcare Ltd.'),
(85, 'Euro Pharma Ltd.'),
(86, 'Sonear Laboratories Ltd.'),
(87, 'Kemiko Pharmaceuticals Ltd.'),
(88, 'Rephco Pharmaceuticals Ltd.'),
(89, 'Bain Trade International'),
(90, 'Gaco Pharmaceuticals Ltd.'),
(91, 'Libra Infusions Ltd.'),
(92, 'C2C Pharma Ltd.'),
(93, 'Amico Laboratories Ltd.'),
(94, 'Novartis (Bangladesh) Ltd.'),
(95, 'Mystic Pharmaceuticals Ltd.'),
(96, 'National Drug Co. Ltd.'),
(97, 'Goodman Pharmaceuticals Ltd.'),
(98, 'Naafco Pharma Ltd.'),
(99, 'One Pharma Ltd.'),
(100, 'OSL Pharma Limited'),
(101, 'Total Herbal & Nutraceuticals'),
(102, 'Ethical Drugs Limited'),
(103, 'Alkad Laboratories'),
(104, 'Bengal drugs Ltd.'),
(105, 'Allied Pharmaceuticals Ltd.'),
(106, 'Globex Pharmaceuticals Ltd.'),
(107, 'Indo Bangla Pharmaceutical'),
(108, 'Biogen Pharmaceuticals Ltd.'),
(109, 'Veritas Pharmaceuticals Ltd.'),
(110, 'Discount Pharma'),
(111, 'International Agencies (Bd.) Limited'),
(112, 'Shuvro Limited'),
(113, 'Aztec Pharmaceuticals Ltd.'),
(114, 'Kumudini Pharma Ltd.'),
(115, 'Avarox Pharmaceuticals Ltd.'),
(116, 'Novelta Bestway Pharma Ltd.'),
(117, 'Marker Pharma Ltd.'),
(118, 'Leon Pharmaceuticals Ltd.'),
(119, 'Labaid Pharma Ltd.'),
(120, 'Genvio Pharma Ltd.'),
(121, 'Cipla Limited'),
(122, 'Synovia Pharma PLC.'),
(123, 'Silco Pharmaceutical Ltd.'),
(124, 'Grifols Biologicals LLC'),
(125, 'Doctor’s Chemical Works Ltd.'),
(126, 'Tanaka Sangyo Co. Ltd.'),
(127, 'Pharmadesh Laboratories Ltd.'),
(128, 'Orion Pharma Ltd.'),
(129, 'Rangs Pharmaceuticals Ltd.'),
(130, 'Sun Pharmaceutical (Bangladesh) Ltd.'),
(131, 'Virgo Pharmaceuticals Ltd.'),
(132, 'S.N. Pharmaceutical Ltd.'),
(133, 'Novatek Pharmaceuticals Ltd.'),
(134, 'APC Pharma Ltd.'),
(135, 'Cosmic Pharma Ltd.'),
(136, 'MST Pharma'),
(137, 'Cosmo Pharma Laboratories Ltd.'),
(138, 'Jayson Pharmaceutical Ltd.'),
(139, 'Novo Healthcare and Pharma Ltd.'),
(140, 'Nipa Pharmaceuticals Ltd.'),
(141, 'Seema Pharmaceuticals Ltd.'),
(142, 'Sharif Pharmaceuticals Ltd.'),
(143, 'Hudson Pharmaceuticals Ltd.'),
(144, 'Pharmacil Limited'),
(145, 'Gedeon Richter, Hungary'),
(146, 'MGH Healthcare Limited'),
(147, 'Centeon Pharma Ltd.'),
(148, 'Janata Traders'),
(149, 'Quality Pharmaceuticals Ltd.'),
(150, 'Credence Pharmaceuticals Ltd.');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `Prescription_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Doctor_Name` varchar(100) DEFAULT NULL,
  `Prescription_Date` date DEFAULT NULL,
  `Image_URL` varchar(255) DEFAULT NULL,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Role_ID` int(11) NOT NULL,
  `Role_Name` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Role_ID`, `Role_Name`, `Description`) VALUES
(1, 'Admin', 'System administrator with full access to all features'),
(2, 'Pharmacist', 'Licensed pharmacist who can dispense medication and provide consultations'),
(3, 'Cashier', 'Handles sales transactions and customer payments'),
(4, 'Inventory Manager', 'Manages medicine stock, orders, and supplier relationships');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `Sale_ID` int(11) NOT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Total_Amount` decimal(10,2) DEFAULT NULL,
  `Payment_Method` varchar(50) DEFAULT NULL,
  `Staff_ID` int(11) DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`Sale_ID`, `Customer_ID`, `Date`, `Total_Amount`, `Payment_Method`, `Staff_ID`, `prescription`, `created_at`) VALUES
(1, 1, '2023-06-10', 23.97, 'Cash', 1, NULL, '2025-08-22'),
(2, 2, '2023-06-11', 8.50, 'Credit Card', 1, NULL, '2025-08-22'),
(3, 3, '2023-06-12', 18.75, 'Cash', 2, NULL, '2025-08-22'),
(4, 4, '2023-06-13', 27.25, 'Credit Card', 2, NULL, '2025-08-22'),
(5, 1, '2023-06-14', 15.00, 'Debit Card', 1, NULL, '2025-08-22'),
(6, NULL, '2025-08-22', 282.75, 'cash', 1, NULL, '2025-08-22');

-- --------------------------------------------------------

--
-- Table structure for table `sales_item`
--

CREATE TABLE `sales_item` (
  `Sale_Item_ID` int(11) NOT NULL,
  `Sale_ID` int(11) DEFAULT NULL,
  `Medicine_ID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Unit_Price` decimal(10,2) DEFAULT NULL,
  `Subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_item`
--

INSERT INTO `sales_item` (`Sale_Item_ID`, `Sale_ID`, `Medicine_ID`, `Quantity`, `Unit_Price`, `Subtotal`) VALUES
(8, 1, 8452, 4, 5.99, 23.96),
(9, 2, 8477, 1, 8.50, 8.50),
(10, 3, 8487, 2, 5.99, 11.98),
(11, 3, 8521, 1, 6.75, 6.75),
(12, 4, 8534, 1, 12.25, 12.25),
(13, 4, 8535, 2, 6.75, 13.50),
(14, 5, 8536, 1, 15.00, 15.00),
(15, 6, 8452, 1, 157.23, 157.23),
(16, 6, 8539, 4, 31.38, 125.52);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('H9jPnGp3MH9PNojF6JkGCz6Y4AuGsnhzez2d3HG1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiM2xPZzI4RFlEZWJQZ0xxRTNLM0o5ekRnYjdSbkwwUHdQQ01IVmtZYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjg6InN0YWZmX2lkIjtpOjI7czo0OiJuYW1lIjtzOjEwOiJTdGFmZiBBYmlyIjtzOjU6ImVtYWlsIjtzOjE0OiJhZG1pbjFAYXRzLmNvbSI7czo3OiJyb2xlX2lkIjtpOjI7fQ==', 1753952265),
('mbZln5Hnb4Ur7Kv4EIWm5EJBgQfzSyF7RxZQOB61', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGZ0d3B6UTBBTFBZdHJLRElOaHFvSHZ2U0tQUlhVeHhqa1JPNTN1aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZWRpY2luZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1753945821),
('VhBRSZNOq33lIqHp6MohDyD1gC8amnM1I641X8RC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOW9vN0JQMmI3MlI2UXhJSnpON1NQWlVtcUVsaGVYaGxKSjNqaWJxRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1755859232),
('ydaBV1n8UTnqOrwcM2tHJ9oHhNJe7K95953LkvqJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiUG43SVRabzZEYUZkOXNpc2JwNHFUalRrYjZEOE0wMzBFOThjcHp1cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6ODoic3RhZmZfaWQiO2k6MTtzOjQ6Im5hbWUiO3M6MTg6IkFiaXIgVGFudmlyIFNob2FpYiI7czo1OiJlbWFpbCI7czoxMzoiYWRtaW5AYXRzLmNvbSI7czo3OiJyb2xlX2lkIjtpOjE7fQ==', 1755859615);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Password_Hash` varchar(255) DEFAULT NULL,
  `Role_ID` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`, `Name`, `Email`, `Phone`, `Password_Hash`, `Role_ID`, `status`) VALUES
(1, 'Abir Tanvir Shoaib', 'admin@ats.com', '01636347684', '$2y$10$WzOCAFm3qdOTwxbRwaFqk.JOVOrbIT9NPBYVX5NSPfDS7hPuMUdoi', 1, 'active'),
(2, 'Staff Abir', 'admin1@ats.com', '01905055664', '$2y$10$WzOCAFm3qdOTwxbRwaFqk.JOVOrbIT9NPBYVX5NSPfDS7hPuMUdoi', 2, 'active'),
(3, 'Michael Brown', 'cashier@pharmacy.com', '555-345-6789', '$2y$10$WzOCAFm3qdOTwxbRwaFqk.JOVOrbIT9NPBYVX5NSPfDS7hPuMUdoi', 3, 'active'),
(4, 'Jessica Davis', 'inventory@pharmacy.com', '555-456-7890', '$2y$10$WzOCAFm3qdOTwxbRwaFqk.JOVOrbIT9NPBYVX5NSPfDS7hPuMUdoi', 4, 'active'),
(5, 'David Wilson', 'pharmacist2@pharmacy.com', '555-567-8901', '$2y$10$WzOCAFm3qdOTwxbRwaFqk.JOVOrbIT9NPBYVX5NSPfDS7hPuMUdoi', 2, 'active'),
(6, 'Robert Miller', 'cashier2@pharmacy.com', '555-678-9012', '$2y$10$WzOCAFm3qdOTwxbRwaFqk.JOVOrbIT9NPBYVX5NSPfDS7hPuMUdoi', 3, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `stock_alert`
--

CREATE TABLE `stock_alert` (
  `Alert_ID` int(11) NOT NULL,
  `Inventory_ID` int(11) DEFAULT NULL,
  `Alert_Type` varchar(50) DEFAULT NULL,
  `Alert_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Resolved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `Supplier_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Contact_Person` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`Supplier_ID`, `Name`, `Contact_Person`, `Email`, `Phone`, `Address`) VALUES
(1, 'Sybill Browning', 'Qui aliquid qui mole', 'vifojiv@mailinator.com', '+1 (958) 728-6674', 'Est pariatur Digni'),
(2, 'Salvador Livingston', 'Natus autem porro et', 'nobygake@mailinator.com', '+1 (155) 485-4758', 'Iure omnis eius sed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variation`
--

CREATE TABLE `variation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variation`
--

INSERT INTO `variation` (`id`, `name`) VALUES
(1, '100 mg+200 mg+200 mcg'),
(2, '200 mg'),
(3, '100 mg/5 ml'),
(4, '400 mg'),
(5, '500 mg'),
(6, '20000 IU'),
(7, '40000 IU'),
(8, '2000 IU'),
(9, '25 mg/ml'),
(10, '30 mg'),
(11, '100 mg'),
(12, '500 mg+200 IU'),
(13, '500 mg+400 IU'),
(14, '50 mg'),
(15, '20 mg'),
(16, '6 mg+200 mg+50 mg'),
(17, '125 mg/5 ml'),
(18, '250 mg/vial'),
(19, '500 mg/vial'),
(20, '(10 mg+30 mg+1.25 mg)/5 ml'),
(21, '4 mg/5 ml'),
(22, '25 mg'),
(23, '75 mg/3 ml'),
(24, '12.5 mg'),
(25, '1% w/w'),
(26, '(75 mg+20 mg)/2 ml'),
(27, '250 mg'),
(28, '50000 IU'),
(29, '200 mg+200 mcg'),
(30, '135 mg'),
(31, '6 mg'),
(32, '12 mg'),
(33, '2% w/w'),
(34, '3%'),
(35, '200 mg/5 ml'),
(36, '120 mg/5 ml'),
(37, '500 mg+65 mg'),
(38, '665 mg'),
(39, '0.5%'),
(40, '0.1%+0.5%'),
(41, '150 mg'),
(42, '300 mg'),
(43, '50 mg/5 ml'),
(44, '5 mg'),
(45, '10 mg'),
(46, '325 mg'),
(47, '125 mg/1.25 ml'),
(48, '100 IU/ml'),
(49, '5 mg/5 ml'),
(50, '7.5 mg/ml'),
(51, '10 mg/5 ml'),
(52, '5 mg+20 mg'),
(53, '5 mg+40 mg'),
(54, '10 mg+20 mg'),
(55, '10 mg+40 mg'),
(56, '40 mg'),
(57, '20 mg+12.5 mg'),
(58, '40 mg+12.5 mg'),
(59, '(30 mg+100 mg+1.25 mg)/5 ml'),
(60, '(100 mg+1.1 mg+14 mg)/5 ml'),
(61, '(200 mg+15 mg+15 mg)/5 ml'),
(62, '(500 mg+100 mg)/5 ml'),
(63, '500 mg+100 mg'),
(64, '(500 mg+213 mg+325 mg)/10 ml'),
(65, '(500 mg+267 mg+160 mg)/10 ml'),
(66, '200 mcg'),
(67, '0.2%+0.5%'),
(68, '80 mg/ml'),
(69, '125 mg'),
(70, '10 mg/ml'),
(71, '1000 mg'),
(72, '1.25 mg'),
(73, '2.5 mg'),
(74, '250 mg+400 mg'),
(75, '(175 mg+225 mg)5 ml'),
(76, '(400 mg+400 mg+30 mg)/5 ml'),
(77, '400 mg+400 mg+30 mg'),
(78, '5%+1%'),
(79, '325 mg+37.5 mg'),
(80, '600 mg'),
(81, '100 mg/sachet'),
(82, '10.25 gm'),
(83, '13.47 gm/sachet'),
(84, '0.25%'),
(85, '1000 mg+327 mg (Conventional calcium)+500 mg'),
(86, '600 mg+400 IU'),
(87, '0.1%'),
(88, '30%+70%'),
(89, '75 mg/5 ml'),
(90, '1 gm/vial'),
(91, '2 gm/vial'),
(92, '2.5 mg/ml'),
(93, '2.5 mg/5 ml'),
(94, '5 mg/100 ml'),
(95, '0.1%+2.5%'),
(96, '400 mcg+12 mcg'),
(97, '25 mg+50 mg'),
(98, '0.05%'),
(99, '(0.5 mg+5 mg+1 Lac IU)/gm'),
(100, '5%'),
(101, '10%'),
(102, '0.9%+5%'),
(103, '20%'),
(104, '7.5%'),
(105, '90 mg'),
(106, '15 mg/5 ml'),
(107, '80 mg/4 ml'),
(108, '200 mg/10 ml'),
(109, '162 mg/0.9 ml'),
(110, '4 billion'),
(111, '4 billion/sachet'),
(112, '1200 mg+0.25 mcg'),
(113, '15 mg'),
(114, '3.35 gm/5 ml'),
(115, '50 mg/50 ml'),
(116, '2 mg'),
(117, '1 mg/5 ml'),
(118, '2 mg/5 ml'),
(119, '4 mg'),
(120, '15 mg+500 mg'),
(121, '15 mg+850 mg'),
(122, '40 IU/ml'),
(123, '(200 mg+40 mg)/5 ml'),
(124, '800 mg+160 mg'),
(125, '5 mg+50 mg'),
(126, '0.09%'),
(127, '30 mg/ml'),
(128, '50 mg+12.5 mg'),
(129, '500 mcg'),
(130, '40 mg/0.8 ml'),
(131, '80 mg'),
(132, '(5 mg+2 mg+2 mg+20 mg)/5 ml'),
(133, '6 mg/2 ml'),
(134, '250 mg/5 ml'),
(135, '0.5 mg+10 mg'),
(136, '5 mg+500 mg'),
(137, '0.3%'),
(138, '1 mg'),
(139, '120 mg'),
(140, '10 mg+5 mg'),
(141, '25 mg+5 mg'),
(142, '2.5 mg+500 mg'),
(143, '2.5 mg+850 mg'),
(144, '3 mg'),
(145, '5 mg/ml'),
(146, '2%'),
(147, '100 mg/10 ml'),
(148, '1 mg/ml'),
(149, '2 mg/ml'),
(150, '0.225%+10%');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`);

--
-- Indexes for table `dosage`
--
ALTER TABLE `dosage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `generics`
--
ALTER TABLE `generics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`Inventory_ID`),
  ADD KEY `Medicine_ID` (`Medicine_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generic_id` (`generic_id`),
  ADD KEY `pharma_id` (`pharma_id`);

--
-- Indexes for table `medicine_info_api_log`
--
ALTER TABLE `medicine_info_api_log`
  ADD PRIMARY KEY (`Log_ID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_log`
--
ALTER TABLE `notification_log`
  ADD PRIMARY KEY (`Notification_ID`);

--
-- Indexes for table `ocr_upload`
--
ALTER TABLE `ocr_upload`
  ADD PRIMARY KEY (`Upload_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patient_record`
--
ALTER TABLE `patient_record`
  ADD PRIMARY KEY (`Record_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Prescription_ID` (`Prescription_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Sale_ID` (`Sale_ID`);

--
-- Indexes for table `pharmaceuticals`
--
ALTER TABLE `pharmaceuticals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`Prescription_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Role_ID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`Sale_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`);

--
-- Indexes for table `sales_item`
--
ALTER TABLE `sales_item`
  ADD PRIMARY KEY (`Sale_Item_ID`),
  ADD KEY `Sale_ID` (`Sale_ID`),
  ADD KEY `Medicine_ID` (`Medicine_ID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`),
  ADD UNIQUE KEY `unique_email` (`Email`),
  ADD UNIQUE KEY `unique_phone` (`Phone`),
  ADD KEY `Role_ID` (`Role_ID`);

--
-- Indexes for table `stock_alert`
--
ALTER TABLE `stock_alert`
  ADD PRIMARY KEY (`Alert_ID`),
  ADD KEY `Inventory_ID` (`Inventory_ID`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `variation`
--
ALTER TABLE `variation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dosage`
--
ALTER TABLE `dosage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generics`
--
ALTER TABLE `generics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Inventory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8552;

--
-- AUTO_INCREMENT for table `medicine_info_api_log`
--
ALTER TABLE `medicine_info_api_log`
  MODIFY `Log_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification_log`
--
ALTER TABLE `notification_log`
  MODIFY `Notification_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ocr_upload`
--
ALTER TABLE `ocr_upload`
  MODIFY `Upload_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_record`
--
ALTER TABLE `patient_record`
  MODIFY `Record_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pharmaceuticals`
--
ALTER TABLE `pharmaceuticals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `Prescription_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `Sale_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales_item`
--
ALTER TABLE `sales_item`
  MODIFY `Sale_Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock_alert`
--
ALTER TABLE `stock_alert`
  MODIFY `Alert_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `Supplier_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variation`
--
ALTER TABLE `variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`Medicine_ID`) REFERENCES `medicines` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`Supplier_ID`) REFERENCES `suppliers` (`Supplier_ID`);

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_ibfk_1` FOREIGN KEY (`generic_id`) REFERENCES `generics` (`id`),
  ADD CONSTRAINT `medicines_ibfk_2` FOREIGN KEY (`pharma_id`) REFERENCES `pharmaceuticals` (`id`);

--
-- Constraints for table `ocr_upload`
--
ALTER TABLE `ocr_upload`
  ADD CONSTRAINT `ocr_upload_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`);

--
-- Constraints for table `patient_record`
--
ALTER TABLE `patient_record`
  ADD CONSTRAINT `patient_record_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `patient_record_ibfk_2` FOREIGN KEY (`Prescription_ID`) REFERENCES `prescription` (`Prescription_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Sale_ID`) REFERENCES `sales` (`Sale_ID`);

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`);

--
-- Constraints for table `sales_item`
--
ALTER TABLE `sales_item`
  ADD CONSTRAINT `sales_item_ibfk_1` FOREIGN KEY (`Sale_ID`) REFERENCES `sales` (`Sale_ID`),
  ADD CONSTRAINT `sales_item_ibfk_2` FOREIGN KEY (`Medicine_ID`) REFERENCES `medicines` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);

--
-- Constraints for table `stock_alert`
--
ALTER TABLE `stock_alert`
  ADD CONSTRAINT `stock_alert_ibfk_1` FOREIGN KEY (`Inventory_ID`) REFERENCES `inventory` (`Inventory_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

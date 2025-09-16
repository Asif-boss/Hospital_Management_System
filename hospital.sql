-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 16, 2025 at 06:10 PM
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
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `date_of_birth`, `gender`, `phone`, `address`, `email`, `blood_group`, `nid`) VALUES
(1, 'Ahmed Khan', '1985-03-15', 'male', '01711234567', '123 Admin Road, Dhaka', 'ahmed.khan@hospital.com', 'B+', '1234567890123'),
(2, 'Fatima Ahmed', '1990-07-22', 'female', '01717654321', '456 Management Street, Dhaka', 'fatima.ahmed@hospital.com', 'O+', '9876543210987'),
(3, 'Rahim Islam', '1988-11-30', 'male', '01811234567', '789 Executive Avenue, Dhaka', 'rahim.islam@hospital.com', 'A+', '4567890123456'),
(4, 'Sadia Chowdhury', '1992-05-14', 'female', '01911234567', '321 Admin Lane, Dhaka', 'sadia.chowdhury@hospital.com', 'AB+', '7890123456789'),
(5, 'Tareq Rahman', '1987-09-08', 'male', '01551234567', '654 Management Road, Dhaka', 'tareq.rahman@hospital.com', 'B-', '2345678901234'),
(8, 'Asif', '1980-01-01', 'male', '01711234588', '100 Admin HQ, Dhaka', 'super.admin@hospital.com', 'O+', '1234567890144');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('scheduled','completed','cancelled','no-show') DEFAULT 'scheduled',
  `reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `status`, `reason`, `notes`, `created_at`) VALUES
(1, 1, 1, '2023-10-15', '10:00:00', 'scheduled', 'Routine checkup', 'Annual physical examination', '2025-09-16 15:58:00'),
(2, 2, 3, '2023-10-16', '11:30:00', 'scheduled', 'Consultation for surgery', 'Discuss knee surgery options', '2025-09-16 15:58:00'),
(3, 3, 2, '2023-10-17', '09:15:00', 'completed', 'Pregnancy checkup', 'Routine prenatal care', '2025-09-16 15:58:00'),
(4, 4, 5, '2023-10-18', '14:00:00', 'scheduled', 'Eye examination', 'Yearly eye check', '2025-09-16 15:58:00'),
(5, 5, 4, '2023-10-19', '10:45:00', 'cancelled', 'Child vaccination', 'Rescheduled for next week', '2025-09-16 15:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `bill_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `services` text NOT NULL,
  `insurance_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`bill_id`, `patient_id`, `appointment_id`, `bill_date`, `amount`, `status`, `services`, `insurance_info`) VALUES
(1, 1, 1, '2023-10-15', 1000.00, 'paid', 'Consultation fee', 'Insurance covered 80%'),
(2, 2, 2, '2023-10-16', 2500.00, 'pending', 'Consultation and diagnostic tests', 'Insurance pre-approved'),
(3, 3, 3, '2023-10-17', 800.00, 'paid', 'Prenatal checkup', 'Fully covered by insurance');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `qualifications` text NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `consultation_fee` decimal(10,2) NOT NULL,
  `available_days` set('sunday','monday','tuesday','wednesday','thursday','friday','saturday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `on_call` tinyint(1) DEFAULT 0,
  `license_number` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `full_name`, `date_of_birth`, `gender`, `phone`, `address`, `qualifications`, `specialty`, `consultation_fee`, `available_days`, `start_time`, `end_time`, `on_call`, `license_number`, `email`, `blood_group`, `nid`) VALUES
(1, 'Dr. Mohammad Ali', '1975-04-12', 'male', '01711234568', '123 Doctor Street, Dhaka', 'MBBS, FCPS (Medicine)', 'Cardiology', 1000.00, 'sunday,monday,tuesday,wednesday,thursday', '09:00:00', '17:00:00', 1, 'DMC-12345', 'dr.ali@hospital.com', 'A+', '1234567890124'),
(2, 'Dr. Salma Khan', '1980-08-25', 'female', '01711234569', '456 Specialist Road, Dhaka', 'MBBS, MD (Gynecology)', 'Gynecology', 800.00, 'sunday,monday,tuesday,wednesday,friday', '10:00:00', '16:00:00', 1, 'DMC-12346', 'dr.khan@hospital.com', 'B+', '1234567890125'),
(3, 'Dr. Rajesh Sharma', '1978-12-05', 'male', '01711234570', '789 Medical Avenue, Dhaka', 'MBBS, MS (Surgery)', 'General Surgery', 1200.00, 'monday,tuesday,wednesday,thursday,friday', '08:00:00', '15:00:00', 0, 'DMC-12347', 'dr.sharma@hospital.com', 'O+', '1234567890126'),
(4, 'Dr. Nusrat Jahan', '1982-03-18', 'female', '01711234571', '321 Doctor Lane, Dhaka', 'MBBS, DCH (Pediatrics)', 'Pediatrics', 700.00, 'sunday,monday,tuesday,thursday,friday', '09:30:00', '16:30:00', 1, 'DMC-12348', 'dr.jahan@hospital.com', 'AB+', '1234567890127'),
(5, 'Dr. Anisur', '1976-07-30', 'male', '01711234572', '654 Specialist Street, Dhaka', 'MBBS, DOMS (Ophthalmology)', 'Ophthalmology', 900.00, '', '10:00:00', '17:00:00', 0, '0', 'dr.rahman@hospital.com', 'A-', '1234567890128'),
(6, 'Dr. Farhana Ahmed', '1983-01-15', 'female', '01711234573', '987 Medical Road, Dhaka', 'MBBS, DDVL (Dermatology)', 'Dermatology', 850.00, 'monday,tuesday,wednesday,thursday,friday', '09:00:00', '16:00:00', 0, 'DMC-12350', 'dr.ahmed@hospital.com', 'B-', '1234567890129'),
(7, 'Dr. Kamal Hossain', '1979-06-22', 'male', '01711234574', '147 Doctor Avenue, Dhaka', 'MBBS, FCPS (Medicine)', 'Internal Medicine', 950.00, 'sunday,monday,tuesday,wednesday,thursday', '08:30:00', '15:30:00', 1, 'DMC-12351', 'dr.hossain@hospital.com', 'O-', '1234567890130'),
(8, 'Dr. Sabina Yasmin', '1981-09-10', 'female', '01711234575', '258 Specialist Lane, Dhaka', 'MBBS, DLO (ENT)', 'ENT', 800.00, 'monday,tuesday,wednesday,thursday,friday', '10:00:00', '17:00:00', 0, 'DMC-12352', 'dr.yasmin@hospital.com', 'AB-', '1234567890131'),
(9, 'Dr. Abdul Malik', '1977-11-28', 'male', '01711234576', '369 Medical Street, Dhaka', 'MBBS, FCPS (Surgery)', 'Orthopedic Surgery', 1100.00, 'sunday,monday,tuesday,thursday,friday', '09:00:00', '16:00:00', 1, 'DMC-12353', 'dr.malik@hospital.com', 'A+', '1234567890132'),
(10, 'Dr. Tasnim Fatima', '1984-02-14', 'female', '01711234577', '741 Doctor Road, Dhaka', 'MBBS, DMRD (Radiology)', 'Radiology', 900.00, 'monday,tuesday,wednesday,thursday,friday', '08:00:00', '15:00:00', 0, 'DMC-12354', 'dr.fatima@hospital.com', 'B+', '1234567890133'),
(11, 'a', '2025-09-10', 'male', '1', 'aa', 'a', 'a', 100.00, 'monday,tuesday', '20:00:00', '00:00:21', 0, ' DMC-12', 'a@c', NULL, NULL),
(12, 'c', '2025-09-02', 'male', '1', 'as', 'as', 'as', 100.00, 'friday,saturday', '08:00:00', '19:00:00', 0, ' DMC-1234566', 'c@c', 'AB+', '1322'),
(13, 'z', '2025-09-03', 'male', '1', '1', '1', '1', 111.00, 'monday,tuesday', '01:00:00', '20:00:00', 0, '1', 'x@a', 'AB-', '1111');

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `drug_id` int(11) NOT NULL,
  `drug_name` varchar(100) DEFAULT NULL,
  `batch_number` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT NULL,
  `minimum_stock` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reorder_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drugs`
--

INSERT INTO `drugs` (`drug_id`, `drug_name`, `batch_number`, `category`, `quantity_in_stock`, `minimum_stock`, `unit_price`, `expiry_date`, `supplier`, `description`, `reorder_level`) VALUES
(1, 'Paracetamol 500mg', 'BATCH001', 'Analgesic', 1000, 100, 0.50, '2024-12-31', 'Pharma Ltd.', 'Pain reliever and fever reducer', 200),
(2, 'Amoxicillin 500mg', 'BATCH002', 'Antibiotic', 500, 50, 2.00, '2024-10-15', 'MediCorp', 'Broad-spectrum antibiotic', 100),
(3, 'Atorvastatin 20mg', 'BATCH003', 'Cardiovascular', 300, 30, 3.50, '2025-03-20', 'CardioPharm', 'Cholesterol-lowering medication', 60),
(4, 'Metformin 500mg', 'BATCH004', 'Diabetes', 400, 40, 1.20, '2024-11-30', 'DiabetoCare', 'Oral anti-diabetic drug', 80),
(5, 'Lisinopril 10mg', 'BATCH005', 'Hypertension', 350, 35, 2.80, '2025-01-15', 'BP Solutions', 'ACE inhibitor for blood pressure', 70),
(6, 'Omeprazole 20mg', 'BATCH006', 'Gastrointestinal', 450, 45, 1.80, '2024-09-30', 'GastroMed', 'Proton pump inhibitor', 90),
(7, 'Amlodipine 5mg', 'BATCH007', 'Cardiovascular', 320, 32, 2.20, '2025-02-28', 'CardioPharm', 'Calcium channel blocker', 64),
(8, 'Metoprolol 50mg', 'BATCH008', 'Cardiovascular', 280, 28, 2.50, '2025-04-10', 'HeartCare', 'Beta blocker for hypertension', 56),
(9, 'Sertraline 50mg', 'BATCH009', 'Psychiatric', 200, 20, 4.00, '2024-08-15', 'Mentis Pharma', 'SSRI antidepressant', 40),
(10, 'Aspirin 100mg', 'BATCH010', 'Cardiovascular', 600, 60, 0.80, '2025-05-20', 'Pharma Ltd.', 'Blood thinner and pain reliever', 120);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(100) DEFAULT NULL,
  `model_number` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT NULL,
  `minimum_stock` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reorder_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_name`, `model_number`, `category`, `quantity_in_stock`, `minimum_stock`, `unit_price`, `purchase_date`, `supplier`, `description`, `reorder_level`) VALUES
(1, 'Ventilator', 'VT-1000', 'Critical Care', 15, 5, 25000.00, '2023-01-15', 'MedEquip Inc.', 'ICU ventilator with advanced features', 3),
(2, 'Defibrillator', 'DF-200', 'Emergency', 10, 3, 12000.00, '2023-02-20', 'LifeSave Medical', 'Portable defibrillator for emergency use', 2),
(3, 'Patient Monitor', 'PM-500', 'Monitoring', 25, 8, 8000.00, '2023-03-10', 'MonitorTech', 'Multi-parameter patient monitor', 5),
(4, 'Infusion Pump', 'IP-300', 'Medication', 30, 10, 4500.00, '2023-04-05', 'FluidCare', 'Electronic infusion pump for precise medication delivery', 6),
(5, 'ECG Machine', 'ECG-75', 'Diagnostic', 12, 4, 9500.00, '2023-05-12', 'CardioTech', '12-lead ECG machine with interpretation', 3),
(6, 'Ultrasound Machine', 'US-4000', 'Diagnostic', 8, 2, 35000.00, '2023-06-18', 'SonoImage', 'Portable ultrasound machine', 2),
(7, 'Anesthesia Machine', 'AM-2000', 'Surgery', 6, 2, 42000.00, '2023-07-22', 'AnesthesiaTech', 'Complete anesthesia delivery system', 1),
(8, 'Sterilizer', 'ST-500', 'Sterilization', 10, 3, 15000.00, '2023-08-30', 'CleanSafe', 'Autoclave sterilizer for instruments', 2),
(9, 'Nebulizer', 'NB-100', 'Respiratory', 20, 6, 1200.00, '2023-09-05', 'BreatheEasy', 'Portable nebulizer for respiratory therapy', 4),
(10, 'Syringe Pump', 'SP-200', 'Medication', 18, 5, 3200.00, '2023-10-10', 'PrecisionDose', 'Syringe pump for accurate medication delivery', 3);

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `record_date` date NOT NULL,
  `diagnosis` text NOT NULL,
  `treatment` text NOT NULL,
  `notes` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `patient_id`, `doctor_id`, `record_date`, `diagnosis`, `treatment`, `notes`, `attachment`) VALUES
(1, 1, 1, '2023-10-15', 'Hypertension', 'Prescribed medication and lifestyle changes', 'Patient advised to reduce salt intake', NULL),
(2, 3, 2, '2023-10-17', 'Normal pregnancy', 'Routine prenatal care', 'Next appointment in 4 weeks', NULL),
(3, 2, 3, '2023-10-16', 'Osteoarthritis of knee', 'Recommended physical therapy and pain management', 'Surgery discussed as option if no improvement', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_relation` varchar(50) DEFAULT NULL,
  `emergency_contact_phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `full_name`, `date_of_birth`, `gender`, `blood_group`, `nid`, `phone`, `address`, `emergency_contact_name`, `emergency_contact_relation`, `emergency_contact_phone`, `email`) VALUES
(1, 'Rafiqul Islam', '1980-05-15', 'Male', 'A+', '1234567890001', '01710000001', '123 Main Street, Dhaka', 'Saleha Begum', 'Wife', '01710000011', 'rafiqul.islam@example.com'),
(2, 'Nusrat Jahan', '1992-08-22', 'Female', 'B+', '1234567890002', '01710000002', '456 Oak Avenue, Dhaka', 'Abdul Karim', 'Father', '01710000012', 'nusrat.jahan@example.com'),
(3, 'Kamal Hossain', '1975-12-10', 'Male', 'O+', '1234567890003', '01710000003', '789 Pine Road, Dhaka', 'Fatema Begum', 'Wife', '01710000013', 'kamal.hossain@example.com'),
(4, 'Sabina Yasmin', '1988-03-30', 'Female', 'AB+', '1234567890004', '01710000004', '321 Elm Street, Dhaka', 'Rahman Ali', 'Husband', '01710000014', 'sabina.yasmin@example.com'),
(5, 'Abdul Malik', '1995-07-18', 'Male', 'A-', '1234567890005', '01710000005', '654 Maple Avenue, Dhaka', 'Rokeya Khatun', 'Mother', '01710000015', 'abdul.malik@example.com'),
(6, 'Taslima Akter', '1983-11-25', 'Female', 'B-', '1234567890006', '01710000006', '987 Cedar Lane, Dhaka', 'Mohammad Ali', 'Husband', '01710000016', 'taslima.akter@example.com'),
(7, 'Farid Ahmed', '1972-02-14', 'Male', 'O-', '1234567890007', '01710000007', '147 Birch Road, Dhaka', 'Ayesha Begum', 'Wife', '01710000017', 'farid.ahmed@example.com'),
(8, 'Jahanara Begum', '1990-09-08', 'Female', 'AB-', '1234567890008', '01710000008', '258 Willow Street, Dhaka', 'Shahidul Islam', 'Husband', '01710000018', 'jahanara.begum@example.com'),
(9, 'Shafiqur Rahman', '1987-06-20', 'Male', 'A+', '1234567890009', '01710000009', '369 Palm Avenue, Dhaka', 'Nargis Akter', 'Wife', '01710000019', 'shafiqur.rahman@example.com'),
(10, 'Nazma Akter', '1998-04-12', 'Female', 'B+', '1234567890010', '01710000010', '741 Oak Lane, Dhaka', 'Abdul Hamid', 'Father', '01710000020', 'nazma.akter@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `ppe`
--

CREATE TABLE `ppe` (
  `ppe_id` int(11) NOT NULL,
  `ppe_name` varchar(100) DEFAULT NULL,
  `batch_number` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT NULL,
  `minimum_stock` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reorder_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ppe`
--

INSERT INTO `ppe` (`ppe_id`, `ppe_name`, `batch_number`, `category`, `quantity_in_stock`, `minimum_stock`, `unit_price`, `expiry_date`, `supplier`, `description`, `reorder_level`) VALUES
(1, 'N95 Mask', 'MASK-N95-001', 'Respiratory Protection', 500, 100, 2.50, '2025-12-31', 'SafeGear Ltd.', 'N95 respirator mask for medical use', 150),
(2, 'Surgical Mask', 'MASK-SURG-002', 'Respiratory Protection', 1000, 200, 0.50, '2025-10-15', 'MediProtect', '3-ply surgical mask', 300),
(3, 'Disposable Gloves', 'GLOVES-003', 'Hand Protection', 2000, 400, 0.30, '2026-05-20', 'SafeHands Inc.', 'Latex-free disposable gloves', 500),
(4, 'Face Shield', 'FSHIELD-004', 'Eye/Face Protection', 200, 50, 3.00, '2025-08-30', 'FaceGuard', 'Disposable face shield', 75),
(5, 'Isolation Gown', 'GOWN-005', 'Body Protection', 300, 60, 5.00, '2025-11-30', 'MediWear', 'Disposable isolation gown', 90),
(6, 'Surgical Cap', 'CAP-006', 'Head Protection', 400, 80, 1.00, '2026-02-28', 'HeadSafe', 'Disposable surgical cap', 120),
(7, 'Shoe Covers', 'SHOE-007', 'Foot Protection', 600, 120, 0.40, '2026-03-15', 'FootProtect', 'Disposable shoe covers', 180),
(8, 'Protective Eyewear', 'EYE-008', 'Eye Protection', 150, 30, 4.50, '2025-09-30', 'EyeShield', 'Reusable protective goggles', 45),
(9, 'Apron', 'APRON-009', 'Body Protection', 250, 50, 3.50, '2025-07-31', 'BodyGuard', 'Disposable plastic apron', 75),
(10, 'Face Mask with Valve', 'MASK-VALVE-010', 'Respiratory Protection', 350, 70, 3.20, '2025-12-15', 'BreatheSafe', 'N95 mask with exhalation valve', 105);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `prescription_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `prescription_date` date NOT NULL,
  `medication` text NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `instructions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`prescription_id`, `appointment_id`, `patient_id`, `doctor_id`, `prescription_date`, `medication`, `dosage`, `duration`, `instructions`) VALUES
(1, 1, 1, 1, '2023-10-15', 'Atorvastatin 20mg', '1 tablet daily', '30 days', 'Take at night with food'),
(2, 3, 3, 2, '2023-10-17', 'Prenatal vitamins', '1 tablet daily', '90 days', 'Take with breakfast'),
(3, 2, 2, 3, '2023-10-16', 'Ibuprofen 400mg', '1 tablet as needed', '10 days', 'Take for pain, not more than 3 times daily');

-- --------------------------------------------------------

--
-- Table structure for table `receptionists`
--

CREATE TABLE `receptionists` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `shift` enum('morning','evening','night') NOT NULL,
  `email` varchar(100) NOT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionists`
--

INSERT INTO `receptionists` (`id`, `full_name`, `date_of_birth`, `gender`, `phone`, `address`, `shift`, `email`, `blood_group`, `nid`) VALUES
(1, 'Ayesha Siddiqua', '1990-04-15', 'female', '01711234578', '123 Front Desk Road, Dhaka', 'morning', 'ayesha.siddiqua@hospital.com', 'O+', '1234567890134'),
(2, 'Mahmud Hasan', '1992-08-22', 'male', '01711234579', '456 Reception Street, Dhaka', 'evening', 'mahmud.hasan@hospital.com', 'A+', '1234567890135'),
(3, 'Nadia Akter', '1993-12-10', 'female', '01711234580', '789 Frontline Avenue, Dhaka', 'night', 'nadia.akter@hospital.com', 'B+', '1234567890136'),
(4, 'Shahriar Ahmed', '1991-03-30', 'male', '01711234581', '321 Desk Lane, Dhaka', 'morning', 'shahriar.ahmed@hospital.com', 'AB+', '1234567890137'),
(5, 'Tania Islam', '1994-07-18', 'female', '01711234582', '654 Reception Road, Dhaka', 'evening', 'tania.islam@hospital.com', 'O-', '1234567890138'),
(6, 'Rifat Khan', '1989-11-25', 'male', '01711234583', '987 Front Desk Street, Dhaka', 'night', 'rifat.khan@hospital.com', 'A-', '1234567890139'),
(7, 'Sanjida Rahman', '1995-02-14', 'female', '01711234584', '147 Reception Avenue, Dhaka', 'morning', 'sanjida.rahman@hospital.com', 'B-', '1234567890140'),
(8, 'Imran Hossain', '1990-09-08', 'male', '01711234585', '258 Desk Road, Dhaka', 'evening', 'imran.hossain@hospital.com', 'AB-', '1234567890141'),
(9, 'Farzana Akter', '1992-06-20', 'female', '01711234586', '369 Frontline Lane, Dhaka', 'night', 'farzana.akter@hospital.com', 'O+', '1234567890142'),
(10, 'Arif Mohammad', '1993-04-12', 'male', '01711234587', '741 Reception Street, Dhaka', 'morning', 'arif.mohammad@hospital.com', 'A+', '1234567890143');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `credentials_license` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `full_name`, `role`, `department`, `phone`, `email`, `credentials_license`) VALUES
(1, 'Rahima Akter', 'Nurse', 'Cardiology', '01711234601', 'rahima.akter@hospital.com', 'RN, BSc Nursing'),
(2, 'Abdul Kader', 'Technician', 'Laboratory', '01711234602', 'abdul.kader@hospital.com', 'MLT Certified'),
(3, 'Fatema Begum', 'Nurse', 'Emergency', '01711234603', 'fatema.begum@hospital.com', 'RN, Emergency Certified'),
(4, 'Shahidul Islam', 'Technician', 'Radiology', '01711234604', 'shahidul.islam@hospital.com', 'Radiology Technician Certified'),
(5, 'Nargis Sultana', 'Nurse', 'ICU', '01711234605', 'nargis.sultana@hospital.com', 'RN, ICU Certified'),
(6, 'Kamrul Hasan', 'Administrator', 'Administration', '01711234606', 'kamrul.hasan@hospital.com', 'MBA Healthcare Management'),
(7, 'Sabina Yasmin', 'Nurse', 'Pediatrics', '01711234607', 'sabina.yasmin@hospital.com', 'RN, Pediatric Nursing'),
(8, 'Rafiqul Islam', 'Technician', 'Pharmacy', '01711234608', 'rafiqul.islam@hospital.com', 'Pharmacy Technician Certified'),
(9, 'Taslima Akter', 'Nurse', 'Surgery', '01711234609', 'taslima.akter@hospital.com', 'RN, Surgical Nursing'),
(10, 'Jamal Uddin', 'Support Staff', 'Housekeeping', '01711234610', 'jamal.uddin@hospital.com', 'Housekeeping Certified');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `supply_id` int(11) NOT NULL,
  `supply_name` varchar(100) DEFAULT NULL,
  `batch_number` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT NULL,
  `minimum_stock` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reorder_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`supply_id`, `supply_name`, `batch_number`, `category`, `quantity_in_stock`, `minimum_stock`, `unit_price`, `expiry_date`, `supplier`, `description`, `reorder_level`) VALUES
(1, 'Syringe 5ml', 'SYR-5ML-001', 'Disposable', 1000, 200, 0.20, '2025-12-31', 'MediSupplies Ltd.', 'Disposable 5ml syringe', 300),
(2, 'Gauze Pad', 'GAUZE-002', 'Wound Care', 500, 100, 0.15, '2026-05-15', 'WoundCare Inc.', 'Sterile gauze pad 4x4 inches', 150),
(3, 'Medical Tape', 'TAPE-003', 'Wound Care', 300, 60, 1.50, '2026-03-20', 'MediTape', 'Hypoallergenic medical tape', 90),
(4, 'Bandage', 'BAND-004', 'Wound Care', 400, 80, 0.80, '2026-02-28', 'BandageCo', 'Elastic bandage 4 inches', 120),
(5, 'Cotton Swabs', 'COTTON-005', 'Disposable', 800, 160, 0.10, '2026-08-31', 'CleanMed', 'Sterile cotton swabs', 240),
(6, 'Disposable Needles', 'NEEDLE-006', 'Disposable', 600, 120, 0.25, '2025-11-30', 'SharpPoint', 'Disposable hypodermic needles', 180),
(7, 'IV Catheter', 'IV-007', 'IV Supplies', 350, 70, 1.20, '2025-10-15', 'IVTech', 'IV catheter size 18G', 105),
(8, 'Alcohol Swabs', 'ALC-008', 'Disposable', 1200, 240, 0.05, '2026-01-31', 'CleanCare', 'Alcohol prep swabs', 360),
(9, 'Tourniquet', 'TOUR-009', 'IV Supplies', 200, 40, 2.50, '2027-12-31', 'MediGrip', 'Reusable tourniquet', 60),
(10, 'Glucose Test Strip', 'GLUC-010', 'Diagnostic', 500, 100, 1.00, '2025-09-30', 'DiabetoCheck', 'Blood glucose test strips', 150);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('patient','doctor','admin','super_admin','receptionist') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_type`, `profile_picture`) VALUES
(1, 'rafiqul.islam@example.com', '123456', 'patient', NULL),
(2, 'nusrat.jahan@example.com', '123456', 'patient', NULL),
(3, 'kamal.hossain@example.com', '123456', 'patient', NULL),
(4, 'sabina.yasmin@example.com', '123456', 'patient', NULL),
(5, 'abdul.malik@example.com', '123456', 'patient', NULL),
(6, 'taslima.akter@example.com', '123456', 'patient', NULL),
(7, 'farid.ahmed@example.com', '123456', 'patient', NULL),
(8, 'jahanara.begum@example.com', '123456', 'patient', NULL),
(9, 'shafiqur.rahman@example.com', '123456', 'patient', NULL),
(10, 'nazma.akter@example.com', '123456', 'patient', NULL),
(11, 'dr.ali@hospital.com', '123456', 'doctor', '11.png'),
(12, 'dr.khan@hospital.com', '123456', 'doctor', NULL),
(13, 'dr.sharma@hospital.com', '123456', 'doctor', NULL),
(14, 'dr.jahan@hospital.com', '123456', 'doctor', NULL),
(15, 'dr.rahman@hospital.com', '123456', 'doctor', NULL),
(16, 'dr.ahmed@hospital.com', '123456', 'doctor', NULL),
(17, 'dr.hossain@hospital.com', '123456', 'doctor', NULL),
(18, 'dr.yasmin@hospital.com', '123456', 'doctor', NULL),
(19, 'dr.malik@hospital.com', '123456', 'doctor', NULL),
(20, 'dr.fatima@hospital.com', '123456', 'doctor', NULL),
(21, 'ahmed.khan@hospital.com', '123456', 'admin', NULL),
(22, 'fatima.ahmed@hospital.com', '123456', 'admin', NULL),
(23, 'rahim.islam@hospital.com', '123456', 'admin', NULL),
(24, 'sadia.chowdhury@hospital.com', '123456', 'admin', NULL),
(25, 'tareq.rahman@hospital.com', '123456', 'admin', NULL),
(26, 'super.admin@hospital.com', '123456', 'super_admin', NULL),
(27, 'ayesha.siddiqua@hospital.com', '123456', 'receptionist', NULL),
(28, 'mahmud.hasan@hospital.com', '123456', 'receptionist', NULL),
(29, 'nadia.akter@hospital.com', '123456', 'receptionist', NULL),
(30, 'shahriar.ahmed@hospital.com', '123456', 'receptionist', NULL),
(31, 'tania.islam@hospital.com', '123456', 'receptionist', NULL),
(32, 'rifat.khan@hospital.com', '123456', 'receptionist', NULL),
(33, 'sanjida.rahman@hospital.com', '123456', 'receptionist', NULL),
(34, 'imran.hossain@hospital.com', '123456', 'receptionist', NULL),
(35, 'farzana.akter@hospital.com', '123456', 'receptionist', NULL),
(36, 'arif.mohammad@hospital.com', '123456', 'receptionist', NULL),
(37, 'a@a', '$2y$10$5bAfCz1OfjXJY3BdelAfPOCEQstiwzcMA55JI4zQqf0uxfSs665Qy', 'doctor', NULL),
(42, 'c@c', '14', 'doctor', NULL),
(44, 'x@a', '1', 'doctor', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license_number` (`license_number`),
  ADD UNIQUE KEY `email_address` (`email`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email`);

--
-- Indexes for table `ppe`
--
ALTER TABLE `ppe`
  ADD PRIMARY KEY (`ppe_id`);

--
-- Indexes for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`supply_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `drugs`
  MODIFY `drug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ppe`
--
ALTER TABLE `ppe`
  MODIFY `ppe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `receptionists`
--
ALTER TABLE `receptionists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

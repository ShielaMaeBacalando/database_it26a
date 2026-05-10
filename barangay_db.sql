
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resident`
--

CREATE TABLE `tbl_resident` (
  `tbl_resident_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_resident`
--

INSERT INTO `tbl_resident` (`tbl_resident_id`, `full_name`, `address`, `contact_number`) VALUES
(1, 'Jermaine Mcintyre', 'Purok 1', '(551) 577-2147'),
(2, 'Sybil Holloway', 'Purok 6', '(264) 641-0232'),
(3, 'Fuller Ellison', 'Purok 5', '(396) 499-3631'),
(4, 'Lysandra Perry', 'Purok 2', '1-444-109-5363'),
(5, 'Warren Acevedo', 'Purok 5', '1-967-248-3007'),
(6, 'Zachary Parsons', 'Purok 4', '1-868-847-2561'),
(7, 'Yen Reed', 'Purok 2', '(853) 796-1464'),
(8, 'Yetta Cobb', 'Purok 3', '1-274-451-4766'),
(9, 'Derek Frank', 'Purok 5', '1-535-343-5554'),
(10, 'Slade Vaughn', 'Purok 5', '1-731-861-0264'),
(11, 'Virginia Boone', 'Purok 3', '(311) 289-2423'),
(12, 'Brandon Webster', 'Purok 4', '(904) 310-5897'),
(13, 'Catherine Coffey', 'Purok 2', '(386) 264-4656'),
(14, 'Hammett Hicks', 'Purok 1', '1-682-997-3392'),
(15, 'Imani Lopez', 'Purok 4', '(286) 441-4362'),
(16, 'Lacota Gibbs', 'Purok 3', '1-773-584-9163'),
(17, 'Forrest Santos', 'Purok 5', '1-382-654-1157'),
(18, 'Michael Bryan', 'Purok 5', '1-342-771-5555'),
(19, 'Fallon Watson', 'Purok 5', '1-333-917-8233'),
(20, 'Harlan Nicholson', 'Purok 1', '(298) 185-7637'),
(21, 'Miranda Hodges', 'Purok 4', '1-824-492-5379'),
(22, 'Lucy Swanson', 'Purok 3', '1-834-204-4489'),
(23, 'Sylvia Morris', 'Purok 2', '(435) 716-3332'),
(24, 'Lillian Weaver', 'Purok 6', '(129) 923-6651'),
(25, 'Idola Edwards', 'Purok 1', '(532) 925-3997'),
(26, 'Omar Patterson', 'Purok 4', '(752) 477-9330'),
(27, 'Ocean Ferguson', 'Purok 3', '(668) 469-2468'),
(28, 'Portia Bowman', 'Purok 1', '1-447-701-1121'),
(29, 'Hilda Hodges', 'Purok 2', '1-391-538-1741'),
(30, 'Jayme Bell', 'Purok 1', '(677) 832-1726');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_resident`
--
ALTER TABLE `tbl_resident`
  ADD PRIMARY KEY (`tbl_resident_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_resident`
--
ALTER TABLE `tbl_resident`
  MODIFY `tbl_resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

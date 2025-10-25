-- --------------------------------------------------------
--
-- Table structure for table `revenues`
--

CREATE TABLE `revenues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `counselor_id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_mode` enum('Cash','UPI','Card','Net Banking','Cheque','Other') DEFAULT 'Cash',
  `transaction_id` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `course_type` varchar(255) DEFAULT NULL,
  `payment_type` enum('Registration Fee','Course Fee','Installment','Material Fee','Exam Fee','Other') DEFAULT 'Course Fee',
  `installment_number` int(11) DEFAULT NULL,
  `total_installments` int(11) DEFAULT NULL,
  `discount_applied` decimal(10,2) DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled','Refunded') DEFAULT 'Confirmed',
  `collected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `revenues`
--
ALTER TABLE `revenues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_counselor_id` (`counselor_id`),
  ADD KEY `idx_lead_id` (`lead_id`),
  ADD KEY `idx_date` (`date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_payment_type` (`payment_type`),
  ADD KEY `idx_collected_by` (`collected_by`),
  ADD KEY `idx_verified_by` (`verified_by`),
  ADD KEY `idx_counselor_date` (`counselor_id`,`date`),
  ADD KEY `idx_receipt_number` (`receipt_number`);

--
-- AUTO_INCREMENT for table `revenues`
--
ALTER TABLE `revenues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `revenues`
--
ALTER TABLE `revenues`
  ADD CONSTRAINT `fk_revenues_counselor` FOREIGN KEY (`counselor_id`) REFERENCES `counselors` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `fk_revenues_lead` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_revenues_collected_by` FOREIGN KEY (`collected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_revenues_verified_by` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

COMMIT;

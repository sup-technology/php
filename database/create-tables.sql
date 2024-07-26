DROP TABLE `suptech-php`.`categories`;


CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE `suptech-php`.`comments`;


CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE `suptech-php`.`likes`;


CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE `suptech-php`.`questions`;


CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE `suptech-php`.`users`;


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `suptech-php`.`categories` (`id`, `name`, `created_at`, `updated_at`) VALUES 
(21, 'Technology', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(22, 'Health', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(23, 'Travel', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(24, 'Education', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(25, 'Food', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(26, 'Finance', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(27, 'Lifestyle', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(28, 'Sports', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(29, 'Entertainment', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(30, 'Fashion', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(31, 'Science', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(32, 'Automotive', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(33, 'Real Estate', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(34, 'Pets', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(35, 'Home Improvement', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(36, 'Gaming', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(37, 'Parenting', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(38, 'Business', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(39, 'Photography', '2024-07-26 21:17:56', '2024-07-26 21:17:56'),
(40, 'Music', '2024-07-26 21:17:56', '2024-07-26 21:17:56');

INSERT INTO `suptech-php`.`comments` (`id`, `question_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES 
(7, 19, 5, 'AI is rapidly advancing with new models and applications.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(8, 19, 6, 'Check out the latest AI conferences for more updates.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(9, 19, 5, 'Also, consider following key AI researchers on Twitter.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(10, 20, 5, 'Maintaining a healthy diet involves balanced nutrition.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(11, 20, 6, 'Include plenty of fruits and vegetables in your meals.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(12, 20, 5, 'Don’t forget to stay hydrated and exercise regularly.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(13, 21, 5, 'Solo travel is amazing! Consider Japan or New Zealand.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(14, 21, 6, 'I had a great solo trip to Iceland last year.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(15, 21, 5, 'Southeast Asia is also very friendly for solo travelers.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(16, 22, 5, 'Set a dedicated study space and follow a schedule.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(17, 22, 6, 'Take regular breaks to avoid burnout during online learning.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(18, 22, 5, 'Use online tools like Trello to keep track of your tasks.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(19, 23, 5, 'Quick and healthy recipes often include salads and stir-fries.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(20, 23, 6, 'Try making overnight oats for a quick breakfast.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(21, 23, 5, 'Smoothies are also a great healthy option.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(22, 24, 5, 'Start with a budget and track your expenses.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(23, 24, 6, 'Automate your savings to ensure you save regularly.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(24, 24, 5, 'Look for high-interest savings accounts.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(25, 25, 5, 'Minimalist decor is very trendy right now.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(26, 25, 6, 'Consider using neutral colors for a modern look.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(27, 25, 5, 'Plants can add a fresh touch to your home decor.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(28, 26, 5, 'Start with simple exercises like walking or jogging.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(29, 26, 6, 'Consistency is key in any fitness routine.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(30, 26, 5, 'Don’t forget to warm up before and cool down after your workouts.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(31, 27, 5, 'The latest console has great reviews for its graphics.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(32, 27, 6, 'Check out the new RPG game, it’s very popular.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(33, 27, 5, 'Multiplayer games are also a lot of fun on the new console.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(34, 28, 5, 'Use a tripod to stabilize your camera for landscape shots.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(35, 28, 6, 'Golden hour lighting can make a big difference in your photos.', '2024-07-26 21:25:20', '2024-07-26 21:25:20'),
(36, 28, 5, 'Experiment with different angles to find the best composition.', '2024-07-26 21:25:20', '2024-07-26 21:25:20');

INSERT INTO `suptech-php`.`likes` (`id`, `question_id`, `user_id`, `created_at`) VALUES 
(66, 19, 5, '2024-07-26 21:24:20'),
(67, 19, 6, '2024-07-26 21:24:20'),
(68, 20, 5, '2024-07-26 21:24:20'),
(69, 20, 6, '2024-07-26 21:24:20'),
(70, 21, 5, '2024-07-26 21:24:20'),
(71, 21, 6, '2024-07-26 21:24:20'),
(72, 22, 5, '2024-07-26 21:24:20'),
(73, 22, 6, '2024-07-26 21:24:20'),
(74, 23, 5, '2024-07-26 21:24:20'),
(75, 23, 6, '2024-07-26 21:24:20'),
(76, 24, 5, '2024-07-26 21:24:20'),
(77, 24, 6, '2024-07-26 21:24:20'),
(78, 25, 5, '2024-07-26 21:24:20'),
(79, 25, 6, '2024-07-26 21:24:20'),
(80, 26, 5, '2024-07-26 21:24:20'),
(81, 26, 6, '2024-07-26 21:24:20'),
(82, 27, 5, '2024-07-26 21:24:20'),
(83, 27, 6, '2024-07-26 21:24:20'),
(84, 28, 5, '2024-07-26 21:24:20'),
(85, 28, 6, '2024-07-26 21:24:20');

INSERT INTO `suptech-php`.`questions` (`id`, `title`, `content`, `category_id`, `user_id`, `created_at`, `updated_at`) VALUES 
(19, 'What is the latest trend in AI?', 'I am curious about the latest advancements in artificial intelligence.', 24, 5, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(20, 'How to maintain a healthy diet?', 'Looking for tips on maintaining a balanced and healthy diet.', 25, 5, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(21, 'Best destinations for solo travelers?', 'Can anyone recommend good places for solo travel?', 26, 5, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(22, 'Tips for online learning success?', 'What are some effective strategies for successful online learning?', 27, 5, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(23, 'What are some quick and healthy recipes?', 'I need ideas for quick, healthy meals.', 28, 5, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(24, 'How to save money effectively?', 'What are some effective ways to save money?', 29, 6, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(25, 'Latest trends in home decor?', 'I want to update my home decor, what are the latest trends?', 30, 6, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(26, 'How to get started with fitness?', 'Looking for beginner fitness tips and routines.', 31, 6, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(27, 'Best games for the new gaming console?', 'What are the best games to play on the latest gaming console?', 32, 6, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(28, 'How to take great landscape photos?', 'I want to improve my landscape photography, any tips?', 33, 6, '2024-07-26 21:22:33', '2024-07-26 21:22:33'),
(29, 'what is laravel ', 'content for laravel ', 24, 5, '2024-07-26 21:26:05', '2024-07-26 21:26:05');

INSERT INTO `suptech-php`.`users` (`id`, `username`, `email`, `password`, `category_id`, `created_at`, `updated_at`) VALUES 
(5, 'mostafa', 'mostafaaminea@gmail.com', '$2y$10$RwmO4uXvxVfRGhx2ehGIX.TuR/3FN8nKPAiwLGU1YYf7sFsQWieHS', 23, '2024-07-26 21:20:14', '2024-07-26 21:20:14'),
(6, 'ahmed', 'ahmed@gmail.com', '$2y$10$RwmO4uXvxVfRGhx2ehGIX.TuR/3FN8nKPAiwLGU1YYf7sFsQWieHS', 24, '2024-07-26 21:20:14', '2024-07-26 21:20:14');

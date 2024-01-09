
--
-- Database: `blog`
--


CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(122) NOT NULL,
  `email` varchar(122) NOT NULL,
  `subject` varchar(122) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(122) NOT NULL,
  `created_at` date NOT NULL,
  `status` int(11) NOT NULL
);


CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(122) NOT NULL,
  `title_fr` varchar(122) NOT NULL,
  `description` text NOT NULL,
  `description_fr` text NOT NULL,
  `image` varchar(122) NOT NULL,
  `created_at` date NOT NULL,
  `slug` varchar(122) NOT NULL
);



CREATE TABLE `post_tags` (
  `tag_id` int(11) NOT NULL ,
  `post_id` int(11) NOT NULL
);



CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tag` varchar(122) NOT NULL
); 


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(122) NOT NULL,
  `password` varchar(122) NOT NULL
);



-- dump data into the database 

INSERT INTO `posts` (`id`, `title`,`title_fr` , `description`,`description_fr`, `image`, `created_at`, `slug`) VALUES

(1, 'The Evolution of Programming Languages: From Pioneers to Modern Innovations',"L'évolution des langages de programmation : Des pionniers aux innovations modernes" ,  "Programming languages have been the cornerstone of technological advancement since the mid-20th century. From the early days of machine code and assembly languages to the vast array of high-level languages today, the evolution of programming has been nothing short of remarkable.

The journey begins with the pioneering work of computer scientists like Grace Hopper and John McCarthy. Hopper's creation of the first compiler, A-0, laid the groundwork for higher-level languages. McCarthy introduced LISP, one of the earliest high-level languages, emphasizing the power of symbolic processing.

The 1970s witnessed the birth of languages that are still influential today. C, developed by Dennis Ritchie, revolutionized systems programming with its efficiency and portability. Simultaneously, Bjarne Stroustrup introduced C++, a language that combined the power of C with object-oriented programming.

The late 20th century and early 21st century saw an explosion of languages catering to diverse needs. Python emerged as a versatile language, renowned for its readability and simplicity. JavaScript became ubiquitous, enabling dynamic and interactive web experiences. Meanwhile, functional programming gained traction with languages like Haskell and Scala.

Today, languages continue to evolve to meet modern challenges. Go, created by Google, emphasizes simplicity and efficiency for concurrent operations. Rust focuses on safety and performance, addressing memory safety issues prevalent in low-level languages.

The future promises even more exciting developments. Quantum computing languages like Q# are emerging to tackle the complexities of quantum algorithms. Languages designed for machine learning and AI, such as TensorFlow and PyTorch, are enabling groundbreaking innovations.

As technology advances, programming languages will keep evolving, shaping the future of innovation and problem-solving across various domains.","Les langages de programmation ont été le fondement de l'avancée technologique depuis le milieu du XXe siècle. Des premiers jours du code machine et des langages d'assemblage à la vaste gamme de langages de haut niveau d'aujourd'hui, l'évolution de la programmation a été remarquable.

Le voyage commence avec le travail novateur de scientifiques de l'informatique comme Grace Hopper et John McCarthy. La création par Hopper du premier compilateur, A-0, a posé les bases des langages de niveau supérieur. McCarthy a introduit LISP, l'un des premiers langages de haut niveau, mettant en avant la puissance du traitement symbolique.

Les années 1970 ont vu naître des langages qui ont toujours une influence aujourd'hui. C, développé par Dennis Ritchie, a révolutionné la programmation système par son efficacité et sa portabilité. Simultanément, Bjarne Stroustrup a introduit C++, un langage qui a combiné la puissance de C avec la programmation orientée objet.

La fin du XXe siècle et le début du XXIe siècle ont vu une explosion de langages répondant à des besoins divers. Python est devenu un langage polyvalent, reconnu pour sa lisibilité et sa simplicité. JavaScript est devenu omniprésent, permettant des expériences web dynamiques et interactives. Pendant ce temps, la programmation fonctionnelle a gagné du terrain avec des langages comme Haskell et Scala.

Aujourd'hui, les langages continuent d'évoluer pour relever les défis modernes. Go, créé par Google, met l'accent sur la simplicité et l'efficacité pour les opérations concurrentes. Rust se concentre sur la sécurité et les performances, abordant les problèmes de sécurité de la mémoire répandus dans les langages de bas niveau.

L'avenir promet encore plus de développements passionnants. Des langages pour l'informatique quantique comme Q# émergent pour s'attaquer aux complexités des algorithmes quantiques. Des langages conçus pour l'apprentissage automatique et l'IA, tels que TensorFlow et PyTorch, permettent des innovations révolutionnaires.

À mesure que la technologie progresse, les langages de programmation continueront d'évoluer, façonnant l'avenir de l'innovation et de la résolution de problèmes dans divers domaines.


" ,'programmation.jpeg', '2023-02-18', 'The-Evolution-of-Programming-Languages');

INSERT INTO `comments` (`id`, `name`, `email`, `subject`, `description`, `slug`, `created_at`, `status`) VALUES
(1, 'John', 'Jdoe@gmail.com', 'programmation', 'nice article', 'The-Evolution-of-Programming-Languages', '2023-02-20', 1);


INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'wildlife'),
(2, 'programming'),
(3, 'nature'),
(4, 'fashion');


INSERT INTO `post_tags` (`tag_id`, `post_id`) VALUES(1, 1);


INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'john', '6e0b7076126a29d5dfcbd54835387b7b');



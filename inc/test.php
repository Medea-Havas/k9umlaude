<?php

/**
 * Template Name: Test
 *
 * @subpackage k9umlaude
 */
$context = Timber::get_context();

$questions = array(
  'post_type' => 'test'
);
$allQuestions = Timber::get_posts($questions);

$random_number_array = range(0, count($allQuestions) - 1);
shuffle($random_number_array);
$random_number_array = array_slice($random_number_array, 0, 30);

$finalQuestions = [];
foreach ($random_number_array as $key => $value) {
  $finalQuestion = [];
  $finalQuestion['id'] = $allQuestions[$value]->id;
  $finalQuestion['question'] = $key + 1 . '. ' . $allQuestions[$value]->question;
  $finalQuestion['title'] = $allQuestions[$value]->post_title;
  $finalQuestion['answer01'] = $allQuestions[$value]->answer_01;
  $finalQuestion['answer02'] = $allQuestions[$value]->answer_2;
  $finalQuestion['answer03'] = $allQuestions[$value]->answer_3;
  $finalQuestion['answer04'] = $allQuestions[$value]->answer_4;
  $finalQuestion['right_answer'] = intval($allQuestions[$value]->right_answer) * 3 / 2;
  array_push($finalQuestions, $finalQuestion);
}

$context['questions'] = $finalQuestions;

Timber::render('test.twig', $context);

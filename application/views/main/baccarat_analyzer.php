<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $page_title; ?></title>
  <link href="<?php echo base_url('assets/css/tailwind.css'); ?>" rel="stylesheet">
</head>

<body
  class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
  <div class="p-8 text-center bg-white rounded-lg shadow-xl text-gray-900 max-w-2xl w-full">
    <h1 class="text-4xl font-extrabold mb-4 animate-pulse">✨ 바카라 분석기 ✨</h1>
    <p class="text-lg mb-6">레벨 2 회원님을 위한 특별 서비스입니다.</p>
    <div class="bg-gray-50 p-6 rounded-lg shadow-inner mb-6">
      <h3 class="text-2xl font-semibold mb-3 text-gray-800">분석 시작하기</h3>
      <p class="text-gray-700 mb-4">여기에 바카라 게임 패턴 분석 및 예측 로직을 제공합니다.</p>
      <button
        class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-full shadow-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
        분석 시작!
      </button>
    </div>
    <p class="text-sm text-gray-600 mb-4">더 많은 기능은 다음 업데이트에서 만나보세요!</p>
    <a href="<?php echo base_url('logout'); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium">로그아웃</a>
  </div>
</body>

</html>
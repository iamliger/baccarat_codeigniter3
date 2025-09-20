<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>승인 대기</title>
  <link href="<?php echo base_url('assets/css/tailwind.css'); ?>" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md text-center">
    <h2 class="text-2xl font-bold text-gray-900">계정 승인 대기 중</h2>
    <p class="text-gray-600">회원님의 계정은 관리자의 승인을 기다리고 있습니다.</p>
    <p class="text-gray-600">승인 완료 시 모든 서비스를 이용하실 수 있습니다.</p>
    <p class="text-gray-600">감사합니다.</p>
    <div class="mt-6">
      <a href="<?php echo base_url('logout'); ?>"
        class="w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        로그아웃
      </a>
    </div>
  </div>
</body>

</html>
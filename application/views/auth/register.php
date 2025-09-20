<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>회원가입</title>
  <link href="<?php echo base_url('assets/css/tailwind.css'); ?>" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-900">회원가입</h2>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
      <?php echo $this->session->flashdata('error'); ?>
    </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
    <div class="p-3 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
      <?php echo $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>

    <?php echo form_open('register', ['class' => 'space-y-4']); ?>
    <div>
      <label for="memberid" class="block text-sm font-medium text-gray-700">아이디</label>
      <input type="text" name="memberid" id="memberid" value="<?php echo set_value('memberid'); ?>" required
        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      <p class="text-sm text-gray-500 mt-1">영문, 숫자, '_', '-'만 사용 가능합니다.</p>
    </div>
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">이메일</label>
      <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required
        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">비밀번호</label>
      <input type="password" name="password" id="password" required
        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      <p class="text-sm text-gray-500 mt-1">
        비밀번호는 최소 <?php echo $min_password_length; ?>자 이상이어야 합니다.
        <?php if ($requires_uppercase): ?>대문자 1개 이상, <?php endif; ?>
        <?php if ($requires_lowercase): ?>소문자 1개 이상, <?php endif; ?>
        <?php if ($requires_number): ?>숫자 1개 이상, <?php endif; ?>
        <?php if ($requires_special): ?>특수문자 1개 이상 <?php endif; ?>
        포함.
      </p>
    </div>
    <div>
      <label for="passconf" class="block text-sm font-medium text-gray-700">비밀번호 확인</label>
      <input type="password" name="passconf" id="passconf" required
        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
      <button type="submit"
        class="w-full px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        회원가입
      </button>
    </div>
    <div class="text-center">
      <a href="<?php echo base_url('login'); ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">이미
        계정이 있으신가요? 로그인</a>
    </div>
    <?php echo form_close(); ?>
  </div>
</body>

</html>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>로그인</title>
  <link href="<?php echo base_url('assets/css/tailwind.css'); ?>" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-900">로그인</h2>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
      <?php echo $this->session->flashdata('error'); ?>
    </div>
    <?php endif; ?>

    <?php echo form_open('login', ['class' => 'space-y-4']); ?>
    <div>
      <label for="credential"
        class="block text-sm font-medium text-gray-700"><?php echo htmlspecialchars($credential_label); ?></label>
      <input type="text" name="credential" id="credential" value="<?php echo set_value('credential'); ?>" required
        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      <?php if ($login_mode === 'both'): ?>
      <p class="text-sm text-gray-500 mt-1">아이디 또는 이메일 주소를 입력해주세요.</p>
      <?php endif; ?>
    </div>
    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">비밀번호</label>
      <input type="password" name="password" id="password" required
        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>
    <div>
      <button type="submit"
        class="w-full px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        로그인
      </button>
    </div>
    <?php echo form_close(); ?>
  </div>
</body>

</html>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

$lang['email_must_be_array'] = '이메일 검증 방법은 배열을 전달받아야 합니다.';
$lang['email_invalid_address'] = '유효하지 않은 이메일 주소입니다: %s';
$lang['email_attachment_missing'] = '다음 이메일 첨부를 찾을 수 없습니다: %s';
$lang['email_attachment_unreadable'] = '이 첨부 파일을 열 수 없습니다: %s';
$lang['email_no_from'] = 'From 헤더 없이 메일을 보낼 수 없습니다.';
$lang['email_no_recipients'] = '받는 사람(To, Cc, Bcc)을 포함해야 합니다.';
$lang['email_send_failure_phpmail'] = 'PHP mail()을 사용하여 이메일을 보낼 수 없습니다. 서버가 이 방법으로 메일을 보내도록 구성되지 않았을 수 있습니다.';
$lang['email_send_failure_sendmail'] = 'PHP Sendmail을 사용하여 이메일을 보낼 수 없습니다. 서버가 이 방법으로 메일을 보내도록 구성되지 않았을 수 있습니다.';
$lang['email_send_failure_smtp'] = 'PHP SMTP를 사용하여 이메일을 보낼 수 없습니다. 서버가 이 방법으로 메일을 보내도록 구성되지 않았을 수 있습니다.';
$lang['email_sent'] = '다음 프로토콜을 사용하여 메시지가 성공적으로 전송되었습니다: %s';
$lang['email_no_socket'] = 'Sendmail 소켓을 열 수 없습니다. 설정을 확인해 주세요.';
$lang['email_no_hostname'] = 'SMTP 호스트 이름을 지정하지 않았습니다.';
$lang['email_smtp_error'] = '다음 SMTP 오류가 발생했습니다: %s';
$lang['email_no_smtp_unpw'] = '오류: SMTP 사용자 이름과 비밀번호를 할당해야 합니다.';
$lang['email_failed_smtp_login'] = 'AUTH LOGIN 명령을 보내는 데 실패했습니다. 오류: %s';
$lang['email_smtp_auth_un'] = '사용자 이름 인증을 실패했습니다. 오류: %s';
$lang['email_smtp_auth_pw'] = '비밀번호 인증을 실패했습니다. 오류: %s';
$lang['email_smtp_data_failure'] = '데이터를 보낼 수 없습니다: %s';
$lang['email_exit_status'] = '종료 상태 코드: %s';

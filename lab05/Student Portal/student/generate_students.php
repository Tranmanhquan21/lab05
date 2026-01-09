<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/data.php'; // sửa đường dẫn

$students = [
    ["student_code"=>"SV001","full_name"=>"Nguyen Van A","class_name"=>"DCCNTT13","email"=>"a@example.com","password_hash"=>password_hash("123456",PASSWORD_DEFAULT)],
    ["student_code"=>"SV002","full_name"=>"Nguyen Van B","class_name"=>"DCCNTT13","email"=>"b@example.com","password_hash"=>password_hash("123456",PASSWORD_DEFAULT)],
    ["student_code"=>"SV003","full_name"=>"Nguyen Van C","class_name"=>"DCCNTT13","email"=>"c@example.com","password_hash"=>password_hash("123456",PASSWORD_DEFAULT)],
    ["student_code"=>"SV004","full_name"=>"Nguyen Van D","class_name"=>"DCCNTT13","email"=>"d@example.com","password_hash"=>password_hash("123456",PASSWORD_DEFAULT)]
];

write_json('students.json', $students);

echo "Đã tạo students.json trong folder data/ với mật khẩu mặc định 123456.";

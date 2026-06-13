<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password Akun Alumni</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .header { background-color: #1B3A52; color: #fff; padding: 10px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 0.8em; color: #777; text-align: center; margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; }
        .credentials { background-color: #f9f9f9; padding: 15px; border-left: 4px solid #1B3A52; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SD Muhammadiyah Birrul Walidain</h2>
        </div>
        
        <div class="content">
            <p>Halo, <strong>{{ $alumniName }}</strong>,</p>
            
            <p>Password untuk akun Sistem Informasi Alumni Anda telah berhasil direset oleh Administrator. Berikut adalah informasi login terbaru Anda:</p>
            
            <div class="credentials">
                <p><strong>Username (NISN):</strong> {{ $username }}</p>
                <p><strong>Password Baru:</strong> {{ $newPassword }}</p>
            </div>
            
            <p>Silakan segera login menggunakan kredensial di atas. <strong>Sistem akan mewajibkan Anda untuk mengganti password ini</strong> dengan password pilihan Anda sendiri setelah berhasil login pertama kali demi alasan keamanan.</p>
            
            <p>Jika Anda tidak merasa mengajukan permintaan ini atau membutuhkan bantuan lebih lanjut, silakan hubungi pihak sekolah.</p>
            
            <p>Salam,<br>Administrator SD Muhammadiyah Birrul Walidain</p>
        </div>
        
        <div class="footer">
            <p>Email ini dihasilkan secara otomatis oleh Sistem Informasi Alumni SD Muhammadiyah Birrul Walidain Kudus. Harap tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>

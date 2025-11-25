// LƯU Ý: Đuôi file là .cjs để sử dụng cú pháp require (CommonJS)
const express = require('express');
const bodyParser = require('body-parser');
const nodemailer = require('nodemailer'); 
const cors = require('cors');

const app = express();
const port = 3001; // Nodemailer Server

// Cấu hình Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// ===================================================================
// 🛠️ PHẦN CẤU HÌNH EMAIL (Sử dụng SMTP Chi tiết và Tài khoản Mới) 🛠️
// ===================================================================

const transporter = nodemailer.createTransport({
    // Sử dụng cấu hình SMTP chi tiết của Gmail để tăng ổn định
    host: 'smtp.gmail.com',
    port: 465,
    secure: true, // true cho cổng 465
    auth: {
        user: 'dinhtu20091998@gmail.com', // ⬅️ Tài khoản mới
        pass: 'vcpoanqqtsesrgxg'          // ⬅️ Mật khẩu ứng dụng mới
    }
});

// Địa chỉ email cá nhân của bạn (người nhận thông báo)
const MY_PERSONAL_EMAIL = 'tuanprosupe@gmail.com'; 

// ===================================================================

// 📝 Route để xử lý Form Submission POST: /messages
app.post('/messages', async (req, res) => {
    // Trích xuất dữ liệu từ body của request
    const { name, email, subject, message, timestamp } = req.body;

    if (!name || !email || !subject || !message) {
        return res.status(400).json({ error: 'Vui lòng điền đầy đủ tất cả các trường.' });
    }

    // --- 1. Thực hiện Lưu vào Database (Giả định) ---
    console.log(`[DB] Lưu thông tin từ ${name} (${email}) vào database.`);


    // --- 2. Cấu hình Email gửi về email cá nhân của bạn (Admin Notification) ---
    const adminMailOptions = {
        from: 'dinhtu20091998@gmail.com',
        to: MY_PERSONAL_EMAIL,
        subject: `[LIÊN HỆ MỚI] ${subject}`,
        html: `
            <h2>Thông tin liên hệ mới</h2>
            <p><strong>Thời gian:</strong> ${new Date(timestamp).toLocaleString('vi-VN')}</p>
            <p><strong>Người gửi:</strong> ${name}</p>
            <p><strong>Email:</strong> ${email}</p>
            <p><strong>Chủ đề:</strong> ${subject}</p>
            <hr>
            <h3>Nội dung:</h3>
            <p style="white-space: pre-wrap;">${message}</p>
            <p>Vui lòng phản hồi sớm cho khách hàng.</p>
        `
    };

    // --- 3. Cấu hình Email xác nhận gửi cho Người dùng (Auto-Reply) ---
    const userMailOptions = {
        from: 'dinhtu20091998@gmail.com',
        to: email,
        subject: `[Xác nhận] Cảm ơn bạn đã liên hệ: ${subject}`,
        html: `
            <p>Chào ${name},</p>
            <p>Cảm ơn bạn đã liên hệ. Tôi đã nhận được tin nhắn của bạn và sẽ phản hồi trong vòng 24 giờ làm việc.</p>
            <p>Thông tin bạn đã gửi:</p>
            <ul>
                <li>Chủ đề: ${subject}</li>
                <li>Nội dung: <span style="white-space: pre-wrap;">${message}</span></li>
            </ul>
            <p>Trân trọng,</p>
            <p>Nguyễn Đình Tú</p>
        `
    };

    // ⬅️ ĐÃ KHÔI PHỤC: Khối try...catch để ngăn chặn server crash
    try {
        await transporter.sendMail(adminMailOptions);
        console.log(`[EMAIL] Thông báo gửi đến Admin (${MY_PERSONAL_EMAIL}) thành công.`);

        await transporter.sendMail(userMailOptions);
        console.log(`[EMAIL] Xác nhận gửi đến Người dùng (${email}) thành công.`);

        // Trả lời thành công về Frontend (Vue.js)
        res.status(200).json({ message: 'Message received, saved, and emails sent successfully!' });

    } catch (error) {
        // Lỗi 500 sẽ xảy ra ở đây, nhưng Server vẫn sống
        console.error('LỖI GỬI EMAIL (EAUTH/ETIMEDOUT):', error);
        res.status(500).json({ error: 'Gửi email thất bại. Vui lòng kiểm tra Mật khẩu Ứng dụng/Kết nối mạng.', details: error.message });
    }
});

// Khởi chạy Server
app.listen(port, () => {
    console.log(`Backend Server đang chạy tại http://localhost:${port}`);
    console.log('Server này sẵn sàng xử lý các yêu cầu POST /messages từ Frontend.');
});
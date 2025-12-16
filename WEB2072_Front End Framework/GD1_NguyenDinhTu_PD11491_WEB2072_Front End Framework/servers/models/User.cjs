// servers/models/User.cjs (Đã sửa lỗi cú pháp)

const mongoose = require("mongoose");

const UserSchema = new mongoose.Schema({
    // ĐỐI SỐ THỨ NHẤT: ĐỊNH NGHĨA CÁC TRƯỜNG (FIELDS)
    username: { type: String, required: true, unique: true },
    password: { type: String, required: true },
    role: { type: String, default: 'guest' }
}, { 
    // ĐỐI SỐ THỨ HAI: TÙY CHỌN SCHEMA (OPTIONS)
    toJSON: {
        virtuals: true, // Kích hoạt virtual fields (bao gồm 'id')
        transform: (doc, ret) => {
            delete ret._id; // Xóa _id khi trả về JSON
            delete ret.__v;
        }
    }
});

module.exports = mongoose.model("User", UserSchema);
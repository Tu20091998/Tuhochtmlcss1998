// servers/models/Message.cjs

const mongoose = require("mongoose");

const MessageSchema = new mongoose.Schema({
    name: { type: String, required: true },
    email: { type: String, required: true },
    subject: String,
    message: { type: String, required: true },
    timestamp: { type: Date, default: Date.now },
}, { 
    // ĐỐI SỐ THỨ HAI: TÙY CHỌN SCHEMA (OPTIONS)
    toJSON: {
        virtuals: true, // Kích hoạt trường 'id' ảo
        transform: (doc, ret) => {
            delete ret._id; // Xóa _id khi trả về JSON
            delete ret.__v;
        }
    }
});

module.exports = mongoose.model("Message", MessageSchema);
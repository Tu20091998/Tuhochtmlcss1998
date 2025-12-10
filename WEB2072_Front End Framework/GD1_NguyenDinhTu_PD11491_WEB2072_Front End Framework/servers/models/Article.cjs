// servers/models/Article.cjs

const mongoose = require("mongoose");

const ArticleSchema = new mongoose.Schema({
    //  ĐỊNH NGHĨA CÁC TRƯỜNG (FIELDS)
    title: { type: String, required: true },
    summary: String,
    content: { type: String, required: true },
    date: String,
    image: String,
    status: { type: String, enum: ['Published', 'Draft'], default: 'Draft' },
    createdAt: { type: Date, default: Date.now },
    updatedAt: Date
}, { 
    //  TÙY CHỌN SCHEMA (OPTIONS) sửa lại dữ liệu trước khi trả về 
    toJSON: {
        virtuals: true, // Kích hoạt trường 'id' ảo
        transform: (doc, ret) => {
            // Xóa các trường không cần thiết khi trả về API
            delete ret._id;
            delete ret.__v;
        }
    }
});

module.exports = mongoose.model("Article", ArticleSchema);
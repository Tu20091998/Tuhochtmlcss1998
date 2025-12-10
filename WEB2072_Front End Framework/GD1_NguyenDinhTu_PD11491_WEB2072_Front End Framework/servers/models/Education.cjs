// servers/models/Education.cjs

const mongoose = require("mongoose");

const EducationSchema = new mongoose.Schema({
    institution: { type: String, required: true },
    address: String,
    degree: String,
    period: String,
    details: String
}, { 
    // TÙY CHỌN SCHEMA (OPTIONS) 
    toJSON: {
        virtuals: true, // Kích hoạt trường 'id' ảo
        transform: (doc, ret) => {
            delete ret._id; // Xóa _id khi trả về JSON
            delete ret.__v;
        }
    }
});

module.exports = mongoose.model("Education", EducationSchema);
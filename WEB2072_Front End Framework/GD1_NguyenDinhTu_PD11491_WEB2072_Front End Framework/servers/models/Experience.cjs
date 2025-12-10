// servers/models/Experience.cjs

const mongoose = require("mongoose");

const ExperienceSchema = new mongoose.Schema({
    title: { type: String, required: true },
    company: String,
    period: String,
    description: String
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

module.exports = mongoose.model("Experience", ExperienceSchema);
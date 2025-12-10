// servers/models/Project.cjs

const mongoose = require("mongoose");

const ProjectSchema = new mongoose.Schema({
    name: { type: String, required: true },
    tech: [String],
    members: Number,
    duration: String,
    image: String,
    description: String,
    startDate: Date,
    endDate: Date,
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

module.exports = mongoose.model("Project", ProjectSchema);
// servers/mongo.js

const mongoose = require("mongoose");

// Chuỗi kết nối
const MONGO_URI = "mongodb://127.0.0.1:27017/portfolio"; 

// Hàm kết nối
const connectDB = async () => {
    try {
        await mongoose.connect(MONGO_URI);
        console.log("MongoDB connected successfully!");
    } catch (err) {
        console.error("MongoDB connection failed:", err);
        // Thoát ứng dụng nếu không kết nối được
        process.exit(1);
    }
};

module.exports = connectDB;



// servers/seeder.js

const fs = require('fs');
const connectDB = require('./mongo.cjs'); // Lấy hàm kết nối DB

// 1. Import các Models (dùng để thao tác với MongoDB)
const Article = require('./models/Article.cjs');
const Project = require('./models/Project.cjs');
const Education = require('./models/Education.cjs');
const Experience = require('./models/Experience.cjs');
const User = require('./models/User.cjs');
const Profile = require('./models/Profile.cjs'); // <-- THÊM MỚI
const Message = require('./models/Message.cjs'); // <-- THÊM MỚI

// 2. Kết nối đến Database
connectDB(); 

// 3. Đọc dữ liệu từ db.json
// Đường dẫn: servers/seeder.js -> lên 1 cấp (servers/) -> ra thư mục gốc -> tìm db.json
const data = JSON.parse(
    fs.readFileSync(`${__dirname}/../db.json`, 'utf-8') 
);

// 4. Hàm Chèn Dữ liệu (Import)
const importData = async () => {
    try {
        // Xóa dữ liệu cũ (đảm bảo không bị trùng lặp khi chạy lại)
        await Article.deleteMany();
        await Project.deleteMany();
        await Education.deleteMany();
        await Experience.deleteMany();
        await User.deleteMany();
        await Profile.deleteMany(); // <-- THÊM MỚI
        await Message.deleteMany(); // <-- THÊM MỚI

        // Chèn dữ liệu mới từ db.json vào các Collections tương ứng
        await Article.insertMany(data.articles);
        await Project.insertMany(data.projects);
        await Education.insertMany(data.education);
        await Experience.insertMany(data.experience);
        // Lưu ý: Chúng ta giả định mảng 'users' trong db.json chứa cả Personal data
        await User.insertMany(data.users); 
        await Profile.create(data.personal); // <-- THAY VÌ insertMany, DÙNG create
        await Message.insertMany(data.messages); // <-- THÊM MỚI

        console.log('✅ Dữ liệu đã được chèn vào MongoDB thành công!');
        process.exit();
    } catch (err) {
        console.error('❌ LỖI KHI CHÈN DỮ LIỆU:', err);
        process.exit(1);
    }
};


// 5. Chạy Script (chỉ chạy khi có tham số -i)
// Sử dụng: node servers/seeder.js -i
if (process.argv[2] === '-i') {
    importData();
} else {
    console.log('Vui lòng chạy lệnh: node servers/seeder.js -i để Import dữ liệu.');
    process.exit(1);
}